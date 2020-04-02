<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdConfirmation extends Model
{
    public function ad()
    {
        return $this->belongsTo('App\Models\Ad')
                    ->withoutGlobalScope('reviewed')
                    ->withoutGlobalScope('conrirmed');
    }
}
