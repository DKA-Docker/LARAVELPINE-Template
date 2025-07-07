<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class YarnInstall extends Command
{
    protected $signature = 'yarn:install';
    protected $description = 'Menjalankan yarn install jika yarn tersedia di sistem';

    public function handle(): int
    {
        if (!$this->isYarnAvailable()) {
            $this->error('❌ Perintah `yarn` tidak ditemukan. Silakan install Yarn terlebih dahulu.');
            return Command::FAILURE;
        }

        $this->info('⏳ Menjalankan yarn install...');

        $process = Process::fromShellCommandline('yarn install');
        $process->setTimeout(300); // kasih waktu 5 menit
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        if ($process->isSuccessful()) {
            $this->info('✅ yarn install berhasil.');
            return Command::SUCCESS;
        } else {
            $this->error('❌ yarn install gagal.');
            return Command::FAILURE;
        }
    }

    private function isYarnAvailable(): bool
    {
        $check = Process::fromShellCommandline('command -v yarn');
        $check->run();

        return $check->isSuccessful();
    }
}
