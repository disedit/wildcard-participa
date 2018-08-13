<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->text('attachments')->nullable();
            $table->text('pictures')->nullable();
            $table->double('cost', 10, 2)->nullable();
            $table->string('salt');
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions');
        });

        Schema::create('option_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('option_id')->unsigned();
            $table->string('locale')->index();
            $table->string('option');
            $table->text('description')->nullable();
            $table->text('motivation')->nullable();

            $table->unique(['option_id','locale']);
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
}
