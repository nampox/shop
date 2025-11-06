# 🐳 Hướng dẫn chạy Project Laravel với Docker

## 📋 Yêu cầu
- Docker
- Docker Compose

## 🚀 Cách chạy dự án

### Bước 1: Đảm bảo có file .env
File `.env` đã được cấu hình với:
- DB_CONNECTION=mysql
- DB_HOST=mysql
- DB_DATABASE=shop
- DB_USERNAME=shop
- DB_PASSWORD=password

### Bước 2: Build và start containers
```bash
docker-compose up -d --build
```

Hoặc nếu đã build trước đó:
```bash
docker-compose up -d
```

### Bước 3: Cài đặt dependencies trong container (nếu cần)
```bash
# Vào container
docker exec -it laravel_app sh

# Hoặc chạy lệnh trực tiếp
docker exec -it laravel_app composer install
docker exec -it laravel_app npm install
docker exec -it laravel_app php artisan migrate --force
```

## 🌐 Truy cập ứng dụng
- **Web Application**: http://localhost:8000
- **PhpMyAdmin**: http://localhost:8080
  - Server: `mysql`
  - Username: `shop`
  - Password: `password`
- **Mailpit**: http://localhost:8025

## 🔧 Các lệnh hữu ích

### Xem logs
```bash
docker-compose logs -f app
docker-compose logs -f mysql
docker-compose logs -f  # Xem tất cả
```

### Truy cập vào container
```bash
docker exec -it laravel_app sh
docker exec -it mysql_db bash
docker exec -it redis_cache sh
```

### Dừng containers
```bash
docker-compose down
```

### Dừng và xóa volumes
```bash
docker-compose down -v
```

### Rebuild containers
```bash
docker-compose down
docker-compose up -d --build
```

### Chạy Artisan commands
```bash
docker exec -it laravel_app php artisan migrate
docker exec -it laravel_app php artisan tinker
docker exec -it laravel_app php artisan route:list
```

### Chạy npm commands
```bash
docker exec -it laravel_app npm run dev
docker exec -it laravel_app npm run build
```

### Xem database
```bash
docker exec -it laravel_app php artisan db:show
docker exec -it mysql_db mysql -ushop -ppassword shop
```

## 📁 Cấu trúc Docker
- **app**: Container Laravel (PHP 8.2)
- **mysql**: MySQL 8.0 database
- **redis**: Redis cache
- **mailpit**: Mail testing service
- **phpmyadmin**: Database management GUI

## ⚙️ Cấu hình Ports
- Laravel App: `8000`
- MySQL: `3306`
- Redis: `6379`
- Mailpit: `8025` (dashboard), `1025` (SMTP)
- PhpMyAdmin: `8080`

## 🐛 Troubleshooting

### Container không khởi động
```bash
docker-compose logs app
docker-compose ps
```

### Permission issues
```bash
docker exec -it laravel_app chown -R www-data:www-data /var/www/html/storage
docker exec -it laravel_app chmod -R 775 /var/www/html/storage
```

### Database connection issues
Đảm bảo service name trong docker-compose là `mysql` (khớp với DB_HOST)

### Reset database
```bash
docker-compose down -v
docker-compose up -d
docker exec -it laravel_app php artisan migrate:fresh
```

