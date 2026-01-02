<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadFormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_name',
        'field_label',
        'field_type',
        'field_options',
        'is_required',
        'is_default',
        'sort_order',
        'parent_id',
    ];

    protected $casts = [
        'field_options' => 'array',
        'is_required' => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
    ];
}
