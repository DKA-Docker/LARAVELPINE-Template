FROM yovanggaanandhika/laravelpine:8.3-fpm

COPY . .

# Gunakan find agar chmod lebih presisi, dan hindari masalah folder
RUN chown -R www-data:www-data . && \
    find . -type f -exec chmod 644 {} \; && \
    find . -type d -exec chmod 755 {} \; && \
    chmod -R 775 storage database bootstrap/cache

# Install dependensi Laravel & Jalankan clear. agar cache tidak di simpan
RUN composer install && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan storage:link
