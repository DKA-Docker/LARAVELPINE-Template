# Menggunakan image custom PHP 8.3 FPM
FROM yovanggaanandhika/laravelpine:8.3
# hapus file bawaan image laravel
RUN rm composer.lock composer.json vite.config.js
# unlink storage untuk memastikan di image dasar tidak menyertakan path yang salah
RUN php artisan storage:unlink
# Copy semua file ke dalam container
COPY . .
# Set permission untuk storage dan bootstrap/cache
RUN chown -R www-data:www-data storage database bootstrap/cache && chmod -R 775 storage database bootstrap/cache storage/logs
RUN chown -R www-data:www-data public && chmod -R 775 public
RUN composer install && yarn install && yarn run build
RUN php artisan storage:link
RUN php artisan optimize
