<?php

namespace NumaxLab\Laravel\Dinahosting\Console\Commands;

use Illuminate\Console\Command;

class DinahostingSymlink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dinahosting:symlink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create symlink from www to public for Dinahosting installations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        $link = base_path('../www');
        $target = base_path('public');

        if (file_exists($link)) {
            $this->error("The [$link] link already exists.");
            return 1;
        }

        $this->laravel->make('files')->link($target, $link);

        $this->info("The [$link] link has been connected to [$target].");

        return 0;
    }
}
