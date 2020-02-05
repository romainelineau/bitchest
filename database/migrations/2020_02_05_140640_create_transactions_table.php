<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date_purchase'); // DATETIME : date d'achat
            $table->float('quantity'); // FLOAT : quantité achetée - pas de limite dans les paramètres
            $table->decimal('price_currency', 8, 2); // DECIMAL : prix du cours de la monnaie
            $table->decimal('amount_investment', 8, 2); // DECIMAL : montant de l'investissement en euros
            $table->dateTime('date_sale')->nullable(); // DATETIME : date de revente
            $table->decimal('amount_sale', 8, 2)->nullable(); // DECIMAL : montant total récupéré en euros
            $table->boolean('sold'); // BOOLEAN : true = vendu
            $table->unsignedInteger('user_id'); // INT : id user
            $table->unsignedInteger('currency_id'); // INT : id currency
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('currency_id')->references('id')->on('currencies');
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
        Schema::dropIfExists('transactions');
    }
}
