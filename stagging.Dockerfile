FROM yovanggaanandhika/laravelpine:8.3-fpm

COPY . .

# Gunakan find agar chmod lebih presisi, dan hindari masalah folder
RUN chown -R www-data:www-data * & chmod -R 775 storage bootstrap/cache database

