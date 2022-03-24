<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfpList extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_rfp',
        'id_account',
        'code_rfp',
        'vendor_name',
        "invoice_number",
        'date_transaction',
        'due_date_transaction',
        'description',
        'amount',
    ];

}
