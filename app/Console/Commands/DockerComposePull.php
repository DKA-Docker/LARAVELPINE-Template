<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DockerComposePull extends Command
{
    protected $signature = 'compose:pull';
    protected $description = 'Menjalankan docker compose pull untuk menarik image dari Docker Hub';

    public function handle()
    {
        $this->info('📥 Menjalankan docker compose pull...');

        // Deteksi OS
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $cmd = $isWindows ? 'docker-compose pull' : 'docker compose pull';

        // Cek apakah docker (compose) tersedia
        if (!$this->isCommandAvailable($isWindows ? 'docker-compose' : 'docker')) {
            $this->error("❌ Perintah docker CLI tidak ditemukan. Pastikan Docker telah terpasang dan berada di PATH.");
            return 1;
        }

        // Eksekusi
        passthru($cmd, $exitCode);

        if ($exitCode !== 0) {
            $this->error("❌ Gagal menjalankan perintah pull.");
            return $exitCode;
        }

        $this->info("✅ Semua image berhasil ditarik.");
        return 0;
    }

    protected function isCommandAvailable(string $command): bool
    {
        $check = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
            ? "where {$command}"
            : "command -v {$command}";

        exec($check, $out, $status);
        return $status === 0;
    }
}
