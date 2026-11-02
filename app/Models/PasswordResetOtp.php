<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['phone', 'otp', 'expires_at'])]
class PasswordResetOtp extends Model
{
    //
}
