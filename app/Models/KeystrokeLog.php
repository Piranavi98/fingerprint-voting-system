<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeystrokeLog extends Model
{
   protected $fillable = [
        'user_id',
        'typing_pattern'
    ];
}
