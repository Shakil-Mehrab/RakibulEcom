<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Category\CategoryColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory,PaginationTrait,CategoryColumn;
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public static function booted(){
        static::creating(function(Model $model){
            $model->uuid=Str::uuid();
        });
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category')
            ->withTimestamps();
    }

}
