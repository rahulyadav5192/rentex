<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceGenerationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'generation_date',
        'invoices_created',
        'invoices_failed',
        'status',
        'error_log',
        'details',
    ];

    protected $casts = [
        'generation_date' => 'date',
        'details' => 'array',
    ];
}
