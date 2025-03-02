<?php

namespace holoo\modules\Invoices\Contracts;
use holoo\modules\Bases\Http\Contracts\BaseRepository;
use holoo\modules\Invoices\Models\Inovice;

class InvoiceRepository extends BaseRepository implements InvoiceInterface
{
    public function model(): mixed
    {
      return Inovice::class;
    }
}
