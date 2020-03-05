<?php

namespace App\Http\Controllers;

use App\Models\AdImage;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    function uploadImage(Request $req){
        
        $imageId = create_ad_img($req->file);

        return response()->json([
            'id' => $imageId,
        ]);
    }

    function removeImage(Request $req){
        
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
}
