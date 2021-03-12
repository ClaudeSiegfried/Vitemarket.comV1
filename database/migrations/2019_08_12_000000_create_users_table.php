<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('uid')->nullable();
            $table->string('fcm')->nullable();
            $table->date('date_de_naissance')->nullable();
            $table->string('metier', 50)->nullable();
            $table->string('tel')->default(0)->index();
            $table->string('adresse', 200)->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('verified')->default(false);
            $table->unsignedBigInteger('photo_id')->nullable();
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->foreign('photo_id')->references('id')->on('photos')->cascadeOnDelete();
            $table->foreign('discount_id')->references('id')->on('discounts')->cascadeOnDelete();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
