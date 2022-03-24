<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfpPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_rfp',
        'id_media',
        'status'
    ];

}
