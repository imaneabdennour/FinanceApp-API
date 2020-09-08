<?php

use Illuminate\Database\Seeder;

class GerantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gerants')->insert(array(
           array(
              'civilité' => 'Mdm',
              'nom_complet' => 'Imane Abdennour',
              'email' => "imane0@gmail.com",
              'telef' => "+212680851730",
              'entreprise' => "Yellowrock"
            ),
            array(
                'civilité' => 'Mdm',
                'nom_complet' => 'Salma Moussafir',
                'email' => "salma@gmail.com",
                'telef' => "+212708160845",
                'entreprise' => "OCP"
            ),
          ));
    }
}
