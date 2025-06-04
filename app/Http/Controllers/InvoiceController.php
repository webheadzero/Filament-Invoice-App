<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $settings = Setting::first();
        return view('invoices.print', compact('invoice', 'settings'));
    }

    public function download(Invoice $invoice)
    {
        $settings = Setting::first();
        $pdf = PDF::loadView('invoices.print', compact('invoice', 'settings'));
        
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
} 