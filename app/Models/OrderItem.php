<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'order_id', 'menu_id', 'quantity'
   ];

   public function orderedmenu()
    {
        return $this->hasOne('App\Models\Menu', 'id', 'menu_id');
    }
}
