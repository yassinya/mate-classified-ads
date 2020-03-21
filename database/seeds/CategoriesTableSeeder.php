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
        $colors = ['#bd2130', '#007bff', '#28a745', '#8228a7', '#28a766', '#463F1A', '#F72C25'];
        $categoryNames = ['Cars', 'Houses', 'Electronics', 'Smartphones', 'Babies', 'Fashion', 'Moto'];

        foreach ($categoryNames as $categoryName) {
            $category = new Category();
            $category->name = $categoryName;
            $category->slug = $categoryName;
            $category->color_hex = $colors[rand(0, 4)];
            $category->save();
        }
    }
}
