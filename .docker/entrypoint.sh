#!/bin/sh

# 1. Jalankan migrasi database ke Supabase
echo "Menjalankan migrasi database..."
php artisan migrate:fresh --force

# 2. Jalankan seeder otomatis untuk mengisi data awal
echo "Menjalankan seeder otomatis..."
php artisan db:seed --force

echo "Menjalankan seeder pilihan..."
php artisan db:seed --class=DatabaseSeeder --force
php artisan db:seed --class=MasterDataSeeder --force

# 3. Jalankan perintah utama Supervisor untuk menyalakan server
echo "Menyalakan server web..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
