<?php

use App\Models\Region;
use App\Services\Slug;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regionNames = ['Dikhil', 'Arta', 'Obock', 'Tadjourah'];

        foreach ($regionNames as $name) {
            $region = new Region();
            $region->name = $name;
            $region->slug = Slug::make($region, $name);
            $region->save();
        }
    }
}
