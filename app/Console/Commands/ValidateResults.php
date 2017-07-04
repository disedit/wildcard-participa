<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ValidateResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'results:validate {--edition=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate ballot integrity';

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
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
