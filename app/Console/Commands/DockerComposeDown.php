<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DockerComposeDown extends Command
{
    protected $signature = 'compose:down {--force : Hapus volumes juga (docker compose down -v)}';
    protected $description = 'Menjalankan docker compose down dengan deteksi OS dan opsi --force untuk menghapus volumes';

    public function handle()
    {
        $this->info('🛑 Menjalankan docker compose down...');

        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $dockerCmd = $isWindows ? 'docker-compose' : 'docker';

        if (!self::isCommandAvailable($dockerCmd)) {
            $this->error("❌ Perintah `$dockerCmd` tidak ditemukan. Pastikan Docker terinstall dan tersedia di PATH.");
            return 1;
        }

        // Tambahkan -v jika --force diset
        $forceOption = $this->option('force') ? ' -v' : '';

        $cmd = $dockerCmd === 'docker-compose'
            ? 'docker-compose down' . $forceOption
            : 'docker compose down' . $forceOption;

        $this->line("📦 Perintah: <fg=yellow>$cmd</>");

        exec($cmd, $output, $code);

        foreach ($output ?? [] as $line) {
            $this->line($line);
        }

        if ($code !== 0) {
            $this->error("❌ Gagal menjalankan docker compose down.");
            return 1;
        }

        $this->info("✅ Docker containers berhasil dimatikan.");
        return 0;
    }

    protected static function isCommandAvailable(string $command): bool
    {
        $check = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? "where {$command}" : "command -v {$command}";
        exec($check, $out, $status);
        return $status === 0;
    }
}

