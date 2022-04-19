<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenClose extends Model
{
    use HasFactory;
    protected $table = 'open_close';
    protected $fillable = [
        'id_tourist_attraction',
        'day',
        'open',
        'close'
    ];
}
