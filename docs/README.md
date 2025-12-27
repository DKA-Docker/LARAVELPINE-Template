# HND Logistech - API Documentation

Dokumentasi lengkap untuk HND Logistech API - Logistics and Delivery Management System with Real-time Tracking.

## 📁 Struktur Dokumentasi

```
docs/
├── api/
│   ├── openapi.json          # OpenAPI 3.0 Specification
│   └── README.md             # Panduan OpenAPI
│
└── postman/
    ├── HND-Logistech-API.postman_collection.json
    ├── HND-Logistech-Local.postman_environment.json
    ├── HND-Logistech-Staging.postman_environment.json
    ├── HND-Logistech-Production.postman_environment.json
    └── README.md             # Panduan Postman
```

## 🚀 Quick Start

### Untuk Developer

1. **Import Postman Collection**
   ```bash
   # Buka Postman
   # Import file: docs/postman/HND-Logistech-API.postman_collection.json
   # Import environment: docs/postman/HND-Logistech-Local.postman_environment.json
   ```

2. **Test API**
   ```bash
   # Login untuk mendapatkan token
   # Token akan otomatis tersimpan
   # Test endpoint lainnya
   ```

### Untuk Frontend Developer

1. **Generate TypeScript Client**
   ```bash
   npm install @openapitools/openapi-generator-cli -g
   
   openapi-generator-cli generate \
     -i docs/api/openapi.json \
     -g typescript-axios \
     -o ./src/api-client
   ```

2. **Gunakan di Project**
   ```typescript
   import { Configuration, AuthenticationApi } from './api-client';
   
   const config = new Configuration({
     basePath: 'http://localhost:8000/api',
     accessToken: 'your-token-here'
   });
   
   const authApi = new AuthenticationApi(config);
   const response = await authApi.login({ username: 'admin', password: 'pass' });
   ```

### Untuk Mobile Developer

1. **Generate Dart Client (Flutter)**
   ```bash
   openapi-generator-cli generate \
     -i docs/api/openapi.json \
     -g dart \
     -o ./lib/api-client
   ```

2. **Generate Kotlin Client (Android)**
   ```bash
   openapi-generator-cli generate \
     -i docs/api/openapi.json \
     -g kotlin \
     -o ./app/src/main/java/api-client
   ```

## 📚 Dokumentasi

### [API Documentation](./api/)

OpenAPI 3.0 specification dengan:
- Semua endpoint terdokumentasi
- Request/Response schemas
- Authentication scheme
- Examples untuk setiap endpoint

**Tools yang didukung:**
- Swagger UI
- Redoc
- Postman
- OpenAPI Generator

### [Postman Collection](./postman/)

Postman collection dengan:
- Nested folder structure
- Automatic token management
- 3 environment files (Local, Staging, Production)
- Pre-configured requests dengan examples

**Fitur:**
- Auto-save token setelah login
- Auto-clear token setelah logout
- Dynamic variables
- Response examples

## 🔐 Authentication

### Login

**Endpoint:** `POST /api/auth`

**Request:**
```json
{
  "username": "admin",
  "password": "password123"
}
```

**Response:**
```json
{
  "status": true,
  "code": 200,
  "msg": "Login successful",
  "token": "1|abcdef123456789...",
  "token_type": "Bearer",
  "user": { /* user data */ }
}
```

### Menggunakan Token

Sertakan token di header semua request:

```
Authorization: Bearer {token}
```

## 📊 API Endpoints Overview

### Authentication
- `POST /auth` - Login
- `GET /auth` - Verify Token
- `DELETE /auth` - Logout

### Delivery Management
- **Requests**: CRUD operations untuk delivery requests
- **Tasks**: Management delivery tasks dengan assignment
- **Routes**: Route planning dan optimization
- **Reports**: Delivery reports dengan filtering

### Real-time Tracking
- **Monitors**: GPS tracking data dari mobile devices
- **Alarms**: Tracking alerts dan notifications

### Account Management
- **Accounts**: User management (Admin only)
- **Base Account**: Current user profile dan Firebase token

## 🌍 Environments

