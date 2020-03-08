<?php

use App\Models\City;
use App\Services\Slug;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            1 => ['Yoboki', 'Mouloud'], 
            2 => ['Wea'], 
            3 => ['Lahassa', 'Waddi'], 
            4 => ['Sagalou', 'Hankatta']
        ];

        foreach ($cities as $regionId => $cityNames) {
            foreach($cityNames as $cityName){
                $city = new City();
                $city->name = $cityName;
                $city->slug = Slug::make($city, $cityName);
                $city->region_id = $regionId;
                $city->save();
            }
        }
    }
}
