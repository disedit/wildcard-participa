<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editions', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('publish_results');
            $table->dateTime('proposal_deadline')->nullable();
            $table->boolean('published');
            $table->timestamps();
        });

        Schema::create('edition_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('edition_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->string('description')->nullable();
            $table->text('docs')->nullable();
            $table->text('voting_places')->nullable();
            $table->string('proposal_form')->default('');
            $table->text('about')->nullable();
            $table->text('sidebar')->nullable();

            $table->unique(['edition_id','locale']);
            $table->foreign('edition_id')->references('id')->on('editions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('editions');
    }
}
