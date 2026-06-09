<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usar updateOrCreate para evitar duplicados
        User::updateOrCreate(
            ['email' => 'admin@restopedidos.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'mesero@restopedidos.com'],
            [
                'name'     => 'Mesero Juan',
                'password' => Hash::make('password'),
                'role'     => 'waiter',
            ]
        );

        User::updateOrCreate(
            ['email' => 'ana@restopedidos.com'],
            [
                'name'     => 'Mesera Ana',
                'password' => Hash::make('password'),
                'role'     => 'waiter',
            ]
        );
    }
}