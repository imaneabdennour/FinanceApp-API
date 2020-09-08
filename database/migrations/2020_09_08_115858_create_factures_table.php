<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->integer('num_commande')->primary();
            $table->string('num_facture');

            //fk(Client):
            $table->string('client');
            $table->foreign('client')->references('nom_entreprise')->on('clients');

            $table->string('proforma');
            $table->string("condition");

            //fk(Navire):nom_navire
            $table->string('navire');
            $table->foreign('navire')->references('nom_navire')->on('navires');

            $table->string("statut");
            $table->date("date");
            $table->string("nature");

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
        Schema::dropIfExists('factures');
    }
}
