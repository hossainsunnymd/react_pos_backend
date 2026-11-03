<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'invoice_id',
    'product_id',
    'qty',
    'sale_price',
])]
class InvoiceProduct extends Model
{
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
