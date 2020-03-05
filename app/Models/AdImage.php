<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    public function ad()
    {
        return $this->belongsTo('App\Models\Ad');
    }

    public function sizes()
    {
        return $this->hasMany('App\Models\AdImageSize');
    }
}
