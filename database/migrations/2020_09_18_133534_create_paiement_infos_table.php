<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiement_infos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('tx_reference')->nullable();
            $table->foreignId('commande_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('identifier')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('amount')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('phone_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiement_infos');
    }
}
