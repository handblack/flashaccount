<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_id',
        'doctype_id',
        'dateinvoiced',
        'dateacct',
        'period',
        'serial',
        'documentno',
    ];
}
