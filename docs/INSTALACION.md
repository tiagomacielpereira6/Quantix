# 🚀 Guía de Instalación - Sistema Carrito Comida Rápida

## 📋 Índice
1. [Requisitos del Sistema](#-requisitos-del-sistema)
2. [Instalación Paso a Paso](#-instalación-paso-a-paso)
3. [Configuración](#-configuración)
4. [Verificación](#-verificación)
5. [Troubleshooting](#-troubleshooting)
6. [Configuración para Producción](#-configuración-para-producción)

---

## 💻 Requisitos del Sistema

### Requisitos Mínimos

#### Sistema Operativo
- **Linux** - Ubuntu 20.04+ / CentOS 8+ (Recomendado)
- **Windows** - Windows 10+ con WSL2
- **macOS** - macOS 11+ (Big Sur o superior)

#### Software Base
```
┌─────────────────┬──────────────────┬────────────────────┐
│   Software      │    Versión       │    Propósito       │
├─────────────────┼──────────────────┼────────────────────┤
│ PHP             │ 8.1+             │ Backend            │
│ Node.js         │ 18+              │ Frontend Build     │
│ MariaDB/MySQL   │ 10.6+/8.0+      │ Base de Datos      │
│ Composer        │ 2.4+             │ Dependencias PHP   │
│ NPM             │ 9+               │ Dependencias JS    │
└─────────────────┴──────────────────┴────────────────────┘
```

#### Extensiones PHP Requeridas
```bash
# Extensiones obligatorias
php-mbstring     # Manejo de strings multibyte
php-xml          # Procesamiento XML
php-curl         # Peticiones HTTP
php-zip          # Compresión de archivos
php-gd           # Procesamiento de imágenes
php-mysql        # Conexión a MySQL/MariaDB
php-pdo          # Abstracción de base de datos
php-fileinfo     # Información de archivos
php-json         # Procesamiento JSON
php-tokenizer    # Análisis de tokens PHP
```

### Recursos Recomendados

#### Para Desarrollo
- **RAM**: 4GB mínimo, 8GB recomendado
- **CPU**: 2 cores mínimo, 4 cores recomendado  
- **Disco**: 5GB libres mínimo, 20GB recomendado
- **Internet**: Conexión estable para descarga de dependencias

#### Para Producción
- **RAM**: 8GB mínimo, 16GB recomendado
- **CPU**: 4 cores mínimo, 8 cores recomendado
- **Disco**: 50GB mínimo, SSD recomendado
- **Internet**: Conexión estable y rápida

---

## 📦 Instalación Paso a Paso

### Paso 1: Preparación del Entorno

#### En Ubuntu/Debian
```bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar PHP y extensiones
sudo apt install php8.1 php8.1-cli php8.1-fpm php8.1-mysql php8.1-xml \
                 php8.1-curl php8.1-gd php8.1-mbstring php8.1-zip \
                 php8.1-fileinfo php8.1-json php8.1-tokenizer

# Instalar MariaDB
sudo apt install mariadb-server mariadb-client

# Instalar Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

#### En CentOS/RHEL
```bash
# Habilitar repositorios
sudo dnf install epel-release
sudo dnf module enable php:8.1

# Instalar PHP y extensiones  
sudo dnf install php php-cli php-fpm php-mysqlnd php-xml php-curl \
                 php-gd php-mbstring php-zip php-fileinfo php-json

# Instalar MariaDB
sudo dnf install mariadb-server mariadb

# Instalar Node.js
sudo dnf module install nodejs:18/common

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

#### En Windows (con WSL2)
```powershell
# Instalar WSL2 Ubuntu
wsl --install -d Ubuntu

# Seguir instrucciones de Ubuntu dentro de WSL
```

#### En macOS
```bash
# Instalar Homebrew si no está instalado
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Instalar PHP
brew install php@8.1

# Instalar MariaDB
brew install mariadb

# Instalar Node.js
brew install node@18

# Instalar Composer
brew install composer
```

### Paso 2: Configuración de Base de Datos

#### Configuración Inicial de MariaDB
```bash
# Iniciar servicio
sudo systemctl start mariadb
sudo systemctl enable mariadb

# Configuración segura
sudo mysql_secure_installation
```

**Respuestas Recomendadas:**
- Enter current password: `[Enter]` (sin password inicial)
- Set root password: `Y` → Crear password seguro
- Remove anonymous users: `Y`
- Disallow root login remotely: `Y` 
- Remove test database: `Y`
- Reload privilege tables: `Y`

#### Crear Base de Datos y Usuario
```sql
-- Conectar como root
mysql -u root -p

-- Crear base de datos
CREATE DATABASE carrito_comida CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear usuario específico
CREATE USER 'carrito_user'@'localhost' IDENTIFIED BY 'password_seguro_aqui';

-- Otorgar permisos
GRANT ALL PRIVILEGES ON carrito_comida.* TO 'carrito_user'@'localhost';

-- Aplicar cambios
FLUSH PRIVILEGES;

-- Salir
EXIT;
```

### Paso 3: Descarga e Instalación del Proyecto

#### Clonar Repositorio (Si aplicable)
```bash
# Opción 1: Desde Git
git clone [URL_DEL_REPOSITORIO] carrito-comida
cd carrito-comida

# Opción 2: Desde archivo comprimido
unzip carrito-comida.zip
cd carrito-comida
```

#### Instalar Dependencias PHP
```bash
# Verificar Composer
composer --version

# Instalar dependencias Laravel
composer install --no-dev --optimize-autoloader

# Si es entorno de desarrollo
composer install
```

#### Instalar Dependencias JavaScript
```bash  
# Verificar Node.js y NPM
node --version
npm --version

# Instalar dependencias
npm install

# Para producción
npm ci --only=production
```

### Paso 4: Configuración del Proyecto

#### Configurar Variables de Entorno
```bash
# Copiar archivo de configuración
cp .env.example .env

# Editar configuración
nano .env  # o vim .env
```

**Configuración del archivo .env:**
```bash
# Configuración básica de la aplicación
APP_NAME="Carrito Comida Rápida"
APP_ENV=production  # o 'local' para desarrollo
APP_KEY=  # Se generará en el siguiente paso
APP_DEBUG=false  # true para desarrollo
APP_URL=http://localhost:8000

# Configuración de base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=carrito_comida
DB_USERNAME=carrito_user
DB_PASSWORD=password_seguro_aqui

# Configuración de cache (opcional)
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Configuración de logs
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Configuración de PDF
DOMPDF_LOAD_FONT_TABLE=true
DOMPDF_ENABLE_REMOTE=false
```

#### Generar Clave de Aplicación
```bash
# Generar APP_KEY
php artisan key:generate

# Verificar que se agregó al .env
grep APP_KEY .env
```

#### Configurar Permisos
```bash
# Permisos para directorios de Laravel
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Si no tienes www-data, usar tu usuario
sudo chown -R $USER:$USER storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Paso 5: Migración y Datos Iniciales

#### Ejecutar Migraciones
```bash
# Verificar conexión a BD
php artisan migrate:status

# Ejecutar migraciones
php artisan migrate

# Confirmar cuando pregunte: yes
```

#### Cargar Datos de Ejemplo (Opcional)
```bash
# Para desarrollo - cargar datos de prueba
php artisan db:seed

# Para producción - solo estructura básica
php artisan db:seed --class=ProductoSeeder
```

#### Verificar Estructura de BD
```bash
# Listar tablas creadas
mysql -u carrito_user -p carrito_comida -e "SHOW TABLES;"

# Verificar algunos datos
mysql -u carrito_user -p carrito_comida -e "SELECT COUNT(*) FROM productos;"
```

### Paso 6: Compilación de Assets Frontend

#### Para Desarrollo
```bash
# Compilar assets para desarrollo
npm run dev

# Modo watch (recompila automáticamente)
npm run dev -- --watch
```

#### Para Producción
```bash  
# Compilar y optimizar para producción
npm run build

# Verificar archivos generados
ls -la public/build/
```

---

## ⚙️ Configuración

### Configuración del Servidor Web

#### Opción 1: Servidor Integrado de Laravel (Desarrollo)
```bash
# Iniciar servidor de desarrollo
php artisan serve --host=0.0.0.0 --port=8000

# Acceder desde
http://localhost:8000
```

#### Opción 2: Apache (Producción)
```apache
# /etc/apache2/sites-available/carrito-comida.conf
<VirtualHost *:80>
    ServerName carrito-comida.local
    DocumentRoot /var/www/carrito-comida/public
    
    <Directory /var/www/carrito-comida/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/carrito-error.log
    CustomLog ${APACHE_LOG_DIR}/carrito-access.log combined
</VirtualHost>
```

```bash
# Habilitar sitio
sudo a2ensite carrito-comida.conf
sudo a2enmod rewrite
sudo systemctl reload apache2
```

#### Opción 3: Nginx (Producción)
```nginx
# /etc/nginx/sites-available/carrito-comida
server {
    listen 80;
    server_name carrito-comida.local;
    root /var/www/carrito-comida/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

```bash
# Habilitar sitio
sudo ln -s /etc/nginx/sites-available/carrito-comida /etc/nginx/sites-enabled/
sudo systemctl reload nginx
```

### Configuración de PHP

#### Optimizaciones Recomendadas
```ini
# /etc/php/8.1/fpm/php.ini (o ruta correspondiente)
memory_limit = 512M
upload_max_filesize = 32M
post_max_size = 32M
max_execution_time = 300
max_input_vars = 3000

# Para generación de PDFs
max_input_time = 300
default_socket_timeout = 300
```

#### Reiniciar Servicios
```bash
# Reiniciar PHP-FPM
sudo systemctl restart php8.1-fpm

# Reiniciar servidor web
sudo systemctl restart apache2  # o nginx
```

---

## ✅ Verificación

### Lista de Verificación Post-Instalación

#### ✅ Verificación Básica
```bash
# 1. Verificar versiones
php --version     # Debe ser 8.1+
node --version    # Debe ser 18+
composer --version # Debe ser 2.4+

# 2. Verificar conexión a BD
php artisan migrate:status

# 3. Verificar assets compilados
ls -la public/build/

# 4. Verificar permisos
ls -la storage/ bootstrap/cache/
```

#### 🌐 Verificación Web
1. **Acceder a la aplicación**
   - Abrir navegador
   - Ir a `http://localhost:8000` (o tu dominio)
   - La página debe cargar sin errores

2. **Verificar funcionalidades principales**
   - Dashboard debe mostrar métricas
   - Navegación entre módulos funciona
   - Creación de productos/pedidos opera
   - Generación de PDFs disponible

3. **Verificar responsive design**
   - Probar en diferentes tamaños de pantalla
   - Verificar menús móviles
   - Confirmar legibilidad en dispositivos pequeños

#### 🔍 Verificación de Logs
```bash
# Ver logs de Laravel
tail -f storage/logs/laravel.log

# Ver logs del servidor web
sudo tail -f /var/log/apache2/error.log
# o
sudo tail -f /var/log/nginx/error.log

# Ver logs de PHP
sudo tail -f /var/log/php8.1-fpm.log
```

### Tests de Funcionalidad

#### Test Manual Básico
1. **Productos**
   - ✅ Crear producto nuevo
   - ✅ Editar producto existente
   - ✅ Activar/desactivar producto
   - ✅ Ver lista con filtros

2. **Pedidos**
   - ✅ Crear pedido con productos
   - ✅ Cambiar estado de pedido
   - ✅ Generar PDF de ticket
   - ✅ Ver historial completo

3. **Reportes**
   - ✅ Acceder a dashboard de reportes
   - ✅ Filtrar por fechas
   - ✅ Generar PDF de reportes
   - ✅ Ver estadísticas actualizadas

#### Performance Test
```bash
# Test básico de carga
curl -w "@curl-format.txt" -o /dev/null -s "http://localhost:8000/"

# Donde curl-format.txt contiene:
#     time_namelookup:  %{time_namelookup}\n
#     time_connect:     %{time_connect}\n
#     time_appconnect:  %{time_appconnect}\n
#     time_pretransfer: %{time_pretransfer}\n
#     time_redirect:    %{time_redirect}\n
#     time_starttransfer: %{time_starttransfer}\n
#     ----------\n
#     time_total:       %{time_total}\n
```

---

## 🚨 Troubleshooting

### Problemas Comunes y Soluciones

#### Error: "No application encryption key has been specified"
```bash
# Solución
php artisan key:generate
```

#### Error de Conexión a Base de Datos
```bash
# Verificar configuración .env
grep DB_ .env

# Probar conexión manual
mysql -u carrito_user -p carrito_comida

# Verificar servicio MySQL
sudo systemctl status mariadb
```

#### Errores de Permisos
```bash
# Arreglar permisos
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Para sistemas sin www-data
sudo chown -R $USER:$USER storage bootstrap/cache
```

#### Assets No Cargan (404)
```bash
# Recompilar assets
npm run build

# Verificar archivos generados
ls -la public/build/

# Limpiar cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### Error de Memoria PHP
```ini
# Aumentar en php.ini
memory_limit = 512M

# Reiniciar PHP
sudo systemctl restart php8.1-fpm
```

#### PDFs No Se Generan
```bash
# Verificar extensiones PHP
php -m | grep -E "(gd|dom|mbstring)"

# Verificar permisos de escritura
sudo chown -R www-data:www-data storage/
```

### Logs Importantes

#### Ubicaciones de Logs
```bash
# Laravel
storage/logs/laravel.log

# Apache
/var/log/apache2/error.log
/var/log/apache2/access.log

# Nginx  
/var/log/nginx/error.log
/var/log/nginx/access.log

# PHP-FPM
/var/log/php8.1-fpm.log
```

#### Comandos de Debug
```bash
# Ver últimos errores
tail -n 50 storage/logs/laravel.log

# Modo debug (solo desarrollo)
# En .env: APP_DEBUG=true
php artisan serve

# Limpiar todo el cache
php artisan optimize:clear
```

---

## 🏭 Configuración para Producción

### Optimizaciones de Rendimiento

#### Cache de Configuración
```bash
# Cachear configuraciones
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimizar autoloader
composer install --optimize-autoloader --no-dev
```

#### Configuración de PHP para Producción
```ini
# /etc/php/8.1/fpm/php.ini
expose_php = Off
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log

# OPcache (recomendado)
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
opcache.save_comments=1
```

#### Variables de Entorno para Producción
```bash
# .env para producción
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error

# Cache más eficiente
CACHE_DRIVER=redis  # si tienes Redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Seguridad

#### HTTPS (Certificado SSL)
```bash
# Con Let's Encrypt (certbot)
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d tu-dominio.com
```

#### Configuración de Firewall
```bash
# UFW (Ubuntu)
sudo ufw allow 22    # SSH
sudo ufw allow 80    # HTTP
sudo ufw allow 443   # HTTPS
sudo ufw enable
```

#### Headers de Seguridad
```nginx
# En configuración Nginx
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header X-Content-Type-Options "nosniff" always;
add_header Referrer-Policy "no-referrer-when-downgrade" always;
add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;
```

### Monitoreo

#### Logs de Producción
```bash
# Rotación de logs
sudo nano /etc/logrotate.d/laravel

# Contenido:
/var/www/carrito-comida/storage/logs/*.log {
    daily
    missingok
    rotate 30
    compress
    delaycompress
    notifempty
    create 644 www-data www-data
}
```

#### Backup Automatizado
```bash
# Script de backup (guardar como backup.sh)
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="carrito_comida"
BACKUP_DIR="/backups"

# Backup de base de datos
mysqldump -u carrito_user -p$DB_PASSWORD $DB_NAME > $BACKUP_DIR/db_$DATE.sql

# Backup de archivos
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/carrito-comida

# Limpiar backups antiguos (más de 7 días)
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

```bash
# Programar en crontab
crontab -e

# Agregar línea para backup diario a las 2 AM
0 2 * * * /path/to/backup.sh
```

---

## 📞 Soporte

### Información de Contacto
- **Desarrollador**: Leandro
- **Proyecto**: Sistema de Graduación
- **Documentación**: Ver `/docs/` para más información

### Recursos Adicionales
- **Laravel Docs**: https://laravel.com/docs
- **Vue.js Docs**: https://vuejs.org/guide/
- **Tailwind CSS**: https://tailwindcss.com/docs
- **Inertia.js**: https://inertiajs.com/

---

*Guía actualizada: 24 de Septiembre, 2025*