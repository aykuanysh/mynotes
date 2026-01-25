<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $filable = [
        'table',
        'description',
        'date'
    ];
}
