<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdType extends Model
{
    public function ads()
    {
        return $this->hasMany('App\Models\Ad');
    }
}
