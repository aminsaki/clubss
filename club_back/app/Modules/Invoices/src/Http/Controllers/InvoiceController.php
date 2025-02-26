<?php

namespace holoo\modules\Invoices\Http\Controllers;

use App\Http\Controllers\Controller;
use holoo\modules\Invoices\services\InoviceServices;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(protected InoviceServices $services)
    {
    }

    public function index()
    {
    }

    public function show($series)
    {
        return $this->services->getUserInformation($series);
    }

    public function store(Request $request)
    { 
        return $this->services->getPrices($request->series);
    }
    public function getSeries(Request $request){

        return $this->services->ApiPrices($request->series);
    }
}
