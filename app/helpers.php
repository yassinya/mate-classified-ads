<?php

use Carbon\Carbon;
use App\Models\AdImage;
use App\Models\AdImageSize;
use Intervention\Image\Facades\Image;


if(! function_exists('create_ads_img')){
    function create_ad_img($image_file, $ad_id){
        $image_sizes_to_store = uploadImg($image_file);
        $created_image_sizes = [];
        $image = new AdImage();
        $image->ad_id = $ad_id;
        $image->save();
        // store different sizes for this image
        foreach ($image_sizes_to_store as $type => $name) {
            $image_size = new AdImageSize();
            $image_size->type = $type;
            $image_size->name = $name;
            $image_size->image()->associate($image);
            if($image_size->save()) $created_image_sizes[$type] = $name;
        }
        return $image;
    }
}

if(! function_exists('uploadImg')){
    function uploadImg($img, $dir = 'public/images'){
        $filenameWithExtension = $img->getClientOriginalName();
        // get the file's extension 
        $extension = $img->getClientOriginalExtension();
        // assign a unique name to this file
        // using its calculated md5 hash & a random number
        $hash = md5_file($img);
        $rand_number = rand(0, 10000000);
        $filenameToStore = $hash . '_' . $rand_number . '_' . time() . '.' . $extension;
        // store it
        $img->storeAs($dir, $filenameToStore);
        
        $image_versions_sizes = [
            'mini_thumbnail' => [
            'width' => '120',
            'height' => '120',
            ],
            'slider' => [
            'width' => '800',
            'height' => '600',
            ],
        ];
    
        $generated_image_versions = [];
        $generated_image_versions['original'] = $filenameToStore;
    
        foreach ($image_versions_sizes as $type => $size) {
            $generated_image = ymake_thumbnails($filenameToStore, $size['width'], $size['height']);
            $generated_image_versions[$type] = $generated_image;
        }
        return $generated_image_versions;
    }
}

/**
 * make thumnails with different sizes of an already saved img
 * @param string img_name
 * @param int width
 * @param int height
 */
if(! function_exists('ymake_thumbnails')){
    function ymake_thumbnails($img_name,$boxWidth, $boxHeigth){
        
        // get the path of the saved image
        $originalImagePath = public_path('storage/images/'.$img_name);
        // resize the image
        $img = Image::make($originalImagePath);
        $width  = $img->width();
        $height = $img->height();


        /*
        *  canvas
        */
        $dimension = 2362;

        $vertical   = (($width < $height) ? true : false);
        $horizontal = (($width > $height) ? true : false);
        $square     = (($width = $height) ? true : false);
        $padding = 20;

        if ($vertical) {
            // we'll resize width or height base on the box shape
            if($boxWidth > $boxHeigth){
                // if the box is horizontal/rectangle, we'll assign a new height
                $newHeight = $boxHeigth - $padding;
                $img->resize(null, $newHeight, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }else{
                // if its another shape, we'll assign a new width
                $newWidth = $boxWidth - $padding;
                $img->resize($newWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        } else if ($horizontal) {
            // we'll resize width or height base on the box shape
            if($boxWidth > $boxHeigth){
                // if the box is horizontal/rectangle, we'll assign a new height
                $newHeight = $boxHeigth - $padding;
                $img->resize(null, $newHeight, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }else{
                // if its another shape, we'll assign a new width
                $newWidth = $boxWidth- $padding;
                $img->resize($newWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

        } else if ($square) {
            if($boxWidth > $boxHeigth){
                // if the box is horizontal/rectangle, we'll assign a new height
                $newHeight = $boxHeigth - $padding;
                $img->resize(null, $newHeight, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }else{
                // if its another shape, we'll assign a new width
                $newWidth = $boxWidth- $padding;
                $img->resize($newWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }

        $file_name = pathinfo(public_path('storage/images/'.$img_name), PATHINFO_FILENAME);
        $file_extension = pathinfo(public_path('storage/images/'.$img_name), PATHINFO_EXTENSION);
        $final_name = $file_name . '_' . $boxWidth . '_' . $boxHeigth . '.' . $file_extension;
        $img->resizeCanvas($boxWidth, $boxHeigth, 'center', false, '#fff');
        $img->save(public_path('storage/images/'.$final_name));
        
        return $final_name;
    }
}

if(! function_exists('caRelativeDate')){
    function caRelativeDate($date){
        return $date->diffIndays(Carbon::now()) >= 7 ? $date->tz("Africa/Djibouti")->toDateString() : $date->tz("Africa/Djibouti")->diffForHumans();
    }
}