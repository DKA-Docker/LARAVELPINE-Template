# Postman Collection - HND Logistech API

Dokumentasi lengkap untuk menggunakan Postman Collection HND Logistech API.

## 📁 File yang Tersedia

- **HND-Logistech-API.postman_collection.json** - Collection utama dengan semua endpoint
- **HND-Logistech-Local.postman_environment.json** - Environment untuk development lokal
- **HND-Logistech-Staging.postman_environment.json** - Environment untuk staging
- **HND-Logistech-Production.postman_environment.json** - Environment untuk production

## 🚀 Cara Import ke Postman

### 1. Import Collection

1. Buka Postman
2. Klik **Import** di pojok kiri atas
3. Drag & drop file `HND-Logistech-API.postman_collection.json` atau klik **Choose Files**
4. Klik **Import**

### 2. Import Environment

1. Klik icon **⚙️ (Settings)** di pojok kanan atas
2. Pilih tab **Environments**
3. Klik **Import**
4. Import ketiga file environment:
   - `HND-Logistech-Local.postman_environment.json`
   - `HND-Logistech-Staging.postman_environment.json`
   - `HND-Logistech-Production.postman_environment.json`

### 3. Pilih Environment

Di dropdown environment (pojok kanan atas), pilih environment yang ingin digunakan:
- **HND Logistech - Local** untuk development
- **HND Logistech - Staging** untuk staging
- **HND Logistech - Production** untuk production

## 📂 Struktur Collection

Collection ini terorganisir dengan struktur nested folder:

```
HND Logistech API/
├── Authentication/
│   ├── Login
│   ├── Verify Token
│   └── Logout
│
├── Dashboards/
│   ├── Apps/
│   │   ├── Deliveries/
│   │   │   ├── Requests/
│   │   │   │   ├── List Requests
│   │   │   │   ├── Create Request
│   │   │   │   ├── Update Request
│   │   │   │   ├── Delete Request
│   │   │   │   └── Destinations/
│   │   │   │       └── List Destinations
│   │   │   │
│   │   │   ├── Tasks/
│   │   │   │   ├── List Tasks
│   │   │   │   └── Routes/
│   │   │   │       └── List Routes
│   │   │   │
│   │   │   └── Reports/
│   │   │       └── List Reports
│   │   │
│   │   └── Trackings/
│   │       ├── Monitors/
│   │       │   ├── List Monitors
│   │       │   └── Create Monitor Record
│   │       │
│   │       └── Alarms/
│   │           └── List Alarms
│   │
│   └── Managements/
│       └── Accounts/
│           └── List Accounts
│
└── Base/
    └── Accounts/
        ├── Get Current Account
        └── Firebase/
            └── Update Firebase Token
```

## 🔐 Authentication Flow

### Automatic Token Management

Collection ini sudah dilengkapi dengan **automatic token management**:

1. **Login** → Token otomatis disimpan ke environment variable `access_token`
2. **Semua request lain** → Otomatis menggunakan token dari `{{access_token}}`
3. **Logout** → Token otomatis dihapus dari environment

### Manual Login

1. Buka folder **Authentication**
2. Klik request **Login**
3. Pastikan environment sudah dipilih
4. Klik **Send**
5. Token akan otomatis tersimpan dan siap digunakan untuk request lainnya

## 🌍 Environment Variables

### Local Environment

```json
{
  "base_url": "http://localhost:8000/api",
  "username": "admin",
  "password": "password123",
  "access_token": "",
  "user_id": "",
  "request_id": "",
  "task_id": "",
  "firebase_token": ""
}
```

### Staging Environment

```json
{
  "base_url": "https://staging-api.hndlogistech.com/api",
  "username": "",
  "password": "",
  "access_token": "",
  "user_id": "",
  "request_id": "",
  "task_id": "",
  "firebase_token": ""
}
```

### Production Environment

```json
{
  "base_url": "https://api.hndlogistech.com/api",
  "username": "",
  "password": "",
  "access_token": "",
  "user_id": "",
  "request_id": "",
  "task_id": "",
  "firebase_token": ""
}
```

> **⚠️ PENTING**: Untuk Staging dan Production, isi `username` dan `password` dengan credentials yang valid!

## 📝 Cara Menggunakan

### 1. Testing Authentication

```
1. Pilih environment "HND Logistech - Local"
2. Buka folder "Authentication" → "Login"
3. Klik "Send"
4. Lihat response, token akan otomatis tersimpan
5. Test "Verify Token" untuk memastikan token valid
```

