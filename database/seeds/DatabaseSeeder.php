<?php

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
        // $this->call(UsersTableSeeder::class);

        DB::table('menu_category')->insert([
            [
                'name' => 'Burger',
            ],
            [
                'name' => 'Beverages'
            ],
            [
                'name' => 'Combo Meals'
            ]
        ]);


        DB::table('menu_list')->insert([
            [
                'name' => 'Hotdog',
                'category' => 'Burger',
                'vat' => 0.12,
                'price' => 60

            ],
            [
                'name' => 'Cheese Burger',
                'category' => 'Burger',
                'vat' => 0.12,
                'price' => 65
            ],
            [
                'name' => 'Fries',
                'category' => 'Burger',
                'vat' => 0.12,
                'price' => 40
            ],
            [
                'name' => 'Coke',
                'category' => 'Beverages',
                'vat' => 0.12,
                'price' => 55
            ],
            [
                'name' => 'Sprite',
                'category' => 'Beverages',
                'vat' => 0.12,
                'price' => 55
            ],
            [
                'name' => 'Tea',
                'category' => 'Beverages',
                'vat' => 0.12,
                'price' => 50
            ],
            [
                'name' => 'Chicken Combo',
                'category' => 'Combo Meals',
                'vat' => 0.12,
                'price' => 95
            ],
            [
                'name' => 'Pork Combo',
                'category' => 'Combo Meals',
                'vat' => 0.12,
                'price' => 95
            ],
            [
                'name' => 'Fish Combo',
                'category' => 'Combo Meals',
                'vat' => 0.12,
                'price' => 95
            ]
        ]);


    }
}
