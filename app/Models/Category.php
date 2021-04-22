<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public static function booted(){
        static::creating(function(Category $category){
            $category->uuid=Str::uuid();
        });
    }
    public function scopePagination($query,$per_page)
    {
        return $query->paginate(request('per-page',10));
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public static function columns()
    {
        return collect(Schema::getColumnListing(Category::getQuery()->from))
            ->reject(function ($column) {
                return in_array($column,['updated_at','created_at','uuid']);

            })
            ->toArray();
    }
    public static function edit_columns()
    {
        return collect(Schema::getColumnListing(Category::getQuery()->from))
            ->reject(function ($column) {
                return in_array($column,['id','user_id','slug','_lft','order','status','_rgt','deleted_at','updated_at','created_at','uuid']);

            })
            ->toArray();
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category')
            ->withTimestamps();
    }

}
