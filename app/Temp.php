<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    protected $fillable = [
        'phone_number', 'verify_code'
    ];
}
