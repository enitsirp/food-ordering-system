<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     protected $fillable = [
         'category_id', 'menu', 'price', 'tax'
     ];

    public function category()
    {
        return $this->belongsTo('App\Models\MenuCategory', 'category_id');
    }

    public function getTotalPriceAttribute()
    {
        return number_format($this->price + $this->tax, 2);
    }
}
