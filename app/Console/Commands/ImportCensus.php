<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportCensus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'participa:census';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load census onto database';

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
