<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyProviderPercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_provider_percentages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mmoney_id')->nullable()->constrained()->cascadeOnDelete();
            $table->integer('percentage')->nullable('4');
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
        Schema::dropIfExists('money_provider_percentages');
    }
}
