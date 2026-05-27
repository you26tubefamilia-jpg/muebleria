# Etapa 1: Construcción de dependencias de Node (Frontend / Vite)
FROM node:20 AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Etapa 2: Construcción de PHP y Apache (Backend)
FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Habilitar el mod_rewrite de Apache (necesario para las URLs amigables de Laravel)
RUN a2enmod rewrite

# Cambiar el DocumentRoot de Apache a la carpeta public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar el código del proyecto al contenedor
WORKDIR /var/www/html
COPY . .

# Copiar los assets compilados desde la etapa de Node
COPY --from=node_builder /app/public/build ./public/build

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar las dependencias de PHP de Laravel
# (Usamos --no-dev para producción y --optimize-autoloader)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Dar permisos a las carpetas de almacenamiento y caché de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Puerto que expone Render
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
