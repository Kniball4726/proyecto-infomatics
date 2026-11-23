#!/bin/bash
set -e

# Render asigna dinámicamente el puerto en la variable $PORT (por defecto 10000)
PORT="${PORT:-10000}"

echo "Configurando Apache en puerto ${PORT}..."

# Ajustar puerto en ports.conf y en la configuración del VirtualHost
sed -i "s/Listen [0-9]*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Crear carpetas necesarias y asegurar permisos de escritura para www-data (SQLite y uploads)
mkdir -p /var/www/html/publica/recursos/productos
chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html

echo "Iniciando servidor web Apache..."
exec apache2-foreground
