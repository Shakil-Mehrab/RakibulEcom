<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Bag\Product\ProductStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public static function booted(){
        static::creating(function(Product $product){
            $product->uuid=Str::uuid();
            $product->status = ProductStatus::PENDING;
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
        return collect(Schema::getColumnListing(Product::getQuery()->from))
            ->reject(function ($column) {
                return in_array($column,['deleted_at','description','short_description','updated_at','created_at','uuid']);

            })
            ->toArray();
    }
    public static function edit_columns()
    {
        return collect(Schema::getColumnListing(Product::getQuery()->from))
            ->reject(function ($column) {
                return in_array($column,['id','user_id','slug','top','order','status','viewers','deleted_at','updated_at','created_at','uuid']);

            })
            ->toArray();     
        // $collection=collect(['name','brand','price','short_description','description','thumbnail']);
        // return $collection;
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category')
            ->withTimestamps();
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size')
            ->withTimestamps();
    }

}
