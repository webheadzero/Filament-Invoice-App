<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', [
            'invoice' => $invoice->load('client')
        ]);
    }

    public function print(Invoice $invoice)
    {
        $invoice->load('client');
        return view('invoices.print', compact('invoice'));
    }
} 