<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('Libele');
            $table->text('description');
            $table->float('taille', 8, 2)->default(0);
            $table->decimal('poids', 8, 2)->default(0);
            $table->decimal('prix')->default(0);
            $table->string('code_gen')->nullable();
            $table->date('date_de_creation')->nullable();
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->foreignId('marque_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('fournisseur_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('photo_id')->nullable()->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('produits');
    }
}
