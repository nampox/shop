# 🛒 Laravel Shop Project

Hệ thống quản lý shop được xây dựng với Laravel 12, PHP 8.2, MySQL 8.0 và các công nghệ hiện đại.

## 📋 Mục lục

- [Yêu cầu hệ thống](#yêu-cầu-hệ-thống)
- [Cài đặt với Docker](#cài-đặt-với-docker)
- [Cấu hình Database](#cấu-hình-database)
- [Chạy Migrations và Seeders](#chạy-migrations-và-seeders)
- [Tài khoản Admin](#tài-khoản-admin)

## 🔧 Yêu cầu hệ thống

- Docker Desktop
- Docker Compose (thường đi kèm với Docker Desktop)
- Git

## 🐳 Cài đặt với Docker

### Bước 1: Clone repository

```bash
git clone <repository-url>
cd shop
```

### Bước 2: Tạo file .env

```bash
# Copy file .env.example (nếu có) hoặc tạo file .env mới
cp .env.example .env  # Nếu có file .env.example
# Hoặc tạo file .env thủ công với nội dung cơ bản
```

**Nội dung file .env tối thiểu:**

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=shop
DB_USERNAME=shop
DB_PASSWORD=password
```

### Bước 3: Khởi động Docker containers

```bash
# Build và khởi động tất cả services
docker-compose up -d --build

# Xem logs để kiểm tra
docker-compose logs -f app
```

### Bước 4: Chạy migrations và seeders

```bash
# Vào container app
docker-compose exec app sh

# Chạy migrations
php artisan migrate

# Chạy seeders (tạo roles và admin user)
php artisan db:seed
```

## 🗄️ Cấu hình Database

- **Type**: MySQL 8.0
- **Host**: `mysql` (trong Docker)
- **Port**: `3306`
- **Database**: `shop`
- **Username**: `shop`
- **Password**: `password`

## 🔄 Chạy Migrations và Seeders

### Chạy migrations

```bash
docker-compose exec app php artisan migrate
```

### Chạy seeders

```bash
docker-compose exec app php artisan db:seed
```

## 👤 Tài khoản Admin

Sau khi chạy `docker-compose exec app php artisan db:seed`, tài khoản admin sẽ được tạo tự động:

- **Email**: `admin@gmail.com`
- **Password**: `admin`
- **Role**: Admin (có quyền truy cập CMS)

## 🛠️ Tech Stack

- **Backend Framework**: Laravel 12
- **PHP Version**: 8.2
- **Database**: MySQL 8.0
- **Cache**: Redis
- **Frontend**: 
  - Bootstrap 5.3.3
  - Bootstrap Icons
  - SweetAlert2
  - Animate.css
- **JavaScript**: 
  - Vanilla JS
  - Custom Multi-Select Component
  - Custom Autocomplete Component

**Lưu ý**: Chỉ role ID 2-9 mới có quyền truy cập CMS (theo middleware `cms.access`).

## 📝 Notes

- File `.env` không được commit vào git (đã có trong `.gitignore`)
- Storage và cache folders cần có quyền ghi
- Luôn chạy migrations và seeders sau khi clone project
- Docker sẽ tự động cài đặt dependencies và build khi khởi động
