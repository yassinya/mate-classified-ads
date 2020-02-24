<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryNames = ['Cars', 'Houses', 'Electronics', 'Smartphones'];

        foreach ($categoryNames as $categoryName) {
            $category = new Category();
            $category->name = $categoryName;
            $category->slug = $categoryName;
            $category->save();
        }
    }
}
