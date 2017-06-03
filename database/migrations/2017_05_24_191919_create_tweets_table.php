<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->text('text');
            $table->bigInteger('retweeted_id')->unsigned()->nullable();
            $table->bigInteger('reply_to_id')->unsigned()->nullable();
            $table->string('country_code')->nullable();
            $table->string('place_name')->nullable();
            $table->dateTime('tweeted_at');
            $table->integer('dj');
            $table->boolean('fetched')->default(false);

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tweets');
    }
}
