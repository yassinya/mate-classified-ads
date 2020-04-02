<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Services\Slug;
use App\Models\AdImage;
use App\Events\AdCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{
    public function showAdSubmissionForm(){
        return view('ads.post-ad');
    }
    
    public function postAd(Request $req)
    {
        // validate user inputs
        $validator = $this->validator($req->all());
        // return response()->json($req->all());

        if($validator->fails()) {
            return response()->json(['validation' => $validator->messages()], 500);
        }

        $ad = $this->createAd($req->all());

        if($ad){
            if($req->file){
                $this->saveImages($req->file, $ad->id);
            }
            // dispatch ad creation event
            event(new AdCreated($ad));
            return response()->json(['created' => true]);
        }
        
        // reaching here means ad was not saved because something went wrong
        // return error message
        return response()->json(['error' => 'Ops! Something went wrong, we could not create your post. Please try later'], 500);
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'title' => ['required', 'string',],
            'description' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
        ]);
    }

    protected function createAd(array $data){
        // get currently logged in user id, if there's any.
        // Otherwise set the user_id null for ads posted by guest users
        $userId = auth()->check() ? auth()->id() : null;
        // generate a unique slug based on the title
        // we'll use this slug as an id and it'll appear in the url
        $adModel = new Ad();
        $slug = Slug::make($adModel, $data['title']);

        return Ad::create([
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'category_id' => $data['category_id'],
            'city_id' => $data['city_id'],
            'user_id' => $userId,
            'type_id' => $data['type_id'],
        ]);

    }

    public function showSingleAd($slug){
        $ad = Ad::whereSlug($slug)->with('category', 'category.ads')->first();
        // TODO return 404

        return view('ads.single-ad', ['ad' => $ad]);
    }

    protected function saveImages($files, $adId){
        
        foreach($files as $file){
            create_ad_img($file, $adId);
        }
    }
}
