<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DockerMigrate extends Command
{
    protected $signature = 'docker:migrate';
    protected $description = 'Menjalankan php artisan migrate di dalam container berdasarkan image dari compose.yml';

    public function handle()
    {
        $this->info("🔍 Membaca image dari compose.yml...");

        $composePath = base_path('compose.yml');
        if (!file_exists($composePath)) {
            $this->error("❌ File compose.yml tidak ditemukan.");
            return 1;
        }

        $contents = file_get_contents($composePath);

        // Cari image dari service 'app'
        if (!preg_match('/app:\s+(?:.*\n)*?\s+image:\s*([^\s\n]+)/', $contents, $matches)) {
            $this->error("❌ Tidak ditemukan image di service `app` dalam compose.yml.");
            return 1;
        }

        $imageName = trim($matches[1]);
        $this->info("📦 Image ditemukan: $imageName");

        // Cari nama container berdasarkan image
        $cmdGetContainer = "docker ps --filter ancestor=$imageName --format '{{.Names}}' | head -n 1";
        $containerName = trim(shell_exec($cmdGetContainer));

        if (empty($containerName)) {
            $this->error("❌ Tidak ada container aktif dari image: $imageName");
            return 1;
        }

        $this->info("🚀 Menjalankan migrate di container: {$containerName}");

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
