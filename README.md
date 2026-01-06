# HND Logistech Web Application

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](https://opensource.org/licenses/MIT)

Sistem manajemen logistik dan pengiriman yang komprehensif dengan kemampuan pelacakan real-time.

## 🚀 Fitur Utama

- **🔐 Authentication & Authorization**
  - Login/Logout dengan Laravel Sanctum
  - Role-based access control (Spatie Permission)
  - Firebase Cloud Messaging integration

- **📦 Delivery Management**
  - Create delivery requests dengan multiple destinations
  - Package management per destination
  - Task assignment ke drivers
  - Route optimization
  - Delivery history tracking

- **📍 Real-time Tracking**
  - GPS tracking dari mobile devices
  - Real-time location updates via WebSocket (Laravel Reverb)
  - Tracking alarms & notifications
  - Mapbox integration untuk visualisasi

- **📊 Reporting**
  - Delivery reports dengan filter tanggal
  - Distance & duration tracking
  - Task completion status

- **🗺️ Geographic Data**
  - Indonesia geographic hierarchy (Province → Regency → District → Village)
  - Address geocoding

## 🛠️ Tech Stack

### Backend
- **Laravel 12** - PHP Framework
- **Laravel Sanctum** - API Authentication
- **Laravel Livewire 3.6** - Dynamic UI
- **Laravel Reverb** - WebSocket Server
- **Spatie Laravel Permission** - Role & Permission Management
- **Firebase Cloud Messaging** - Push Notifications

### 🧠 Intelligent Architecture
> [!IMPORTANT]
> Project ini menggunakan standar arsitektur **"World-Class"** yang didokumentasikan di `.aicontext.md`.

*   **Service Layer**: Manual Repo Instantiation, Strict Transactions.
*   **Deep Migrations**: Folder-matching Table Names (`apps/deliveries/requests` -> `apps_deliveries_requests`).
*   **Frontend**: Strict JS Execution Guards & Livewire Coupling.
*   **Generative Rules**: Standardized "Scaffolding" for new modules.

Referensi Lengkap: **[.aicontext.md](./.aicontext.md)**

### Frontend
- **TypeScript** - Type-safe JavaScript
- **TypeScript** - Type-safe JavaScript
- **Vite** - Build Tool
- **TailwindCSS 4.0** - Utility-first CSS
- **Alpine.js** - Lightweight JavaScript
- **Mapbox GL** - Real-time Map Visualization
- **ApexCharts** - Data Visualization

### Database
- **SQLite** (Development)
- **PostgreSQL/MySQL** (Production Ready)

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- NPM/Yarn
- SQLite/PostgreSQL/MySQL

## 🚀 Installation

### 1. Clone Repository

```bash
git clone <repository-url>
cd WEB_LOGISTECH
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
# atau
yarn install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

```bash
# Run migrations
php artisan migrate

# (Optional) Seed database
php artisan db:seed
```

### 5. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 6. Run Application

```bash
# Development server
php artisan serve

# Atau gunakan composer script
composer run dev
```

Aplikasi akan berjalan di `http://localhost:8000`

## 📚 API Documentation

Dokumentasi API lengkap tersedia dalam format OpenAPI 3.0 dan Postman Collection.

### Quick Start

#### Menggunakan Postman

1. Import collection dari `docs/postman/HND-Logistech-API.postman_collection.json`
2. Import environment dari `docs/postman/HND-Logistech-Local.postman_environment.json`
3. Jalankan request **Login** untuk mendapatkan token
4. Token akan otomatis tersimpan dan siap digunakan

#### Menggunakan OpenAPI/Swagger

```bash
# Install Swagger UI
npm install -g swagger-ui-watcher

# Run Swagger UI
cd docs/api
swagger-ui-watcher openapi.json
```

Buka browser di `http://localhost:8000`

### Dokumentasi Lengkap

- **[API Documentation](./docs/api/)** - OpenAPI 3.0 Specification
- **[Postman Collection](./docs/postman/)** - Ready-to-use Postman Collection
- **[Complete Documentation](./docs/)** - Overview semua dokumentasi

### API Endpoints

#### Authentication
```
POST   /api/auth          # Login
GET    /api/auth          # Verify Token
DELETE /api/auth          # Logout
```

#### Delivery Management
```
GET    /api/dashboards/apps/deliveries/requests          # List Requests
POST   /api/dashboards/apps/deliveries/requests          # Create Request
PATCH  /api/dashboards/apps/deliveries/requests/{id}     # Update Request
DELETE /api/dashboards/apps/deliveries/requests/{id}     # Delete Request

GET    /api/dashboards/apps/deliveries/tasks             # List Tasks
GET    /api/dashboards/apps/deliveries/reports           # List Reports
```

#### Real-time Tracking
```
GET    /api/dashboards/apps/trackings/monitors           # List Monitors
POST   /api/dashboards/apps/trackings/monitors           # Create Monitor
GET    /api/dashboards/apps/trackings/alarms             # List Alarms
```

#### Account Management
```
GET    /api/dashboards/managements/accounts              # List Accounts (Admin)
GET    /api/base/accounts                                # Get Current Account
PATCH  /api/base/accounts/firebase                       # Update Firebase Token
```

## 🔐 Authentication

API menggunakan Laravel Sanctum bearer token authentication.

### Login

```bash
curl -X POST "http://localhost:8000/api/auth" \
  -H "Content-Type: application/json" \
  -d '{
    "username": "admin",
    "password": "password123"
  }'
```

### Menggunakan Token

```bash
curl -X GET "http://localhost:8000/api/dashboards/apps/deliveries/requests" \
  -H "Authorization: Bearer {your-token}" \
  -H "Content-Type: application/json"
```

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run with coverage
php artisan test --coverage
```

## 📦 Deployment

### Production Build

```bash
# Build assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Docker (Optional)

```bash
# Development
docker-compose up -d

# Staging
docker-compose -f compose.staging.yml up -d
```

## 🔧 Development

### Code Style

```bash
# PHP (Laravel Pint)
./vendor/bin/pint

# JavaScript/TypeScript (Prettier)
npm run format
```

### Database

```bash
# Create migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback
php artisan migrate:rollback

# Fresh migration with seed
php artisan migrate:fresh --seed
```

### Queue & Jobs

```bash
# Run queue worker
php artisan queue:work

# Run scheduler
php artisan schedule:work
```

### WebSocket (Reverb)

```bash
# Start Reverb server
php artisan reverb:start

# Development with watch
php artisan reverb:start --debug
```

## 📁 Project Structure

```
WEB_LOGISTECH/
├── app/
│   ├── Console/         # Artisan commands
│   ├── Events/          # Event classes
│   ├── Http/
│   │   ├── Controllers/ # API & Web controllers
│   │   └── Middleware/  # Custom middleware
│   ├── Livewire/        # Livewire components
│   ├── Models/          # Eloquent models
│   ├── Repositories/    # Repository pattern
│   └── Services/        # Business logic
│
├── database/
│   ├── migrations/      # Database migrations
│   ├── seeders/         # Database seeders
│   └── factories/       # Model factories
│
├── docs/
│   ├── api/             # OpenAPI documentation
│   └── postman/         # Postman collection
│
├── resources/
│   ├── views/           # Blade templates
│   └── theme/           # Frontend assets
│
└── routes/
    ├── api.php          # API routes
    ├── web.php          # Web routes
    └── channels.php     # Broadcast channels
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Team

**HND Technology**
- Email: support@hndtech.com
- Website: [hndtech.com](https://hndtech.com)

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Livewire](https://livewire.laravel.com) - Dynamic UI
- [TailwindCSS](https://tailwindcss.com) - Utility-first CSS
- [Mapbox](https://mapbox.com) - Real-time Maps
- [Firebase](https://firebase.google.com) - Push Notifications

---

**Built with ❤️ by HND Technology Team**
