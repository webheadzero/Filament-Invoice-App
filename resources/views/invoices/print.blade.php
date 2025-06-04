<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .company-info {
            flex: 1;
        }
        .invoice-info {
            text-align: right;
        }
        .client-info {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-amount {
            font-size: 1.2em;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
        .bank-info {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .bank-info h3 {
            margin-top: 0;
            color: #333;
        }
        .bank-account {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .bank-account:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <div class="company-info">
            <h2>{{ $settings->company_name ?? 'Your Company Name' }}</h2>
            <p>{!! nl2br(e($settings->company_address ?? '123 Business Street\nCity, State, ZIP')) !!}</p>
        </div>
        <div class="invoice-info">
            <h1>INVOICE</h1>
            <p><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->invoice_date ? $invoice->invoice_date->format('d M Y') : '-' }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}</p>
        </div>
    </div>

    <div class="client-info">
        <h3>Bill To:</h3>
        <p><strong>{{ $invoice->client->company_name ?? '-' }}</strong></p>
        <p>{{ $invoice->client->name ?? '-' }}</p>
        <p>{{ $invoice->client->address ?? '-' }}</p>
        <p>Tax Number: {{ $invoice->client->tax_number ?? '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items ?? [] as $item)
            <tr>
                <td>{{ $item['description'] ?? '-' }}</td>
                <td>{{ $item['quantity'] ?? '0' }}</td>
                <td>{{ isset($item['unit_price']) ? number_format($item['unit_price'], 2) : '0.00' }}</td>
                <td>{{ isset($item['amount']) ? number_format($item['amount'], 2) : '0.00' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p class="total-amount">Total Amount: {{ number_format($invoice->total_amount ?? 0, 2) }}</p>
    </div>

    @if($settings && $settings->bank_accounts)
    <div class="bank-info">
        <h3>Please transfer to:</h3>
        @foreach($settings->bank_accounts as $account)
        <div class="bank-account">
            <p><strong>{{ $account['bank_name'] }}</strong></p>
            <p>Account Number: {{ $account['account_number'] }}</p>
            <p>Account Name: {{ $account['account_name'] }}</p>
        </div>
        @endforeach
    </div>
    @endif

    <div class="footer">
        <p>Thank you for your business!</p>
    </div>
</body>
</html> 