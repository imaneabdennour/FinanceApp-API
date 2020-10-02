<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDetailsProductFactures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->string('montant_en_lettres')->after('nature');
            $table->string('devise')->after('nature');
            $table->string('montant_TTC')->after('nature');
            $table->string('TVA')->after('nature');
            $table->string('taux_TVA')->after('nature');
            $table->string('montant_HT')->after('nature');
            $table->string('prix_unit')->after('nature');
            $table->string('quantite')->after('nature');
            $table->string('produit')->after('nature');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factures', function (Blueprint $table) {
            //
        });
    }
}
