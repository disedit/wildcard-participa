<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('edition_id');
            $table->string('SID', 20);
            $table->string('SMS_phone');
            $table->boolean('SMS_verified');
            $table->dateTime('SMS_time');
            $table->integer('ballots_cast');
            $table->dateTime('ballot_time');
            $table->string('signature', 64);
            $table->boolean('in_person');
            $table->integer('by_user');
            $table->ipAddress('ip_address');
            $table->string('user_agent');
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
        Schema::dropIfExists('voters');
    }
}
