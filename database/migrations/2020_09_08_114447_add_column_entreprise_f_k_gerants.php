<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEntrepriseFKGerants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gerants', function (Blueprint $table) {
           //fk(Client) : pk of Client is nom_entreprise :
           $table->string('entreprise');
           $table->foreign('entreprise')->references('nom_entreprise')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gerants', function (Blueprint $table) {
            $table->dropColumn('entreprise');

        });
    }
}
