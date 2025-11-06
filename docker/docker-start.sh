#!/bin/bash

echo "================================================"
echo "🐳 Starting Docker Containers for Laravel"
echo "================================================"

# Check if .env exists
if [ ! -f "../.env" ]; then
    echo "❌ File .env not found!"
    echo "📝 Please create .env file in the root directory"
    exit 1
fi

# Build and start containers
echo "🔨 Building Docker images..."
docker-compose up -d --build

echo "⏳ Waiting for services to be ready..."
sleep 15

# Check if containers are running
if docker-compose ps | grep -q "Up"; then
    echo ""
    echo "✅ Docker containers are running!"
    echo ""
    echo "📍 Access your application at: http://localhost:8000"
    echo "🗄️  PhpMyAdmin: http://localhost:8080"
    echo "📧 Mailpit: http://localhost:8025"
    echo ""
    echo "📋 Useful commands:"
    echo "   docker-compose ps          - View running containers"
    echo "   docker-compose logs -f     - View logs"
    echo "   docker-compose down        - Stop containers"
    echo "   docker exec -it laravel_app sh  - Access app container"
    echo ""
else
    echo "❌ Failed to start containers"
    echo "📋 Check logs: docker-compose logs"
    exit 1
fi

