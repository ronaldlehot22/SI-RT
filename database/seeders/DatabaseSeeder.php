<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin default
        User::firstOrCreate(
            ['email' => 'admin@rt12.id'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('admin123'),
                'role'     => 'superadmin',
            ]
        );

        // Contoh akun per jabatan
        $accounts = [
            ['name' => 'Ketua RT',      'email' => 'ketua@rt12.id',      'role' => 'ketua_rt'],
            ['name' => 'Sekretaris RT', 'email' => 'sekretaris@rt12.id', 'role' => 'sekretaris_rt'],
            ['name' => 'Bendahara RT',  'email' => 'bendahara@rt12.id',  'role' => 'bendahara_rt'],
        ];

        foreach ($accounts as $account) {
            User::firstOrCreate(
                ['email' => $account['email']],
                array_merge($account, ['password' => Hash::make('rt12345')])
            );
        }
    }
}
