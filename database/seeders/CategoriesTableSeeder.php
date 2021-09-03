<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Invoice',
            'description' => 'Add invoice'
        ]);

        Category::create([
            'name' => 'Bill',
            'description' => 'Add bill'
        ]);

        Category::create([
            'name' => 'Customer',
            'description' => 'Add customer'
        ]);
    }
}
