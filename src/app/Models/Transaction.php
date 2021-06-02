<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'account_id', 'value'
    ];

    protected $hidden = [
        'password',
    ];
}
