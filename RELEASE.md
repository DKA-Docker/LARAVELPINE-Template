# Release Notes - Infrastructure Upgrade (Longhorn & High Availability)

## Summary of Changes
Migrasi infrastruktur penyimpanan dari Local HostPath ke Distributed Longhorn Storage untuk mendukung High Availability dan Horizontal Scaling.

### 1. Storage Engine Upgrade
- **Old**: `hostPath` (Data terikat di satu server fisik saja).
- **New**: **Longhorn Distributed Storage**.
  - **Benefit**: Data menjadi portable. Jika VM/Node mati, volume penyimpanan otomatis dipindahkan (attach/mount) ke VM yang hidup. Data aman dan tidak hilang.

### 2. High Availability (HA) & Scaling
- **Web Application (Logistech App)**:
  - **Status**: **Multi-Active (Zero Downtime)**.
  - **Storage**: Menggunakan mode **ReadWriteMany (RWX)**. Memungkinkan banyak Pod di server berbeda membaca satu storage yang sama (folder upload).
  - **Topology**: Terkonfigurasi dengan `topologySpreadConstraints` untuk memaksa Pod menyebar ke Node/VM yang berbeda (Cross-Node).
  - **Failover**: Jika satu VM mati, layanan TETAP HIDUP karena ada replica di VM lain.

- **Database (PostgreSQL)**:
  - **Status**: **Self-Healing Failover**.
  - **Storage**: Tetap menggunakan mode **ReadWriteOnce (RWO)** demi keamanan konsistensi data.
  - **Failover**: Jika VM Database mati, Kubernetes akan otomatis me-reschedule Pod ke VM lain dalam waktu +/- 5 menit. Data tidak hilang, hanya ada downtime koneksi sementara saat proses pindah.

---

## Kubernetes Cheat Sheet (Fungsi Penting)

### 1. Cek Status & Penyebaran (Cross-Node Verify)
Untuk memastikan Pod Web tersebar di VM berbeda (misal: `appc-prod-logistech` dan `appc-prod-hgs-b2b`):
```bash
kubectl get pods -n hgs-logistik -o wide
```

### 2. Cek Status Storage Longhorn
Pastikan status PVC adalah `Bound`. Untuk Storage App harus `RWX`, Database harus `RWO`.
```bash
kubectl get pvc -n hgs-logistik
```

### 3. Scaling Manual
Menambah/mengurangi jumlah replica aplikasi (misal jadi 3 pod):
```bash
kubectl scale deployment logistik-app --replicas=3 -n hgs-logistik
```

### 4. Restart Aplikasi (Tanpa Downtime)
Jika config berubah dan butuh refresh pod:
```bash
kubectl rollout restart deployment logistik-app -n hgs-logistik
```

### 5. Troubleshooting Migrasi
Jika Pod stuck `ContainerCreating` karena masalah volume:
- Cek apakah `iscsid` service jalan di worker node.
- Cek logs: `kubectl describe pod <nama-pod> -n hgs-logistik`
