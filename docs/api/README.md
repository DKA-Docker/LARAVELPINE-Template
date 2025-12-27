# API Documentation - HND Logistech

Dokumentasi API lengkap untuk HND Logistech - Logistics and Delivery Management System.

## 📄 OpenAPI Specification

File **openapi.json** berisi spesifikasi lengkap API dalam format OpenAPI 3.0.3.

### Fitur OpenAPI Spec

- ✅ Semua endpoint terdokumentasi lengkap
- ✅ Request & Response schemas dengan contoh
- ✅ Authentication scheme (Bearer Token)
- ✅ Query parameters untuk pagination, search, sorting
- ✅ Error responses untuk setiap endpoint
- ✅ Data models dengan validasi

## 🚀 Cara Menggunakan

### 1. Swagger UI (Recommended)

Visualisasi interaktif dengan Swagger UI:

```bash
# Install Swagger UI Watcher
npm install -g swagger-ui-watcher

# Jalankan Swagger UI
cd docs/api
swagger-ui-watcher openapi.json
```

Buka browser di `http://localhost:8000` untuk melihat dokumentasi interaktif.

### 2. Redoc

Alternatif dengan Redoc untuk dokumentasi yang lebih clean:

```bash
# Install Redoc CLI
npm install -g redoc-cli

# Generate HTML documentation
redoc-cli bundle openapi.json -o api-docs.html

# Buka api-docs.html di browser
```

### 3. Postman

Import OpenAPI spec ke Postman:

1. Buka Postman
2. Klik **Import**
3. Pilih file `openapi.json`
4. Semua endpoint akan ter-import otomatis

> **💡 Tip**: Untuk Postman collection yang sudah siap pakai, gunakan file di `../postman/`

### 4. VS Code Extension

Install extension **OpenAPI (Swagger) Editor** di VS Code:

1. Install extension: `42Crunch.vscode-openapi`
2. Buka file `openapi.json`
3. Preview dengan `Ctrl+Shift+P` → "OpenAPI: Show Preview"

## 📚 Struktur API

### Base URL

- **Local**: `http://localhost:8000/api`
- **Staging**: `https://staging-api.hndlogistech.com/api`
- **Production**: `https://api.hndlogistech.com/api`

### Endpoints Overview

#### 🔐 Authentication
- `POST /auth` - Login
- `GET /auth` - Verify Token
- `DELETE /auth` - Logout

#### 📦 Delivery Requests
- `GET /dashboards/apps/deliveries/requests` - List
- `POST /dashboards/apps/deliveries/requests` - Create
- `PATCH /dashboards/apps/deliveries/requests/{id}` - Update
- `DELETE /dashboards/apps/deliveries/requests/{id}` - Delete
- `GET /dashboards/apps/deliveries/requests/destinations` - List Destinations

#### 📋 Delivery Tasks
- `GET /dashboards/apps/deliveries/tasks` - List Tasks
- `GET /dashboards/apps/deliveries/tasks/routes` - List Routes

#### 📊 Delivery Reports
- `GET /dashboards/apps/deliveries/reports` - List Reports

#### 📍 Tracking Monitors
- `GET /dashboards/apps/trackings/monitors` - List Monitors
- `POST /dashboards/apps/trackings/monitors` - Create Monitor Record

#### 🚨 Tracking Alarms
- `GET /dashboards/apps/trackings/alarms` - List Alarms

#### 👥 Account Management
- `GET /dashboards/managements/accounts` - List Accounts (Admin)

#### 👤 Base Account
- `GET /base/accounts` - Get Current Account
- `PATCH /base/accounts/firebase` - Update Firebase Token

## 🔐 Authentication

Semua endpoint (kecuali login) memerlukan Bearer Token authentication.

### Cara Mendapatkan Token

```bash
curl -X POST "http://localhost:8000/api/auth" \
  -H "Content-Type: application/json" \
  -d '{
    "username": "admin",
    "password": "password123"
  }'
```

Response:
```json
{
  "status": true,
  "code": 200,
  "msg": "Login successful",
  "token": "1|abcdef123456789...",
  "token_type": "Bearer"
}
```

### Menggunakan Token

Sertakan token di header `Authorization`:

```bash
curl -X GET "http://localhost:8000/api/dashboards/apps/deliveries/requests" \
  -H "Authorization: Bearer 1|abcdef123456789..." \
  -H "Content-Type: application/json"
```

