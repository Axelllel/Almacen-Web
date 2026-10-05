#!/bin/bash
# ─────────────────────────────────────────────────────────────
# web-almacen — Script de instalación inicial
# Ejecutar desde la raíz del proyecto: bash setup.sh
# ─────────────────────────────────────────────────────────────

set -e
RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'; NC='\033[0m'
info()    { echo -e "${YELLOW}[INFO]${NC} $1"; }
success() { echo -e "${GREEN}[OK]${NC}   $1"; }
error()   { echo -e "${RED}[ERR]${NC}  $1"; exit 1; }

echo ""
echo "  ██╗    ██╗███████╗██████╗      █████╗ ██╗     ███╗   ███╗"
echo "  ██║    ██║██╔════╝██╔══██╗    ██╔══██╗██║     ████╗ ████║"
echo "  ██║ █╗ ██║█████╗  ██████╔╝    ███████║██║     ██╔████╔██║"
echo "  ██║███╗██║██╔══╝  ██╔══██╗    ██╔══██║██║     ██║╚██╔╝██║"
echo "  ╚███╔███╔╝███████╗██████╔╝    ██║  ██║███████╗██║ ╚═╝ ██║"
echo "   ╚══╝╚══╝ ╚══════╝╚═════╝     ╚═╝  ╚═╝╚══════╝╚═╝     ╚═╝"
echo ""
info "Iniciando configuración de Web Almacén..."
echo ""

# 1. Copiar .env
info "Copiando archivo .env..."
if [ ! -f .env ]; then
    cp .env.example .env
    success ".env creado"
else
    info ".env ya existe, omitiendo"
fi

# 2. Levantar contenedores
info "Levantando contenedores Docker..."
docker-compose up -d --build
success "Contenedores iniciados"

# 3. Esperar a MySQL
info "Esperando a que MySQL esté listo..."
sleep 15

# 4. Instalar dependencias PHP
info "Instalando dependencias PHP (Composer)..."
docker-compose exec app composer install --no-interaction
success "Dependencias PHP instaladas"

# 5. Generar clave de aplicación
info "Generando APP_KEY..."
docker-compose exec app php artisan key:generate
success "APP_KEY generada"

# 6. Instalar dependencias JS y compilar
info "Instalando dependencias JS (npm)..."
docker-compose exec app npm install
info "Compilando assets (Vite + Tailwind)..."
docker-compose exec app npm run build
success "Assets compilados"

# 7. Ejecutar migraciones
info "Ejecutando migraciones..."
docker-compose exec app php artisan migrate --force
success "Migraciones ejecutadas"

# 8. Seeders (datos de prueba)
info "Ejecutando seeders (datos de prueba)..."
docker-compose exec app php artisan db:seed --force
success "Seeders ejecutados"

# 9. Storage link
info "Creando enlace simbólico de storage..."
docker-compose exec app php artisan storage:link
success "Storage link creado"

# 10. Permisos
info "Ajustando permisos..."
docker-compose exec app chmod -R 775 storage bootstrap/cache

echo ""
echo "────────────────────────────────────────────────"
success "¡Instalación completada!"
echo ""
echo "  🌐 App:         http://localhost:8080"
echo "  🗄️  phpMyAdmin:  http://localhost:8081"
echo "  DB Usuario:    almacen_user / almacen_pass"
echo "────────────────────────────────────────────────"
echo ""
