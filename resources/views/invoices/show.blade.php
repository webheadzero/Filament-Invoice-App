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
        .actions {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 0 10px;
        }
        .btn-print {
            background-color: #2196F3;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <div class="company-info">
            <h2>Your Company Name</h2>
            <p>123 Business Street</p>
            <p>City, State, ZIP</p>
            <p>Phone: (123) 456-7890</p>
        </div>
        <div class="invoice-info">
            <h1>INVOICE</h1>
            <p><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->invoice_date->format('d M Y') }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date->format('d M Y') }}</p>
        </div>
    </div>

    <div class="client-info">
        <h3>Bill To:</h3>
        <p><strong>{{ $invoice->client->company_name }}</strong></p>
        <p>{{ $invoice->client->name }}</p>
        <p>{{ $invoice->client->address }}</p>
        <p>Tax Number: {{ $invoice->client->tax_number }}</p>
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
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item['description'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['unit_price'], 2) }}</td>
                <td>{{ number_format($item['quantity'] * $item['unit_price'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p class="total-amount">Total Amount: {{ number_format($invoice->total_amount, 2) }}</p>
    </div>

    <div class="actions">
        <a href="{{ route('invoices.print', ['invoice' => $invoice]) }}" class="btn btn-print" target="_blank">Print Invoice</a>
        <a href="/" class="btn">Back to Dashboard</a>
    </div>
</body>
</html> 