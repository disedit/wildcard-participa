<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Edition;
use App\Ballot;

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $edition = $this->option('edition');

        if($edition) {
            $edition = Edition::where($edition)->get();
        } else {
            $edition = new Edition;
            $edition = $edition->current();
        }

        $ballots = Ballot::where('edition_id', $edition->id)->get();

        $bar = $this->output->createProgressBar(count($ballots));
        $errors = [];

        foreach($ballots as $ballot) {
            if(!$ballot->check()) {
                $errors[] = [$ballot->cast_at, $ballot->ref];
            }
            sleep(1);
            $bar->advance();
        }

        $bar->finish();
        $this->line('');
        $this->line('');

        if(!$errors) {
            $this->line('Ballot check finished without errors.');
        } else {
            $this->error('Ballot check finisheded with errors. The following ballots are invalid!');

            $this->table(['Cast at', 'Ballot ref.'], $errors);
        }
    }
}
