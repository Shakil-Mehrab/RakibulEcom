<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Bag\Product\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    public static function booted(){
        static::creating(function(Product $product){
            $product->uuid=Str::uuid();
            $product->status = ProductStatus::PENDING;
        });
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
