<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
