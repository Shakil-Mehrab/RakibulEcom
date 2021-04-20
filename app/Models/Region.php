<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'uuid',
        'slug',
        'eng_name',
        'parent_id',
        'order',
        'lat',
        'lng'
    ];
    public static function booted()
    {
        static::creating(function (Model $model) {
            $model->uuid = Str::uuid();
            $model->slug=Str::uuid();
            $model->eng_name = $model->slug;

            $prefix = $model->parent ? $model->parent->slug . ' ' : '';
            $model->slug = Str::slug($prefix . $model->slug);
        });
    }
    public function scopePagination($query,$per_page)
    {
        return $query->paginate(request('per-page',10));
    }
    public static function columns()
    {
        return collect(Schema::getColumnListing(Region::getQuery()->from))
            ->reject(function ($column) {
                return in_array($column,['deleted_at','updated_at','created_at','uuid','_lft','_rgt','lng','lat']);

            })
            ->toArray();           
    }
    public static function edit_columns()
    {
        return collect(Schema::getColumnListing(Region::getQuery()->from))
            ->reject(function ($column) {
                return in_array($column,['order','updated_at','created_at','uuid','_lft','_rgt','lng','lat','id','slug','eng_name']);

            })
            ->toArray();     
        // $collection=collect(['name','brand','price','short_description','description','thumbnail']);
        // return $collection;
    }
    public function getScoutKey()
    {
        return $this->slug;
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }


}
