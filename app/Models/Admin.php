<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'active'
    ];

    protected $hidden = [
        'password',
    ];

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }
}

