<?php

namespace holoo\modules\Invoices\Contracts;
use holoo\modules\Invoices\Models\Invoice;
use holoo\modules\Bases\Http\Contracts\BaseRepository;

class InvoiceRepository extends BaseRepository implements InvoiceInterface
{
    public function model(): mixed
    {
      return Invoice::class;
    }
}
