<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert(array(
            array(
                'nom_entreprise' => "OCP",
                'adresse' => "sidi maarouf ocp group",
                'ville' => 'Casablanca',
                'num_compte_bancaire' => '1234567891234567',
                'RC' => "RC4567",
                'ICE' => "ICE4567",
                'category' =>"categ",
            ),
            array(
                'nom_entreprise' => "Yellowrock",
                'adresse' => "centre ville ocp group",
                'ville' => 'Casablanca',
                'num_compte_bancaire' => '11111111111234567',
                'RC' => "RC5687",
                'ICE' => "ICE5678",
                'category' =>"categ1",
            ),
        ));
    }
}
