FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones de PHP (SQLite3 y PDO)
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Configurar VirtualHost de Apache con DocumentRoot en publica/
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Copiar el código del proyecto
WORKDIR /var/www/html
COPY . /var/www/html/

# Configurar script de inicio y corregir posibles saltos de línea Windows (CRLF -> LF)
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh

# Preparar carpetas y permisos para SQLite y subida de archivos
RUN mkdir -p /var/www/html/publica/recursos/productos \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

# Puerto por defecto de Render
ENV PORT=10000
EXPOSE 10000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
