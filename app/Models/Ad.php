<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('conrirmed', function (Builder $builder) {
            $builder->whereNotNull('confirmed_at');
        });

        static::addGlobalScope('reviewed', function (Builder $builder) {
            $builder->whereNotNull('reviewed_at');
        });
    }

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

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function images()
    {
        return $this->hasMany('App\Models\AdImage');
    }

    public function scopeFilter($query, $filters){
        if(isset($filters['region']) && $filters['region'] != 'all'){
            $query->whereHas('city.region', function($q) use($filters){
                $q->whereSlug($filters['region']);
            });
        }

        if(isset($filters['city']) && $filters['city'] != 'all'){
            $query->whereHas('city', function($q) use($filters){
                $q->whereSlug($filters['city']);
            });
        }

        return $query;
    }
}
