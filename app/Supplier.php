<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['company_name', 'country', 'city', 'state', 'postcode', 'address', 'phone', 'email', 'logo'];

    public function products(){
        return $this->hasMany(Product::class);
    }
}