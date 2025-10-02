<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin User
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@earsip.com'],
            [
                'nama_lengkap' => 'Administrator System',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'foto' => null,
                'id_role' => 1, // Administrator role
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // Operator User
        DB::table('users')->updateOrInsert(
            ['email' => 'operator@earsip.com'],
            [
                'nama_lengkap' => 'Operator Test',
                'username' => 'operator',
                'password' => Hash::make('operator123'),
                'foto' => null,
                'id_role' => 2, // Operator role
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}
