<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'barcode', 'category_id', 'supplier_id', 'unit_price', 'in_stock', 'picture'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}