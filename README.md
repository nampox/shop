# 🛒 Laravel Shop Project

## 🐳 Chạy với Docker (Recommended)

### Yêu cầu
- Docker
- Docker Compose

### Quick Start

```bash
# 1. Đảm bảo có file .env (đã có sẵn)
# 2. Khởi động containers
docker-compose up -d --build

# 3. Truy cập ứng dụng
# Web: http://localhost:8000
# PhpMyAdmin: http://localhost:8080 (username: shop, password: password)
# Mailpit: http://localhost:8025
```

## 🗄️ Database

- **Type**: MySQL 8.0
- **Host**: mysql (trong Docker) / 127.0.0.1 (local)
- **Database**: shop
- **Username**: shop
- **Password**: password

## 🛠️ Tech Stack

- Laravel 12
- PHP 8.2
- MySQL 8.0
- Redis
- Vite + Tailwind CSS 4
