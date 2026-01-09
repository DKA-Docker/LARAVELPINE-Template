# System Architecture: Kubernetes High Availability with Longhorn

## 1. High-Level Topology (Cross-Node Scaling)

Sistem Anda saat ini berjalan di atas cluster Kubernetes dengan 2 Worker Node. Konfigurasi "Cross" (Silang) memastikan bahwa setiap aplikasi memiliki setidaknya satu replika yang berjalan di setiap fisik server (VM).

```mermaid
graph TD
    User((User Traffic)) --> Service[K8s Service LoadBalancer]
    
    subgraph Node_A ["Node 1: appc-prod-logistech (VM A)"]
        style Node_A fill:#e1f5fe,stroke:#01579b
        WebApp_1[Web App Pod 1]
        B2BApp_1[B2B App Pod 1]
        DB_Logistik[(Logistik DB Pod)]
    end

    subgraph Node_B ["Node 2: appc-prod-hgs-b2b (VM B)"]
        style Node_B fill:#e1f5fe,stroke:#01579b
        WebApp_2[Web App Pod 2]
        B2BApp_2[B2B App Pod 2]
        DB_B2B[(B2B DB Pod)]
    end

    Service --> WebApp_1
    Service --> WebApp_2
    Service --> B2BApp_1
    Service --> B2BApp_2

    %% Storage connections
    WebApp_1 -.--> StorageUploads
    WebApp_2 -.--> StorageUploads
    DB_Logistik <--> StorageDB_Log
    DB_B2B <--> StorageDB_B2B

    subgraph Storage_Layer ["Longhorn Distributed Storage"]
        style Storage_Layer fill:#fff3e0,stroke:#e65100
        StorageUploads[RWX Volume: Uploads/Assets]
        StorageDB_Log[RWO Volume: Logistik Data]
        StorageDB_B2B[RWO Volume: B2B Data]
    end
```

## 2. Storage Architecture (The "Magic" Behind Migration)

Perubahan terbesar yang baru saja kita lakukan adalah mengganti **Local HostPath** menjadi **Longhorn Distributed Storage**.

### A. Shared Assets (RWX - ReadWriteMany)
- **Digunakan oleh:** Web Application & B2B App (Folder `/public/uploads` atau `/assets`).
- **Teknologi:** Menggunakan NFS/iSCSI di atas Longhorn.
- **Mekanisme:** Longhorn membuat satu "Virtual Disk" besar yang bisa di-mount oleh Pod di Node A dan Pod di Node B secara bersamaan.
- **Benefit:** User upload foto profil di Node A, user yang mengakses lewat Node B langsung bisa melihat fotonya.

### B. Database Storage (RWO - ReadWriteOnce)
- **Digunakan oleh:** PostgreSQL & MariaDB.
- **Teknologi:** Block Storage Standard.
- **Mekanisme:** "Virtual Disk" ini hanya boleh dicolok ke **satu** Pod dalam satu waktu demi keamanan data (menghindari *data corruption*).
- **Benefit:** Performa I/O stabil dan konsistensi data terjamin.

## 3. Failover Scenarios (Apa yang terjadi jika server mati?)

### Skenario 1: VM A Mati (Web Server Down)
1.  **Deteksi:** Load Balancer Kubernetes mendeteksi WebApp_1 di Node A tidak merespon.
2.  **Action:** Traffic otomatis dialihkan 100% ke WebApp_2 di Node B.
3.  **Impact:** **Zero Downtime**. User tidak merasakan gangguan.

### Skenario 2: VM B Mati (Database Server Down)
1.  **Deteksi:** Kubernetes mendeteksi Node B hilang kontak (~5 menit timeout).
2.  **Action:**
    *   Kubernetes menjadwalkan ulang (reschedule) `DB_B2B` untuk pindah ke Node A.
    *   Longhorn secara otomatis "mencabut" disk `StorageDB_B2B` dari Node B dan "memasangnya" ke Node A.
    *   Database booting ulang di Node A.
3.  **Impact:** **Downtime +/- 5 Menit**. Selama proses pemindahan, aplikasi B2B tidak bisa connect ke database. Setelah database nyala di Node A, semua kembali normal.

---
**Kesimpulan:**
Arsitektur ini menggabungkan **kelincahan** (Stateless App di-scale horizontal) dengan **keamanan data** (Stateful DB di-handle dengan block storage portable). Ini adalah standar industri modern untuk "Cloud Native Infrastructure".
