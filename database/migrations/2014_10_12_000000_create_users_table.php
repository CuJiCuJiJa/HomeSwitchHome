<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {  
            //FALTARIA IMPLEMENTAR EL MULTIAUTH
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('card_number')->unique()->nullable();
            $table->boolean('premium')->default(false);
            $table->integer('available_weeks')->default(2);
            $table->rememberToken();
            $table->timestamps();
            $table->deleted_at();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
