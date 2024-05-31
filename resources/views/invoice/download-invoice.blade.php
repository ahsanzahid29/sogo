<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header, .invoice-items, .total {
            margin-bottom: 20px;
        }

        .header div, .invoice-items div, .total div {
            margin-bottom: 10px;
        }

        .header input, .invoice-items input, .total input {
            width: 100%;
            padding: 10px; /* Ensure consistent padding */
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px; /* Ensure consistent font size */
        }

        .header input[readonly], .invoice-items input[readonly], .total input[readonly] {
            background-color: #f2f2f2;
        }

        .invoice-items table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-items th, .invoice-items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .invoice-items th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            font-size: 18px;
        }

        .total .grand-total {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <label for="service-center-name">Service Center Contact Name:</label>
            <input type="text" id="service-center-name" value="{{$invoiceDetail->name}}" readonly>
        </div>
        <div>
            <label for="service-center-number">Service Center Contact Number:</label>
            <input type="text" id="service-center-number" value="{{$invoiceDetail->phone ? $invoiceDetail->phone : 'NA'}}" readonly>
        </div>
        <div>
            <label for="service-center-address">Service Center Contact Address:</label>
            <input type="text" id="service-center-address" value="{{$invoiceDetail->shipping_address ? $invoiceDetail->shipping_address : 'NA'}}" readonly>
        </div>
    </div>

    <div class="invoice-items">
        <h2>Invoice Items</h2>
        <table>
            <thead>
            <tr>
                <th>Product Name</th>
                <th>Net Unit Price</th>
                <th>Qty</th>
                <th>Tax (%)</th>
                <th>Discount</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoiceItems as $row)
                <tr>
                    <td>{{$row->sparepart}} </td>
                    <td> {{$row->itemunitprice}}</td>
                    <td>{{$row->itemqty}} </td>
                    <td> {{$row->itemtax}}</td>
                    <td> {{$row->itemdiscount}} </td>
                    <td> {{$row->itemtotal}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="total">
        <div>
            <label for="invoice-discount">Invoice Discount:</label>
            <input type="text" id="invoice-discount" value="{{$invoiceDetail->discount ? $invoiceDetail->discount : '0' }}" readonly>
        </div>
        <div class="grand-total">
            Grand Total: PKR {{$invoiceDetail->total}}
        </div>
    </div>
</div>
</body>
</html>
