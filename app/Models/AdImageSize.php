<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdImageSize extends Model
{
    public function image()
    {
        return $this->belongsTo('App\Models\AdImage', 'ad_image_id');
    }
}
