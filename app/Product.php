<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'category_id', 'quantity', 'status'
    ];

    public $timestamp = false;

     /**
     * Get the category for the product
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }
}
