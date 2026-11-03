<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'customer_id',
    'total',
    'discount',
    'vat',
    'payable'
])]
class Invoice extends Model
{
    use BelongsToUser;
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoiceProducts():HasMany
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
