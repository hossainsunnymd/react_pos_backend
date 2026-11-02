<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['category_id', 'name', 'description', 'price', 'qty', 'image'])]
class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
