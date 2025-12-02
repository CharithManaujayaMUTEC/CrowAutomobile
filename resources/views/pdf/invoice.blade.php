<!-- resources/views/invoice.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->id }}</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <div class="header">
        <img src="images/logo.jpg" alt="logo" class="logo">
        <p class="inv">AAA Auto Care</p>
        <div class="float-container">
            <div>
                <img src="images/loc.png" alt="" class="icon">
                <span class="p1">Ketethanna, Kahawatta</span>
            </div>
            <div>
                <img src="images/email.png" alt="" class="icon">
                <span class="p1">aaa.autocare123@gmail.com</span>
            </div>
            <div>
                <img src="images/call.png" alt="" class="icon">
                <span class="p1">0713634041</span>
            </div>
            <div style="clear: both;"></div> <!-- Clear floats -->
        </div>
    </div>
    <div class="container">
        <div class="right">
            @if($invoice->is_invoice)
                <p><strong>Invoice No:</strong> {{ $invoice->id }}</p>
            @else
            <p><strong>Quatation No:</strong> {{ $invoice->id }}</p>
            @endif
            <p>{{ $invoice->created_at->format('F j, Y') }}</p>
        </div>
        <div class="left">
            <p><strong>Invoice to:</strong></p>
            <p><strong>Customer Name:</strong> <strong>{{ $invoice->customer->title }}{{ $invoice->customer->name }}</strong></p>
            <p><strong>Vehicle Number:</strong> {{ $invoice->vehicle->number }}</p>
            <p><strong>Model:</strong> {{ $invoice->vehicle->brand }} {{ $invoice->model }}</p>
            <p><strong>Mileage:</strong> {{ $invoice->mileage }} {{ $invoice->is_km ? 'KM' : 'Miles' }}</p>
        </div>

    </div>
    <table>
        <thead>
            <tr>
                <th style="width:10%; text-align: center; font-size: 11px;">No</th>
                <th style="width:40%; text-align: left; font-size: 11px;">Description</th>
                <th style="width:20%; text-align: right; font-size: 11px;">Unit Price(LKR)</th>
                <th style="width:10%; text-align: center; font-size: 11px;">Qty</th>
                <th style="width:20%; text-align: right; font-size: 11px;">Total(LKR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" style="text-align: left; font-weight: bold; font-size: 12px;">Parts</td>
            </tr>
            @foreach($invoiceItems as $index => $item)
                @if($item->is_item) <!-- Check if it's an item -->
                    <tr>
                        <td style="width:10%; text-align: center; font-size: 11px;">{{ $index + 1 }}</td>
                        <td style="width:40%; text-align: left; font-size: 11px;">
                            {{ $item->item->name ?? 'N/A' }}
                            @if($item->warranty_available)
                                <br>
                                <span style="font-size: 0.8em; font-weight: bold;">({{ $item->warranty_type }} Warranty)</span>
                            @endif
                        </td>
                        <td style="width:20%; text-align: right; font-size: 11px;">{{ number_format($item->price, 2) }}</td>
                        <td style="width:10%; text-align: center; font-size: 11px;">
                            {{ $item->quantity }}
                        </td>
                        <td style="width:20%; text-align: right; font-size: 11px;">{{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @endif
            @endforeach

            @php
                $hasServices = $invoiceItems->contains(fn($item) => $item->is_service);
            @endphp

            @if($hasServices)
            <tr>
                <td colspan="5" style="text-align: left; font-weight: bold; font-size: 12px;">Services</td>
            </tr>
            @endif
            @foreach($invoiceItems as $index => $item)
                @if($item->is_service) <!-- Check if it's a service -->
                    <tr>
                        <td style="width:10%; text-align: center; font-size: 11px;">{{ $index + 1 }}</td>
                        <td style="width:40%; text-align: left; font-size: 11px;">
                            {{ $item->service->name ?? 'N/A' }}

                            @if($item->warranty_available)
                                <br>
                                <span style="font-size: 0.8em; font-weight: bold;">({{ $item->warranty_type }} Warranty)</span>
                            @endif
                        </td>
                        <td style="width:20%; text-align: right; font-size: 11px;">{{ number_format($item->price, 2) }}</td>
                        <td style="width:10%; text-align: center; font-size: 11px;">

                        </td>
                        <td style="width:20%; text-align: right; font-size: 11px;">{{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>




    @if($showGrandTotal)
        <p class="total">Grand Total:  Rs.{{ number_format($invoice->amount, 2) }}</p>
        <p class="total">Paid Amount:  Rs.{{ number_format($totalPaid, 2) }}</p>
        <p class="total">Balance:  Rs.{{ number_format($invoice->credit_balance, 2) }}</p>
    @endif

    <div style="text-align: left; margin-top: 14px; margin-left: 40px; margin-right: 40px; padding: 5px; line-height: 0.5; border: 1px solid #000;">
    <p style="font-weight: bold;">Special Notes:</p>
    <p>{{ $item->notes ?? 'N/A' }}</p>
</div>
</body>
</html>
