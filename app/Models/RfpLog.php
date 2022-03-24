<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfpLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_rfp',
        'title',
        'message',
        'status',
    ];

}
