ln -s /var/www/storage/app/public /var/www/public/public
composer install --ignore-platform-req=ext-http --ignore-platform-req=ext-intl
php artisan migrate
