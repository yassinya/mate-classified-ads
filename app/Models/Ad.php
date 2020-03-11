<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'title',
        'slug', 
        'description', 
        'email', 
        'phone_number',
        'category_id', 
        'user_id',
        'city_id',
        'type_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\AdType');
    }
}
