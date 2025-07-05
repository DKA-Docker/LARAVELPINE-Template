<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DockerComposeUp extends Command
{
    protected $signature = 'compose:up {--force-recreate : Tambahkan --force-recreate saat menjalankan up}';
    protected $description = 'Menjalankan docker compose up dengan deteksi OS';

    public function handle()
    {
        $this->info('🚀 Menjalankan docker compose up...');

        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $dockerCmd = $isWindows ? 'docker-compose' : 'docker';

        if (!self::isCommandAvailable($dockerCmd)) {
            $this->error("❌ Perintah `$dockerCmd` tidak ditemukan. Pastikan Docker terinstall dan tersedia di PATH.");
            return 1;
        }

        $cmd = $dockerCmd === 'docker-compose'
            ? 'docker-compose up -d'
            : 'docker compose up -d';

        if ($this->option('force-recreate')) {
            $cmd .= ' --force-recreate';
        }

        $this->line("📦 Perintah: <fg=yellow>$cmd</>");

        exec($cmd, $output, $code);

        foreach ($output ?? [] as $line) {
            $this->line($line);
        }

        if ($code !== 0) {
            $this->error("❌ Gagal menjalankan docker compose up.");
            return 1;
        }

        $this->info("✅ Docker containers berhasil dijalankan.");
        return 0;
    }

    protected static function isCommandAvailable(string $command): bool
    {
        $check = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? "where {$command}" : "command -v {$command}";
        exec($check, $out, $status);
        return $status === 0;
    }
}
