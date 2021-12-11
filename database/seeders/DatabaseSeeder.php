<?php

namespace Database\Seeders;

use App\Http\Controllers\EspaiderJuizosController;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            EspaiderOrgaosSeeder::class,
            EspaiderUfsSeeder::class,
            EspaiderComarcasSeeder::class,
            EspaiderJuizosSeeder::class,
            EseloComarcasSeeder::class,
            EseloJuizosSeeder::class,
            SistemasJudJuizosSeeder::class,
            GenerosSeeder::class,
            SomeUsersSeeder::class,
            TabelasSeeder::class,
            TiposPermissoesSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
