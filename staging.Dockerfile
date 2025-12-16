# Menggunakan image custom PHP 8.3 FPM
FROM yovanggaanandhika/laravelpine:8.3
# Copy semua file ke dalam container
RUN rm composer.lock composer.json
COPY . .
# Set permission untuk storage dan bootstrap/cache
RUN chown -R www-data:www-data storage database bootstrap/cache && chmod -R 775 storage database bootstrap/cache storage/logs
RUN chown -R www-data:www-data public && chmod -R 775 public
RUN rm vite.config.js
RUN composer install && yarn install && yarn run build
RUN php artisan storage:link
