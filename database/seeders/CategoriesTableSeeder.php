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
            'category' => 'Invoice',
            'description' => 'Add invoice'
        ]);

        Category::create([
            'category' => 'Receipt',
            'description' => 'Add receipt'
        ]);

        Category::create([
            'category' => 'Supplier',
            'description' => 'Add supplier'
        ]);

        Category::create([
            'category' => 'Expense',
            'description' => 'Add expense'
        ]);

        Category::create([
            'category' => 'Bill',
            'description' => 'Add bill'
        ]);

        Category::create([
            'category' => 'Customer',
            'description' => 'Add customer'
        ]);
    }
}
