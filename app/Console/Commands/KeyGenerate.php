<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class KeyGenerate extends Command
{
    protected $signature = 'key:generate
                            {--show : Hanya tampilkan key tanpa mengubah file .env}
                            {--force : Paksa menimpa APP_KEY jika sudah ada}';

    protected $description = 'Generate application key dan injeksi ke .env dan compose.yml';

    public function handle()
    {
        $key = 'base64:' . base64_encode(random_bytes(32));

        // Jika --show, hanya tampilkan
        if ($this->option('show')) {
            $this->line("<fg=green>$key</>");
            return 0;
        }

        $envPath = base_path('.env');
        if (file_exists($envPath)) {

            $envContent = file_get_contents($envPath);

            // Replace APP_KEY di .env
            $newEnv = preg_replace('/^APP_KEY=.*$/m', "APP_KEY=$key", $envContent);
            if (!Str::contains($newEnv, 'APP_KEY=')) {
                $newEnv .= "\nAPP_KEY=$key\n";
            }

            file_put_contents($envPath, $newEnv);
            $this->info('✅ APP_KEY berhasil digenerate dan disimpan ke .env');
        }else{
            $this->error('❌ File .env tidak ditemukan.');
        }


        // Tambahan: Inject juga ke docker compose.yml
        $this->injectToCompose($key);

        return 0;
    }

    protected function injectToCompose(string $key)
    {
        $composePath = base_path('compose.yml');
        if (!file_exists($composePath)) {
            $this->warn('⚠️ File compose.yml tidak ditemukan. APP_KEY tidak disisipkan ke sana.');
            return;
        }

        $contents = file_get_contents($composePath);
        $pattern = '/(app:\s+(?:.*\n)*?\s+image:\s*yovanggaanandhika\/laravelpine:[^\n]*\n)((?:\s{2,}.*\n)*?)(?=\n\S|\z)/m';

        $contents = preg_replace_callback($pattern, function ($matches) use ($key) {
            $serviceBlock = $matches[0];

            if (preg_match('/APP_KEY:\s*["\']?.*["\']?/i', $serviceBlock)) {
                $serviceBlock = preg_replace('/APP_KEY:\s*["\']?.*["\']?/i', 'APP_KEY: ' . $key, $serviceBlock);
            } elseif (preg_match('/environment:\n((\s{6,}.*\n)+)/', $serviceBlock, $envMatch)) {
                $replacement = $envMatch[0] . '      APP_KEY: ' . $key . "\n";
                $serviceBlock = str_replace($envMatch[0], $replacement, $serviceBlock);
            } else {
                $serviceBlock = preg_replace(
                    '/(image:\s*yovanggaanandhika\/laravelpine:[^\n]*\n)/i',
                    "$1    environment:\n      APP_KEY: $key\n",
                    $serviceBlock
                );
            }

            return $serviceBlock;
        }, $contents, 1, $count);

        if ($count > 0) {
            file_put_contents($composePath, $contents);
            $this->info('📦 APP_KEY juga disisipkan ke compose.yml');
        } else {
            $this->warn('⚠️ Tidak ditemukan image yovanggaanandhika/laravelpine:* di compose.yml');
        }
    }
}
