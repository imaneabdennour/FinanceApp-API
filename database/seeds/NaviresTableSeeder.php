<?php

use Illuminate\Database\Seeder;

class NaviresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('navires')->insert(array(
            array(
              'nom_navire' => 'Shan-Young',
              'statut' => 'En cours',
            ),
            array(
              'nom_navire' => 'Hirushsh',
              'statut' => 'Archivé',
            ),
          ));
    }
}
