<?php

namespace Template;

class Scripts
{
    public static function runDocker()
    {
        echo "🔥 Running Docker Compose...\n";

        // Deteksi OS
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        // Cek apakah docker tersedia
        if (!self::isCommandAvailable($isWindows ? 'docker-compose' : 'docker')) {
            echo "❌ Docker CLI tidak ditemukan. Pastikan Docker sudah terinstall dan ada di PATH.\n";
            exit(1);
        }

        // Tentukan perintah yang sesuai
        $cmd = $isWindows ? 'docker-compose up -d' : 'docker compose up -d';

        // Eksekusi
        $output = [];
        $returnCode = 0;
        exec($cmd, $output, $returnCode);

        foreach ($output as $line) {
            echo $line . PHP_EOL;
        }

        if ($returnCode !== 0) {
            echo "❌ Gagal menjalankan Docker. Pastikan Docker Desktop (Windows) atau Docker daemon (Linux) sedang aktif.\n";
            exit(1);
        }

        echo "✅ Docker berhasil dijalankan!\n";
    }

    private static function isCommandAvailable(string $command): bool
    {
        $check = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
            ? "where $command"
            : "command -v $command";

        exec($check, $output, $code);
        return $code === 0;
    }
}
