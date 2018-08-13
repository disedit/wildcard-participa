<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('edition_id')->unsigned();
            $table->enum('template', ['cards', 'simple', '2column'])->default('cards');
            $table->integer('min_options');
            $table->integer('max_options');
            $table->boolean('display_cost');
            $table->boolean('random_order');
            $table->integer('results_to_highlight')->default(3);
            $table->timestamps();

            $table->foreign('edition_id')->references('id')->on('editions');
        });

        Schema::create('question_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->string('locale')->index();
            $table->string('question');
            $table->string('description')->nullable();

            $table->unique(['question_id','locale']);
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
