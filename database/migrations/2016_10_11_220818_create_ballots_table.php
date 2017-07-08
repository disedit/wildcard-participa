<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBallotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ballots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('edition_id');
            $table->integer('voter_id')->nullable();
            $table->string('ref', 10);
            $table->text('ballot');
            $table->string('signature', 64);
            $table->dateTime('cast_at');
            $table->integer('by_user');
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ballots');
    }
}
