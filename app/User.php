<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getFullNameAttribute()
    {
        return $this->first_name ." ". $this->last_name;
    }

    public function pending()
    {
        $order_details = Order::pending($this->id)->first();
        /* $cart_count = 0;
        $order_id = 0;
        $items = null;
        $order_details = [];
        if(!is_null($pending)){
            $items = $pending->items;
            $cart_count = $pending->items->count();
            $order_id = $pending->id;
        } */

        return $order_details;//compact('cart_count', 'order_id', 'items', 'order_details');
    }
}
