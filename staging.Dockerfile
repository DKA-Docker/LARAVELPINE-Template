# Menggunakan image custom PHP 8.3 FPM
FROM yovanggaanandhika/laravelpine:8.3-fpm
# Copy semua file ke dalam container
COPY . .
# Set permission untuk storage dan bootstrap/cache
RUN chown -R www-data:www-data storage database bootstrap/cache && chmod -R 775 storage database bootstrap/cache storage/logs
RUN chown -R www-data:www-data public && chmod -R 775 public
RUN composer install && yarn install
