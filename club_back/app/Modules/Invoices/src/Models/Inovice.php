<?php

namespace holoo\modules\Invoices\Models;

use Illuminate\Database\Eloquent\Model;

class Inovice extends Model
{
     protected $table = "inovices";
     protected $fillable = [
         'id','softcode','uuid','partyNationalCode' ,'newKits', 'billCode', 'siteId', 'partyName', 'partyFamily', 'partyAddress', 'partyTell', 'partyMobile', 'partyJobId', 'partyType', 'isRemote', 'seprateId', 'partyStateCode', 'serial', 'factor', 'tnc_order_type', 'tnc_uuid', 'response', 'created_at', 'updated_at'
     ];
}
