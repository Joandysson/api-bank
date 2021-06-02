<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    protected $fillable = [
        'client_id', 'balance'
    ];

    protected $hidden = [
        'password',
    ];
}
