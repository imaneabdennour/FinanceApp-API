<?php

use Illuminate\Database\Seeder;

class FacturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('factures')->insert(array(

            array(
              'num_commande' => 1,
              'num_facture' => 'P2020/000001',
              "client" => "OCP",
              'proforma' => "Oui",
              'condition' => "FGH",
              'navire' => 'Hirushsh',
              'statut' => "Payé",
                'date' => "2020/03/10",
                "nature" => "Natureghn"

            ),
          ));
    }
}
