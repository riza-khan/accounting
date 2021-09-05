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
            'deletable' => true,
            'description' => 'Add invoice'
        ]);

        Category::create([
            'name' => 'Bill',
            'deletable' => true,
            'description' => 'Add bill'
        ]);

        Category::create([
            'name' => 'Customer',
            'deletable' => false,
            'description' => 'Add customer'
        ]);

        Category::create([
            'name' => 'Department',
            'description' => 'Add a Department'
        ]);

        Category::create([
            'name' => 'Account',
            'deletable' => false,
            'description' => 'Add a Account'
        ]);

        Category::create([
            'name' => 'Vendor',
            'description' => 'Add a Vendor'
        ]);

        Category::create([
            'name' => 'Estimate',
            'description' => 'Add a Estimate'
        ]);

        Category::create([
            'name' => 'Class',
            'description' => 'Add a Class'
        ]);
    }
}
