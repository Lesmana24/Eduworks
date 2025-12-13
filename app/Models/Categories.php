<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
