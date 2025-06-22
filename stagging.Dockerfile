FROM yovanggaanandhika/laravelpine:8.3-fpm

COPY . .

# Gunakan find agar chmod lebih presisi, dan hindari masalah folder
RUN chown -R www-data:www-data . && \
        find . -type d -not -path "./.git*" -exec chmod 755 {} \; && \
        find . -type f -not -path "./.git*" -exec chmod 644 {} \; && \
        chmod -R 775 storage bootstrap/cache database

# Install dependensi Laravel & Jalankan clear. agar cache tidak di simpan
RUN composer install && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan storage:link