### 2. Testing Delivery Requests

```
1. Pastikan sudah login (punya access_token)
2. Buka "Dashboards" → "Apps" → "Deliveries" → "Requests"
3. Test "List Requests" untuk melihat data
4. Test "Create Request" untuk membuat data baru
5. Copy ID dari response, simpan ke environment variable "request_id"
6. Test "Update Request" dan "Delete Request"
```

### 3. Testing Real-time Tracking

```
1. Buka "Dashboards" → "Apps" → "Trackings" → "Monitors"
2. Test "Create Monitor Record" untuk mengirim data GPS
3. Request body sudah menggunakan {{user_id}} dan {{$isoTimestamp}}
4. Test "List Monitors" untuk melihat history tracking
```

### 4. Testing Account Management

```
1. Buka "Base" → "Accounts"
2. Test "Get Current Account" untuk melihat info user yang login
3. Buka "Firebase" → "Update Firebase Token"
4. Isi {{firebase_token}} di environment atau langsung di body
5. Test untuk update FCM token
```

## 🔧 Tips & Tricks

### 1. Dynamic Variables

Postman menyediakan dynamic variables yang bisa digunakan:

- `{{$timestamp}}` - Unix timestamp
- `{{$isoTimestamp}}` - ISO 8601 timestamp
- `{{$randomUUID}}` - Random UUID
- `{{$randomInt}}` - Random integer

Contoh penggunaan di request body:
```json
{
  "timestamp": "{{$isoTimestamp}}",
  "id": "{{$randomUUID}}"
}
```

### 2. Save Response Data

Untuk menyimpan data dari response ke environment variable, tambahkan script di tab **Tests**:

```javascript
// Simpan request_id dari response
var jsonData = pm.response.json();
pm.environment.set("request_id", jsonData.data.id);
```

### 3. Pre-request Scripts

Untuk generate data sebelum request, gunakan tab **Pre-request Script**:

```javascript
// Generate random coordinates
pm.environment.set("latitude", (Math.random() * 180 - 90).toFixed(6));
pm.environment.set("longitude", (Math.random() * 360 - 180).toFixed(6));
```

### 4. Bulk Testing

Gunakan **Collection Runner** untuk test semua endpoint sekaligus:

1. Klik kanan pada collection "HND Logistech API"
2. Pilih **Run collection**
3. Pilih environment
4. Klik **Run HND Logistech API**

## 📊 Query Parameters

Semua list endpoints mendukung query parameters:

### Pagination
- `page` - Nomor halaman (default: 1)
- `per_page` - Jumlah item per halaman (default: 15, max: 100)

### Search & Sort
- `search` - Keyword pencarian
- `sort_by` - Field untuk sorting (default: created_at)
- `sort_order` - Urutan sorting: `asc` atau `desc` (default: desc)

### Date Filter (untuk Reports)
- `start_date` - Filter dari tanggal (format: YYYY-MM-DD)
- `end_date` - Filter sampai tanggal (format: YYYY-MM-DD)

**Contoh:**
```
GET {{base_url}}/dashboards/apps/deliveries/requests?page=2&per_page=20&search=jakarta&sort_order=asc
```

## 🐛 Troubleshooting

### Token Expired / 401 Unauthorized

**Solusi:**
1. Jalankan request **Login** lagi
2. Token baru akan otomatis tersimpan
3. Ulangi request yang gagal

### Environment Variable Kosong

**Solusi:**
1. Pastikan environment sudah dipilih di dropdown
2. Check apakah variable sudah terisi di environment settings
3. Untuk `access_token`, pastikan sudah login terlebih dahulu

### Request Gagal di Staging/Production

**Solusi:**
1. Pastikan `username` dan `password` sudah diisi di environment
2. Pastikan URL `base_url` sudah benar
3. Check koneksi internet dan firewall

## 📚 Dokumentasi Tambahan

- **OpenAPI Spec**: `../api/openapi.json`
- **API Documentation**: Lihat file `openapi.json` untuk detail lengkap semua endpoint
- **Walkthrough**: Lihat artifact walkthrough untuk panduan lengkap

## 🔄 Update Collection

Jika ada perubahan pada API:

1. Export collection terbaru dari Postman
2. Replace file `HND-Logistech-API.postman_collection.json`
3. Commit changes ke repository

## 📞 Support

Untuk pertanyaan atau issue:
- Email: support@hndtech.com
- Repository: [GitHub Repository URL]

---

**Last Updated**: 2025-12-28
**Version**: 1.0.0
