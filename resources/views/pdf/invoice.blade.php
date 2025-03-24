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
        <img src="images/logo1.png" alt="logo" class="logo">
        <p class="inv">JAGATH MOTORS & ENGINEERING</p>
        <p class="sub">Importers and dealers in New used Japanese motor spares body parts<br/>welding, panting & all necessities repairing vehicle repairs & Advertising</p>
        <div class="float-container">
            <div class="float-item">
                <img src="images/loc.png" alt="" class="icon">
                <span class="p1">Rilhena, Pelmadulla</span>
            </div>
            <div class="float-item">
                <img src="images/email.png" alt="" class="icon">
                <span class="p1">jagathmotors499@gmail.com</span>
            </div>
            <div class="float-item">
                <img src="images/call.png" alt="" class="icon">
                <span class="p1">045 2276606 | 077 2224714</span>
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
            <p><strong>Model:</strong> {{ $invoice->vehicle->brand->brand_name }} {{ $invoice->model }}</p>
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
            @if($invoiceItems->where('is_item', true)->isEmpty()) <!-- Check if there are no items -->
                <tr>
                    <td colspan="1" style="text-align: center; font-size: 11px;"></td>
                    <td colspan="1" style="text-align: left; font-size: 11px;">N/A</td>
                    <td colspan="3" style="text-align: center; font-size: 11px;"></td>
                </tr>
            @else
                @foreach($invoiceItems as $index => $item)
                    @if($item->is_item) <!-- Check if it's an item -->
                        <tr>
                            <td style="width:10%; text-align: center; font-size: 11px;">{{ $index + 1 }}</td>
                            <td style="width:40%; text-align: left; font-size: 11px;">
                                {{ $item->item->name ?? 'N/A' }} <!-- Display N/A if item name is not available -->
                                @if($item->warranty_available)
                                    <br>
                                    <span style="font-size: 0.8em; font-weight: bold;">({{ $item->warranty_type }} Warranty)</span>
                                @endif
                                @if(!empty($item->notes))
                                    <br>
                                    <span style="font-size: 0.8em;"><strong>Note:</strong> {{ $item->notes }}</span>
                                @endif
                            </td>
                            <td style="width:20%; text-align: right; font-size: 11px;">{{ number_format($item->price, 2) }}</td>
                            <td style="width:10%; text-align: center; font-size: 11px;">{{ $item->quantity }}</td>
                            <td style="width:20%; text-align: right; font-size: 11px;">{{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
            @endif

            <tr>
                <td colspan="5" style="text-align: left; font-weight: bold; font-size: 12px;">Services</td>
            </tr>
            @if($invoiceItems->where('is_service', true)->isEmpty()) <!-- Check if there are no services -->
                <tr>
                    <td colspan="1" style="text-align: center; font-size: 11px;"></td>
                    <td colspan="1" style="text-align: left; font-size: 11px;">N/A</td>
                    <td colspan="3" style="text-align: center; font-size: 11px;"></td>
                </tr>
            @else
                @foreach($invoiceItems as $index => $item)
                    @if($item->is_service) <!-- Check if it's a service -->
                        <tr>
                            <td style="width:10%; text-align: center; font-size: 11px;">{{ $index + 1 }}</td>
                            <td style="width:40%; text-align: left; font-size: 11px;">
                                {{ $item->service->name ?? 'N/A' }} <!-- Display N/A if service name is not available -->
                                @if($item->warranty_available)
                                    <br>
                                    <span style="font-size: 0.8em; font-weight: bold;">({{ $item->warranty_type }} Warranty)</span>
                                @endif
                                @if(!empty($item->notes))
                                    <br>
                                    <span style="font-size: 0.8em;"><strong>Note:</strong> {{ $item->notes }}</span>
                                @endif
                            </td>
                            <td style="width:20%; text-align: right; font-size: 11px;">{{ number_format($item->price, 2) }}</td>
                            <td style="width:10%; text-align: center; font-size: 11px;"></td>
                            <td style="width:20%; text-align: right; font-size: 11px;">{{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>

    @if($showGrandTotal)
        <p class="total">Grand Total:  Rs.{{ number_format($invoice->amount, 2) }}</p>
        <p class="paid">Paid Amount:  Rs.{{ number_format($totalPaid, 2) }}</p>
        @if($invoice->credit_balance > 0) <!-- Check if credit balance is greater than 0 -->
            <p class="topay">To Pay:  Rs.{{ number_format($invoice->credit_balance, 2) }}</p>
        @endif
    @endif

    <div style="text-align: left; margin-top: 14px; margin-left: 40px; margin-right: 40px; padding: 2px; line-height: 0.5;">
        @if(!empty($invoice->comment)) <!-- Check if notes are present -->
            <p style="font-weight: bold; font-size: 12px;">Comment:</p>
            <p style="font-size: 9px;">{{ $invoice->comment }}</p>
        @endif
    </div>


    <div class="text1">
        <p class="h1"><strong>Jagath Motors & Engineering</strong></p>
        <p class="p1"><strong>Thank you for buisness with us!</strong></p>
    </div>
    <div class="text2">
        <p class="p1"><strong>Term and Conditions :</strong></p>
        <p class="p1">It is mandatory to bring the invoice given to you</p>
        <p class="p1">for any Battery, ABS related services.</p>
        <p class="p1">Physical damages are not covered under warranty.</p>
    </div>
</body>
</html>
