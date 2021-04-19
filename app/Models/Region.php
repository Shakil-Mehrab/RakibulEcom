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

            // $prefix = $model->parent ? $model->parent->slug . ' ' : '';
            // $model->slug = Str::slug($prefix . $model->slug);
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
                return in_array($column,['deleted_at','description','short_description','updated_at','created_at','uuid']);

            })
            ->toArray();
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
