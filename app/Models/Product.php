<?php

namespace App\Models;

use Illuminate\Support\Str;
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
    public function scopePagination($query, $per_page=10)
    {
        // dump($per_page);
        return $query->paginate($per_page);
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
}
