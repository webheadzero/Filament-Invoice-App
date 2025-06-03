<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'total_amount',
        'items',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'items' => 'array',
        'total_amount' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($invoice) {
            // Set default dates if not provided
            if (!$invoice->invoice_date) {
                $invoice->invoice_date = now();
            }
            if (!$invoice->due_date) {
                $invoice->due_date = now()->addDays(30);
            }

            // Generate invoice number if not provided
            if (!$invoice->invoice_number) {
                $year = date('Y');
                $lastInvoice = Invoice::whereYear('created_at', $year)->latest()->first();
                $suffix = $lastInvoice ? intval(substr($lastInvoice->invoice_number, -4)) + 1 : 1;
                $invoice->invoice_number = 'INV-' . $year . '-' . str_pad($suffix, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}

