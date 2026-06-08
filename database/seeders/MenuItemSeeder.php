<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Entradas' => [
                ['name' => 'Patacones con hogao',       'price' => 12000, 'description' => 'Patacones fritos con hogao casero y ají'],
                ['name' => 'Arepa con chicharrón',      'price' => 10000, 'description' => 'Arepa de maíz con chicharrón crujiente'],
                ['name' => 'Deditos de queso',          'price' => 11000, 'description' => '6 deditos de queso con salsa rosada'],
                ['name' => 'Chorizo santarrosano',      'price' => 14000, 'description' => 'Chorizo asado con arepa y ají'],
            ],
            'Platos Fuertes' => [
                ['name' => 'Bandeja paisa',             'price' => 35000, 'description' => 'Frijoles, arroz, carne molida, chicharrón, huevo y más'],
                ['name' => 'Trucha al ajillo',          'price' => 32000, 'description' => 'Trucha fresca con ajillo, papas y ensalada'],
                ['name' => 'Pechuga a la plancha',      'price' => 28000, 'description' => 'Pechuga de pollo con arroz y ensalada mixta'],
                ['name' => 'Costilla BBQ',              'price' => 38000, 'description' => 'Costillas de cerdo con salsa BBQ, papas y coleslaw'],
                ['name' => 'Sancocho de gallina',       'price' => 25000, 'description' => 'Tradicional sancocho con yuca, papa y mazorca'],
            ],
            'Bebidas' => [
                ['name' => 'Limonada de coco',          'price' => 9000,  'description' => 'Limonada cremosa con coco rallado'],
                ['name' => 'Jugo natural',               'price' => 7000,  'description' => 'Maracuyá, mora, lulo o mango (elige al pedir)'],
                ['name' => 'Gaseosa personal',          'price' => 5000,  'description' => 'Coca-Cola, Sprite o Postobon'],
                ['name' => 'Agua aromática',            'price' => 3500,  'description' => 'Hierbas seleccionadas de la huerta'],
            ],
            'Postres' => [
                ['name' => 'Tres leches',               'price' => 12000, 'description' => 'Bizcocho húmedo bañado en tres leches con merengue'],
                ['name' => 'Brownie con helado',        'price' => 14000, 'description' => 'Brownie tibio de chocolate con bola de vainilla'],
                ['name' => 'Flan de caramelo',          'price' => 10000, 'description' => 'Flan casero con caramelo artesanal'],
            ],
        ];

        foreach ($items as $categoryName => $menuItems) {
            $category = Category::where('name', $categoryName)->first();
            foreach ($menuItems as $item) {
                MenuItem::create([
                    'category_id' => $category->id,
                    'name'        => $item['name'],
                    'description' => $item['description'],
                    'price'       => $item['price'],
                    'available'   => true,
                ]);
            }
        }
    }
}
