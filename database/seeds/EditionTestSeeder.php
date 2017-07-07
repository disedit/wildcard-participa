<?php

use Illuminate\Database\Seeder;

class EditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Edition::class, 1)->create()->each(function(App\Edition $edition) {
            $edition->voters()->saveMany(factory(App\Voter::class, 2000)->make());
            $questions = $edition->questions()->saveMany(factory(App\Question::class, 4)->make());

            foreach($questions as $question){
                $question->options()->saveMany(factory(App\Option::class, 10)->make());
            }
        });
    }
}
