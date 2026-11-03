<?php

namespace App\Models\Concerns;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToUser
{
    protected static function booted(): void
    {
        static::addGlobalScope('store', function (Builder $builder) {
            $builder->where('user_id', auth()->user()->id);
        });

        static::creating(function (self $model) :void{
            $model->user_id = auth()->user()->id;
        });
    }
}
