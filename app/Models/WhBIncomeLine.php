<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBIncomeLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'payment_id',
        'description',
        'amount'
    ];

    public function invoice(){
        return $this->hasOne(WhCInvoice::class,'id','invoice_id');
    }

}
