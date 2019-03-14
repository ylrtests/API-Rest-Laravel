<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public $timestamp = false;

    /**
     * Get the products for the category
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
