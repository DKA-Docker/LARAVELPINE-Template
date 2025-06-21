<?php

namespace Template\Scripts;

class Scripts
{
    public static function runDocker()
    {
        echo "🔥 Running: docker compose up -d\n";

        // Deteksi OS biar cross-platform (Windows/Linux/Mac)
        $cmd = stripos(PHP_OS, 'WIN') === 0
            ? 'docker-compose up -d'
            : 'docker compose up -d';

        // Jalanin command dan tampilkan output
        $output = [];
        $returnCode = 0;
        exec($cmd, $output, $returnCode);

        foreach ($output as $line) {
            echo $line . PHP_EOL;
        }

        if ($returnCode !== 0) {
            echo "❌ Failed Run Docker. Please check Docker is Running\n";
            exit(1);
        }

        echo "✅ docker successfully running!\n";
    }
}
