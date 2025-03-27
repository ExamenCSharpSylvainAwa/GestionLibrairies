#!/bin/bash
set -e

# Exécuter les migrations Laravel (optionnel, selon tes besoins)
php artisan migrate --force

# Lancer PHP-FPM
exec php-fpm