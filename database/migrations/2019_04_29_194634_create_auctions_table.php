<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('home_id')->unsigned();
            $table->foreign('home_id')->references('id')->on('homes');
            $table->boolean('active')->default(true);
            $table->date('starting_date');
            $table->date('end_date');
            $table->date('week');
            $table->integer('base_price');
            $table->integer('best_bid_value')->default(0);
            $table->integer('winner_id')->nullable();   
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctions');
    }
}
