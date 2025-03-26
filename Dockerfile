# Étape 1 : Build - Installer les dépendances et préparer l'application
FROM php:8.2-fpm AS builder

# Installer les dépendances système nécessaires pour Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers de l'application
COPY . .

# Installer les dépendances PHP via Composer
RUN composer install --no-dev --optimize-autoloader

# Générer la clé d'application Laravel
RUN php artisan key:generate

# Mettre en cache les configurations et les routes pour optimiser les performances
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Donner les permissions appropriées
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Étape 2 : Image finale - Configurer le serveur web
FROM php:8.2-fpm

# Installer les dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Copier les fichiers de l'application depuis l'étape de build
COPY --from=builder /var/www /var/www

# Définir le répertoire de travail
WORKDIR /var/www

# Exposer le port 9000 (utilisé par PHP-FPM)
EXPOSE 9000

# Commande pour démarrer PHP-FPM
CMD ["php-fpm"]