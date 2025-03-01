<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Services\Slug;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function showRegionsManagement()
    {
        return view('admin.regions.index');
    }

    public function showRegion($id)
    {
        $region = Region::whereId($id)->with('cities')->first();

        if(! $region){
            abort(404);
        }

        return view('admin.regions.show', [
            'region' => $region,
        ]);
    }

    public function updateRegion(Request $req)
    {
        $region = Region::whereId($req->region_id)->first();

        if(! $region){
            abort(404);
        }

        $region->name = $req->region_name;
        $region->slug = Slug::make($region, $req->region_name);
        $region->save();

        return redirect()->back()->with(['success' => 'Region successfully update']);
    }

    public function createRegion(Request $req)
    {
        $region = new Region();
        $region->name = $req->region_name;
        $region->slug = Slug::make($region, $req->region_name);
        $region->save();

        return redirect()->back()->with(['success' => 'Region successfully saved']);
    }

    public function showEditRegionForm($id)
    {
        $region = Region::whereId($id)->first();

        if(!$region){
            abort(404);
        }

        return view('admin.regions.edit', [
            'region' => $region,
        ]);
    }

    public function deleteRegion(Request $req){

        $region =  Region::whereId($req->region_id)
                     ->with('cities', 'cities.ads')
                     ->first();
        // delete its cities and unlink their ads
        foreach ($region->cities as $city) {
            foreach ($city->ads as $ad) {
                $ad->city_id = null;
                $ad->save();
            }
            $city->delete();
        }

        $region->delete();

        return redirect()->route('admin.regions')->with(['success' => 'Region successfully deleted']);
    }
}
