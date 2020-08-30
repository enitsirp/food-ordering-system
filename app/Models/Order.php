<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'coupon', 'total_order', 'status'
    ];

    public function scopePending($query, $user_id)
    {
       return $query->where('status', 'Pending')->where('user_id', $user_id);
    }

    public function items()
    {
       return  $this->hasMany('App\Models\OrderItem', 'order_id');
    }

    public function discount()
    {
        return  $this->hasOne('App\Models\Coupon', 'id', 'coupon');
    }
}
