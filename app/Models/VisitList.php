<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitList extends Model
{
    use HasFactory;
    protected $table = 'visit_list';
    protected $fillable = [
        // 'id_user',
        // 'id_tourist_attraction',
        'visit_date',
    ];
}