## 📊 Response Format

### Success Response

```json
{
  "status": true,
  "code": 200,
  "msg": "Success message",
  "data": { /* response data */ },
  "meta": {
    "count": {
      "current": 15,
      "total": 150
    }
  }
}
```

### Error Response

```json
{
  "status": false,
  "code": 422,
  "msg": "Validation Error",
  "errors": {
    "field_name": ["Error detail"]
  }
}
```

### HTTP Status Codes

- `200` - Success
- `401` - Unauthorized (token invalid/expired)
- `403` - Forbidden (insufficient permissions)
- `404` - Not Found
- `422` - Validation Error

## 🛠️ Generate API Client

Generate API client untuk berbagai bahasa programming:

### TypeScript/JavaScript

```bash
# Install OpenAPI Generator
npm install @openapitools/openapi-generator-cli -g

# Generate TypeScript Axios client
openapi-generator-cli generate \
  -i openapi.json \
  -g typescript-axios \
  -o ./generated/typescript-client

# Generate TypeScript Fetch client
openapi-generator-cli generate \
  -i openapi.json \
  -g typescript-fetch \
  -o ./generated/typescript-fetch-client
```

### PHP

```bash
# Generate PHP client
openapi-generator-cli generate \
  -i openapi.json \
  -g php \
  -o ./generated/php-client
```

### Python

```bash
# Generate Python client
openapi-generator-cli generate \
  -i openapi.json \
  -g python \
  -o ./generated/python-client
```

### Dart/Flutter

```bash
# Generate Dart client untuk Flutter
openapi-generator-cli generate \
  -i openapi.json \
  -g dart \
  -o ./generated/dart-client
```

### Kotlin (Android)

```bash
# Generate Kotlin client
openapi-generator-cli generate \
  -i openapi.json \
  -g kotlin \
  -o ./generated/kotlin-client
```

## 📝 Validation

OpenAPI spec ini sudah divalidasi dengan:

- ✅ OpenAPI 3.0.3 specification
- ✅ Semua endpoint dari routes/api.php
- ✅ Request/Response schemas lengkap
- ✅ Authentication scheme
- ✅ Error handling
- ✅ Examples untuk semua endpoint

### Validasi Manual

Untuk validasi spec secara manual:

```bash
# Install validator
npm install -g @apidevtools/swagger-cli

# Validate OpenAPI spec
swagger-cli validate openapi.json
```

## 🔄 Update Documentation

Jika ada perubahan pada API:

1. Update file `openapi.json`
2. Validasi dengan `swagger-cli validate openapi.json`
3. Test dengan Swagger UI
4. Commit changes ke repository

## 📚 Resources

### Tools
- [Swagger Editor](https://editor.swagger.io/) - Online editor
- [Swagger UI](https://swagger.io/tools/swagger-ui/) - Interactive documentation
- [Redoc](https://redocly.com/) - Beautiful API documentation
- [OpenAPI Generator](https://openapi-generator.tech/) - Generate clients

### Documentation
- [OpenAPI Specification](https://swagger.io/specification/)
- [OpenAPI Guide](https://swagger.io/docs/specification/about/)
- [Best Practices](https://swagger.io/blog/api-documentation/openapi-best-practices/)

## 🎯 Next Steps

### 1. Setup Swagger UI di Laravel

```bash
composer require darkaonline/l5-swagger
php artisan l5-swagger:generate
```

Akses di: `http://localhost:8000/api/documentation`

### 2. Add API Versioning

Tambahkan versioning untuk future-proofing:
- `/api/v1/auth`
- `/api/v2/auth`

### 3. Add Rate Limiting

Dokumentasikan rate limits:
- Headers: `X-RateLimit-Limit`, `X-RateLimit-Remaining`
- Response 429: Too Many Requests

### 4. Add Webhooks

Dokumentasikan webhook events:
- Delivery status updates
- Tracking alerts
- Task assignments

### 5. Add WebSocket Documentation

Dokumentasikan Laravel Reverb channels:
- Real-time tracking updates
- Notification broadcasts

## 📞 Support

Untuk pertanyaan atau issue:
- Email: support@hndtech.com
- Documentation: [openapi.json](./openapi.json)
- Postman Collection: [../postman/](../postman/)

---

**Last Updated**: 2025-12-28  
**Version**: 1.0.0  
**OpenAPI Version**: 3.0.3