### Local Development
```
Base URL: http://localhost:8000/api
Username: admin
Password: password123
```

### Staging
```
Base URL: https://staging-api.hndlogistech.com/api
Username: [Your staging credentials]
Password: [Your staging credentials]
```

### Production
```
Base URL: https://api.hndlogistech.com/api
Username: [Your production credentials]
Password: [Your production credentials]
```

## 🛠️ Tools & Resources

### Interactive Documentation

**Swagger UI:**
```bash
npm install -g swagger-ui-watcher
cd docs/api
swagger-ui-watcher openapi.json
```

**Redoc:**
```bash
npm install -g redoc-cli
redoc-cli bundle docs/api/openapi.json -o api-docs.html
```

### Code Generation

**OpenAPI Generator:**
```bash
npm install -g @openapitools/openapi-generator-cli

# List available generators
openapi-generator-cli list

# Generate client
openapi-generator-cli generate \
  -i docs/api/openapi.json \
  -g [generator-name] \
  -o ./output-directory
```

**Available Generators:**
- `typescript-axios` - TypeScript with Axios
- `typescript-fetch` - TypeScript with Fetch API
- `javascript` - JavaScript client
- `php` - PHP client
- `python` - Python client
- `dart` - Dart/Flutter client
- `kotlin` - Kotlin client
- `swift5` - Swift 5 client
- `java` - Java client

### Validation

**Validate OpenAPI Spec:**
```bash
npm install -g @apidevtools/swagger-cli
swagger-cli validate docs/api/openapi.json
```

## 📝 Response Format

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
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error

## 🎯 Common Use Cases

### 1. Create Delivery Request

```bash
curl -X POST "http://localhost:8000/api/dashboards/apps/deliveries/requests" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Delivery Request #001",
    "destinations": [
      {
        "address": "Jl. Sudirman No. 123, Jakarta",
        "latitude": -6.2088,
        "longitude": 106.8456,
        "packages": [
          {
            "name": "Package A",
            "weight": 5.5,
            "quantity": 2
          }
        ]
      }
    ]
  }'
```

### 2. Send GPS Tracking Data

```bash
curl -X POST "http://localhost:8000/api/dashboards/apps/trackings/monitors" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "status": true,
    "data": {
      "account_id": "user-uuid",
      "latitude": -6.2088,
      "longitude": 106.8456,
      "speed": 45.5,
      "heading": 180.0,
      "accuracy": 10.5,
      "timestamp": "2025-12-28T00:30:00+08:00"
    }
  }'
```

### 3. Get Delivery Reports

```bash
curl -X GET "http://localhost:8000/api/dashboards/apps/deliveries/reports?start_date=2025-12-01&end_date=2025-12-31" \
  -H "Authorization: Bearer {token}"
```

## 🔄 Update Documentation

Jika ada perubahan pada API:

1. **Update OpenAPI Spec**
   ```bash
   # Edit docs/api/openapi.json
   # Validate
   swagger-cli validate docs/api/openapi.json
   ```

2. **Update Postman Collection**
   ```bash
   # Export dari Postman
   # Replace docs/postman/HND-Logistech-API.postman_collection.json
   ```

3. **Regenerate Clients**
   ```bash
   # Regenerate semua API clients yang digunakan
   ```

4. **Commit Changes**
   ```bash
   git add docs/
   git commit -m "Update API documentation"
   git push
   ```

## 📞 Support

Untuk pertanyaan atau issue terkait API:

- **Email**: support@hndtech.com
- **Documentation**: 
  - OpenAPI: [docs/api/openapi.json](./api/openapi.json)
  - Postman: [docs/postman/](./postman/)

## 📖 Additional Resources

- [OpenAPI Specification](https://swagger.io/specification/)
- [Postman Documentation](https://learning.postman.com/docs/)
- [OpenAPI Generator](https://openapi-generator.tech/)
- [Swagger UI](https://swagger.io/tools/swagger-ui/)
- [Redoc](https://redocly.com/)

---

**Last Updated**: 2025-12-28  
**Version**: 1.0.0  
**Maintained by**: HND Technology Team
