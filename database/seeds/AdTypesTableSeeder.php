<?php

use App\Models\AdType;
use Illuminate\Database\Seeder;

class AdTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['sell', 'offer', 'request'];

        foreach ($types as $type) {
            $adType = new AdType();
            $adType->name = $type;
            $adType->save();
        }
    }
}
