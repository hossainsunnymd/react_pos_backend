<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'phone', 'address'])]
class Customer extends Model
{
    use BelongsToUser;
    public function invoices():HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
