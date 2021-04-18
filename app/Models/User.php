<?php

namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function scopePagination($query,$per_page)
    {
        return $query->paginate(request('per-page',10));
    }
    public function products(){
       return $this->hasMany('App\Models\Product');
    }

    public function categories(){
        return $this->hasMany('App\Models\Category');
     }
     public static function columns()
     {
         return collect(Schema::getColumnListing(User::getQuery()->from))
             ->reject(function ($column) {
                 return in_array($column,['email_verified_at','remember_token','updated_at','created_at','uuid','password',]);
 
             })
             ->toArray();
     }
}
