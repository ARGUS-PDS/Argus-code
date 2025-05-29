FROM php:8.2-fpm

# Instala dependências de sistema
RUN apt-get update && apt-get install -y \
    unzip git curl zip \
    libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
    default-mysql-client default-libmysqlclient-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl xml

# Instala Composer diretamente do site oficial
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# Copia os arquivos do projeto para o container
COPY . .

# Instala dependências do Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Gera chave da aplicação
RUN cp .env.example .env && php artisan key:generate

EXPOSE 8080

# Inicia servidor Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
