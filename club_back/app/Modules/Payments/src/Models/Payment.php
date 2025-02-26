<?php

namespace holoo\modules\Payments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id','merchant_id','serial_number','mobile','user_id','card_hash', 'amount', 'ref_id' ,'currency', 'gateway', 'transaction_id', 'reference_number', 'status', 'res_code', 'description', 'paid_at', 'ip_address', 'bank', 'card_number'
    ];

}
