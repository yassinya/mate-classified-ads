<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Services\Slug;
use App\Models\AdImage;
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

        if($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // make sur that user picked a category
        if($req->category_id == '-'){
            return redirect()->back()
                             ->with(['error' => 'Please pick a category'])
                             ->withInput();
        }

        // make sur that user picked a city
        if($req->city_id == '-'){
            return redirect()->back()
                                ->with(['error' => 'Please pick a city'])
                                ->withInput();
        }

        // make sur that user specified ad type
        if($req->type_id == '-'){
            return redirect()->back()
                                ->with(['error' => 'Please specify type of ad'])
                                ->withInput();
        }

        $ad = $this->createAd($req->all());
        $uploadedImages = AdImage::whereIn('id', $req->img_ids)
                                 ->whereNull('ad_id')
                                 ->get();

        if($ad){
            // Attach images that were uploaded in background to the ad
            foreach($uploadedImages as $image){
                $image->ad_id = $ad->id;
                $image->save();
            }
            return redirect()->route('ads.show.single', ['slug' => $ad->slug]);
        }
        
        // reaching here means ad was not saved because something went wrong
        // return error message
        return redirect()->back()
                         ->withInput($req->except('password'))
                         ->withErrors([
                             'Ops! Something went wrong, we could not create your post. Please try later'
                         ]);
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'title' => ['required', 'string'],
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
}
