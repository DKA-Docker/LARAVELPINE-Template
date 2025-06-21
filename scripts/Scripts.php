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

    public static function generateAppKeyAndInjectToDocker()
    {
        echo "🔐 Generating APP_KEY and injecting it into compose.yml...\n";

        $key = 'base64:' . base64_encode(random_bytes(32));
        echo "🔑 Generated key: {$key}\n";

        $composePath = __DIR__ . '/../compose.yml';
        if (!file_exists($composePath)) {
            echo "❌ File compose.yml not found.\n";
            exit(1);
        }

        $contents = file_get_contents($composePath);

        // Match the 'app' service with the specific image
        $pattern = '/(app:\s+(?:.*\n)*?\s+image:\s*yovanggaanandhika\/laravelpine:[^\n]*\n)((?:\s{2,}.*\n)*?)(?=\n\S|\z)/m';

        $contents = preg_replace_callback($pattern, function ($matches) use ($key) {
            $serviceBlock = $matches[0];

            // If APP_KEY already exists, replace it
            if (preg_match('/APP_KEY:\s*["\']?.*["\']?/i', $serviceBlock)) {
                $serviceBlock = preg_replace('/APP_KEY:\s*["\']?.*["\']?/i', 'APP_KEY: '.$key, $serviceBlock);
                echo "📝 APP_KEY found and updated.\n";
            } else {
                // Check if environment block exists
                if (preg_match('/environment:\n((\s{6,}.*\n)+)/', $serviceBlock, $envMatch)) {
                    // Append APP_KEY into existing environment
                    $replacement = $envMatch[0] . '      APP_KEY: ' .$key."\n";
                    $serviceBlock = str_replace($envMatch[0], $replacement, $serviceBlock);
                    echo "➕ APP_KEY added to existing environment block.\n";
                } else {
                    // No environment block, insert after image
                    $serviceBlock = preg_replace(
                        '/(image:\s*yovanggaanandhika\/laravelpine:[^\n]*\n)/i',
                        "$1    environment:\n      APP_KEY: $key\n",
                        $serviceBlock
                    );
                    echo "✨ APP_KEY added with new environment block.\n";
                }
            }

            return $serviceBlock;
        }, $contents, 1, $count);

        if ($count > 0) {
            file_put_contents($composePath, $contents);
            echo "✅ APP_KEY injection done in compose.yml.\n";
        } else {
            echo "⚠️ No matching image (yovanggaanandhika/laravelpine:*) found.\n";
        }
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
