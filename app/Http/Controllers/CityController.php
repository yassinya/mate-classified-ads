<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\Slug;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function createCity(Request $req)
    {
        $city = new City();
        $city->name = $req->city_name;
        $city->region_id = $req->region_id;
        $city->slug = Slug::make($city, $req->city_name);
        $city->save();

        return redirect()->back()->with(['success' => 'City successfully saved']);
    }

    public function showEditCityForm($id)
    {
        $city = City::whereId($id)->with('region')->first();

        if(!$city){
            abort(404);
        }

        return view('admin.cities.edit', [
            'city' => $city,
        ]);
    }

    public function updateCity(Request $req)
    {
        $city = City::whereId($req->city_id)->first();

        if(! $city){
            abort(404);
        }

        $city->name = $req->city_name;
        $city->slug = Slug::make($city, $req->city_name);
        $city->save();

        return redirect()->back()->with(['success' => 'City successfully update']);
    }

    public function deleteCity(Request $req){

        $city =  City::whereId($req->city_id)
                     ->withoutGlobalScopes(['reviewed', 'suspended', 'conrirmed'])
                     ->with('ads')
                     ->first();
        // delete and unlink its ads
        foreach ($city->ads as $ad) {
            $ad->city_id = null;
            $ad->save();
        }

        $city->delete();

        return redirect()->route('admin.regions.show', [
            'id' => $req->region_id,
        ]);
    }
}
