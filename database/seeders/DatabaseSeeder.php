<?php

namespace Database\Seeders;

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
            RolesSeeder::class,
            AdminUserSeeder::class,
            KategoriSeeder::class,
            DokumenSeeder::class,
            SuratKeluarSeeder::class,
            SuratMasukSeeder::class,
        ]);
        // User::factory(10)->create();
    }
}
