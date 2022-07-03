<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhCInvoiceLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'product_id',
        'description',
        'um_id',
        'tax_id',
        'typeoperation_id',
    ];
}
