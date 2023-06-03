<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class InvoiceController extends BaseController
{
    public function index()
    {
        
    }

    public function create()
    {
        return view('invoice/create_invoice');
    }
}
