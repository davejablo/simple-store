<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'method'];

    const ORDER_STATUS = ['canceled', 'in_progress', 'paid'];
    const PAYMENT_METHOD = ['card', 'cash'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
