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
            $table->integer('voter_id');
            $table->text('ballot');
            $table->string('ref');
            $table->string('stamp');
            $table->string('signature');
            $table->dateTime('cast_at');
            $table->integer('by_user');
            $table->ipAddress('ip_address');
            $table->text('user_agent');
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
