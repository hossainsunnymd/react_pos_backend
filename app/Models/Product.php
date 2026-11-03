<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['category_id', 'name', 'description', 'price', 'qty', 'image'])]
class Product extends Model
{
    use BelongsToUser;
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
