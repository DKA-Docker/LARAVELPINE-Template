<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class DockerMigrate extends Command
{
    protected $signature = 'docker:migrate';
    protected $description = 'Menjalankan php artisan migrate berdasarkan image Laravel di compose.yml';

    public function handle()
    {
        $composePath = base_path('compose.yml');
        if (!file_exists($composePath)) {
            $this->error("❌ File compose.yml tidak ditemukan.");
            return 1;
        }

        $this->info("🔍 Membaca file compose.yml...");
        $yaml = Yaml::parseFile($composePath);

        if (!isset($yaml['services']['app']['image'])) {
            $this->error("❌ Service 'app' atau key 'image' tidak ditemukan dalam compose.yml.");
            return 1;
        }

        $imageName = $yaml['services']['app']['image'];
        $targetImage = 'yovanggaanandhika/laravelpine:8.3-fpm';

        $this->info("📦 Image ditemukan: $imageName");

        if ($imageName !== $targetImage) {
            $this->error("⚠️ Image tidak sesuai. Ditemukan: $imageName, tapi yang diharapkan: $targetImage");
            return 1;
        }

        // Cari container aktif dari image
        $this->info("🔍 Mencari container aktif dari image...");
        $cmdGetContainer = "docker ps --format '{{.Image}} {{.Names}}' | grep '^$imageName ' | awk '{print \$2}' | head -n 1";
        $containerName = trim(shell_exec($cmdGetContainer));

        if (empty($containerName)) {
            $this->error("❌ Tidak ada container aktif dari image: $imageName");
            return 1;
        }

        $this->info("📦 Container ditemukan: $containerName");

        // Cek apakah php tersedia
        $checkPhp = "docker exec {$containerName} which php";
        $phpPath = trim(shell_exec($checkPhp));
        if (empty($phpPath)) {
            $this->error("❌ Perintah `php` tidak ditemukan dalam container: {$containerName}");
            return 1;
        }

        // Jalankan migrate
        $this->info("🚀 Menjalankan migrate di container...");
        $execCmd = "docker exec -it {$containerName} php artisan migrate";
        passthru($execCmd, $exitCode);

        if ($exitCode !== 0) {
            $this->error("❌ Gagal menjalankan migrate.");
            return $exitCode;
        }

        $this->info("✅ Migrasi berhasil dijalankan.");
        return 0;
    }
}
