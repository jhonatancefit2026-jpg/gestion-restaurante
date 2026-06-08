<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@restopedidos.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Mesero Juan',
            'email'    => 'mesero@restopedidos.com',
            'password' => Hash::make('password'),
            'role'     => 'waiter',
        ]);

        User::create([
            'name'     => 'Mesera Ana',
            'email'    => 'ana@restopedidos.com',
            'password' => Hash::make('password'),
            'role'     => 'waiter',
        ]);
    }
}
