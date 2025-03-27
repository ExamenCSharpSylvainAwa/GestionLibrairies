# Étape 1 : Image de base pour PHP
FROM php:8.2-fpm AS base

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Étape 2 : Builder pour installer les dépendances Composer
FROM base AS builder

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier tous les fichiers du projet
COPY . .

# Copier .env.example en .env
RUN cp .env.example .env

# Installer les dépendances Composer
RUN composer install --no-dev --optimize-autoloader

# Générer la clé d'application Laravel
RUN php artisan key:generate

# Étape 3 : Image finale pour la production
FROM base AS production

WORKDIR /var/www

# Copier les fichiers de l'étape builder
COPY --from=builder /var/www .

# Copier le script d'entrée
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Définir le point d'entrée
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]