#!/bin/bash
set -e

# Render asigna dinámicamente el puerto en la variable $PORT (por defecto 10000)
PORT="${PORT:-10000}"

echo "Configurando Apache en puerto ${PORT}..."

# Exportar variable de puerto para Apache
echo "export PORT=${PORT}" >> /etc/apache2/envvars

# Forzar a Apache a escuchar únicamente en el puerto asignado por Render
echo "Listen ${PORT}" > /etc/apache2/ports.conf

# Configurar VirtualHost con el puerto dinámico
sed -i "s/<VirtualHost \*:[^>]*>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Crear carpetas necesarias y asegurar permisos de escritura para www-data (SQLite y uploads)
mkdir -p /var/www/html/publica/recursos/productos
chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html

echo "Iniciando servidor web Apache..."
exec apache2-foreground
