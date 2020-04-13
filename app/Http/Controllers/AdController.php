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

    public function showAds(){
        $ads = Ad::with('user', 'category')
                  ->withoutGlobalScopes(['reviewed', 'suspended', 'conrirmed'])
                 ->paginate();

        return view('admin.ads.index', [
            'ads' => $ads
        ]);
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

    public function editAd(Request $req)
    {
        // validate user inputs
        $validator = $this->validator($req->all());

        if($validator->fails()) {
            return response()->json(['validation' => $validator->messages()], 500);
        }

        // if slug is provided
        if($req->filled('ad_slug')){
            // make sure that the new slug is unique
            if(! Slug::isAvailable(new Ad(), $req->ad_slug, $req->ad_id)){
                return response()->json(['error' => 'There\'s already an ad with this slug'], 500);
            }
        }

        if($this->updateAd($req->all())){
            return response()->json(['updated' => true]);
        }
        
        // reaching here means ad was not saved because something went wrong
        // return error message
        return response()->json(['error' => 'Ops! Something went wrong, we could not save your post. Please try later'], 500);
    }

    protected function validator(array $data){
        $rules = [
            'title' => ['required', 'string',],
            'description' => ['required', 'string'],
        ];
        // require email only if user is not logged in
        if(! auth()->check()){
            $rules['email'] = ['required', 'string', 'email'];
        }

        return Validator::make($data, $rules);
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
            'phone_number' => isset($data['phone_number']) ? $data['phone_number'] : null,
            'email' => auth()->check() ? auth()->user()->email : $data['email'],
            'category_id' => $data['category_id'],
            'city_id' => $data['city_id'],
            'user_id' => $userId,
            'type_id' => $data['type_id'],
        ]);

    }

    protected function updateAd(array $data){
        $ad = Ad::whereId($data['ad_id'])->first();

        $ad->title = $data['title'];
        $ad->description = $data['description'];
        $ad->phone_number = $data['phone_number'];
        $ad->email = $data['email'];
        $ad->category_id = $data['category_id'];
        $ad->city_id = $data['city_id'];
        $ad->type_id = $data['type_id'];
        if(isset($data['ad_slug'])){
            $ad->slug = str_slug($data['ad_slug']);
        }

        return $ad->save();
    }

    public function showSingleAd($slug){

        if(auth()->check() && auth()->user()->hasRole('admin')){
            $ad = Ad::whereSlug($slug)
                     ->with('category', 'category.ads')
                     ->withoutGlobalScopes(['reviewed', 'suspended', 'conrirmed'])
                     ->first();
        }else{
            $ad = Ad::whereSlug($slug)->with('category', 'category.ads')->first();
        }

        if(! $ad){
            abort(404);
        }

        return view('ads.single-ad', ['ad' => $ad]);
    }

    public function showAdEditingForm($slug){
        $ad = Ad::whereSlug($slug)->with('category', 'category.ads')->first();

        if(! $ad){
            abort(404);
        }
        // make sure that this ad belongs to the logged in user
        // and prevent editing of guest ads
        // Admin is an exception
        if(! auth()->user()->hasRole('admin')){
            if(! $ad->user_id || $ad->user_id != auth()->id()){
                abort(404);
            }
        }

        return view('ads.edit-ad', ['ad' => $ad]);
    }

    public function uploadSingleImage(Request $req){
        // return response()->json($req->all());
        $image = create_ad_img($req->file, $req->ad_id);
        
        return response()->json([
            'id' => $image->id,
        ]);
    }
        
    public function deleteSingleImage(Request $req){

        $image_to_delete = AdImage::whereId($req->img_id)
                                  ->with('sizes')
                                  ->first();

        $number_of_deleted_img_sizes = 0;
        foreach ( $image_to_delete->sizes as $img_size ) {
            $image_name = $img_size->name;
            $number_of_deleted_img_sizes;
            if( file_exists(public_path('storage/images/'.$image_name)) ){
                if( unlink(public_path('storage/images/'.$image_name)) ){
                    // delete img size from DB if it was successfully removed from the disk
                    $img_size->delete();
                    $number_of_deleted_img_sizes++;
                }
            } 
        }

        // delete image if all its sizes were successfully deleted
        if($number_of_deleted_img_sizes === $image_to_delete->sizes->count()){
                $image_to_delete->delete();

                return response()->json([
                    'status' => 200,
                ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No image with this name',
        ]);

    }
    
    public function getAdImages($id){
        $images = AdImage::whereAdId($id)
                              ->with('sizes')
                              ->get();
        $image_sizes_collections = $images->pluck('sizes');
        $response = [];
        foreach ($image_sizes_collections as $key => $image_sizes_collection) {
            foreach ($image_sizes_collection->where('type', 'mini_thumbnail') as $key => $image_size) {
                $image_name = $image_size->name;
                $imgObj['serverId'] = $image_size->ad_image_id;
                $imgObj['name'] = $image_name;
                $imgObj['url'] = asset('storage/images/'.$image_name);
                $imgObj['size'] = filesize(storage_path('app/public/images').'/'.$image_name);
                $response[] = $imgObj;
            }
        }

        return response()->json($response);
    }

    public function getLoggedInUserAds(){

        $pendingAds = auth()->user()->ads()->with('images', 'images.sizes')
                            ->pending()
                            ->get();
        $approvedAds = auth()->user()->ads()->with('images', 'images.sizes')
                             ->approved()
                             ->get();
        $suspendedAds = auth()->user()->ads()->with('images', 'images.sizes')
                             ->suspended()
                             ->get();
                            // dd($pendingAds);

        return view('ads.my-ads', [
            'pendingAds' => $pendingAds,
            'approvedAds' => $approvedAds,
            'suspendedAds' => $suspendedAds,
        ]);
    }

    public function reviewAd(Request $req)
    {
        $ad = Ad::whereId($req->ad_id)
                ->withoutGlobalScopes(['reviewed', 'suspended', 'conrirmed'])
                ->first();

        $ad->reviewed_at = now();
        $ad->is_suspended = $req->suspend;
        $ad->save();
        if($req->suspend == 0){
            return redirect()->back()->with(['success-msg' => 'successfully approved ad']);
        }else{
            return redirect()->back()->with(['success-msg' => 'successfully rejected and suspended ad']);
        }
    }

    public function toggleAdSuspension($adId, $suspend)
    {
        $ad = Ad::whereId($adId)
                ->withoutGlobalScopes(['reviewed', 'suspended', 'conrirmed'])
                ->first();

        $ad->is_suspended = $suspend;
        $ad->save();

        if($suspend == 0){
            return redirect()->back()->with(['success-msg' => 'successfully unsuspended ad']);
        }else{
            return redirect()->back()->with(['success-msg' => 'successfully suspended ad']);
        }
    }

    protected function saveImages($files, $adId){
        
        foreach($files as $file){
            create_ad_img($file, $adId);
        }
    }
}
