<?php

namespace Database\Seeders;

use App\Models\RestaurantTable;
use Illuminate\Database\Seeder;

class RestaurantTableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['number' => 1,  'capacity' => 2],
            ['number' => 2,  'capacity' => 2],
            ['number' => 3,  'capacity' => 4],
            ['number' => 4,  'capacity' => 4],
            ['number' => 5,  'capacity' => 4],
            ['number' => 6,  'capacity' => 6],
            ['number' => 7,  'capacity' => 6],
            ['number' => 8,  'capacity' => 8],
            ['number' => 9,  'capacity' => 8],
            ['number' => 10, 'capacity' => 10],
        ];

        foreach ($tables as $table) {
            RestaurantTable::create([
                'number'   => $table['number'],
                'capacity' => $table['capacity'],
                'status'   => 'free',
            ]);
        }
    }
}
