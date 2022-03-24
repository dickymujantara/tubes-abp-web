<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfp extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_project',
        'headline',
        'no_rfp',
        'type',
        'description',
        'total_amount',
        'status',
    ];

}
