<?php

namespace NumaxLab\Laravel\Dinahosting\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class EnvoySetup extends Command
{
    protected $signature = 'dinahosting:envoy-setup {--force : Override Envoy.blade.php if it already exists}';

    protected $description = 'Install Laravel Envoy and create the initial Envoy.blade.php file';

    public function handle(): int
    {
        if (!$this->requireEnvoy()) {
            return static::FAILURE;
        }

        $this->createEnvoyFile();

        $this->info('🎉 Envoy successfully installed!');
        $this->comment('Configure your Envoy.blade.php file to your needs and execute your first deploy with `php vendor/bin/envoy run deploy`');

        return static::SUCCESS;
    }

    protected function requireEnvoy(): bool
    {
        $this->info('📦 Installing the laravel/envoy package...');

        $process = new Process(['composer', 'require', 'laravel/envoy', '--dev']);
        $process->setWorkingDirectory(base_path());
        $process->setTimeout(300);

        $process->setTty(true);

        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Installation failed:');
            $this->error($process->getErrorOutput());

            return false;
        }

        $this->line($process->getOutput());

        return true;
    }

    protected function createEnvoyFile(): void
    {
        $this->info('📝 Creating the Envoy.blade.php file...');

        $envoyFilePath = base_path('Envoy.blade.php');
        $stubPath = __DIR__.'/../../../stubs/envoy.stub';

        if (File::exists($envoyFilePath) && !$this->option('force')) {
            if (!$this->confirm('The Envoy.blade.php already exists. Do you want to override it?')) {
                $this->comment('Operation cancelled. The file already exists and was not overwritten.');
                return;
            }
        }

        File::copy($stubPath, $envoyFilePath);

        $this->info('Envoy.blade.php file created successfully.');
    }
}
