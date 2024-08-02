<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Spare Part Inventory</title>
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
        textarea {
            width: 100%; /* Use full width of the container */
            height: 100px; /* Set a specific height */
            padding: 10px; /* Add padding for better appearance */
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Ensure padding doesn't affect overall width/height */
            font-size: 16px; /* Consistent font size */
            resize: none; /* Disable resizing if needed */
        }
    </style>
    <script>
        function printPage() {
            window.print();
        }

        window.onload = function() {
            printPage();
        }
    </script>
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <label for="service-center-name">Priciple Invoice No:</label>
            <input type="text" id="service-center-name" value="{{ $detail->principle_invoice_no }}" readonly>
        </div>
        <div>
            <label for="service-center-number">Priciple Invoice Date:</label>
            <input type="text" id="service-center-number" value="{{ date('d/m/Y',strtotime($detail->principle_invoice_date)) }}" readonly>
        </div>
        <div>
            <label for="service-center-address">GRN:</label>
            <input type="text" id="service-center-address" value="{{ $detail->grn }}" readonly>
        </div>
        <div>
            <label for="service-center-address">Receiving Date:</label>
            <input type="text" id="service-center-address" value="{{ date('d/m/Y',strtotime($detail->receiving_invoice_date)) }}" readonly>
        </div>
    </div>
    <div class="invoice-items">
        <h2>Invoice Items</h2>
        <table>
            <thead>
            <tr>
                <th>Factory Code</th>
                <th>Description</th>
                <th>Quantity Received</th>
                <th>Purchase Price</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sp_inventory as $row)
                <tr>
                    <td> {{$row->factory_code}} </td>
                    <td> {{$row->spname}}</td>
                    <td> {{$row->qty}} </td>
                    <td> {{$row->pprice}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="header">
        <div>
            <label for="remarks">Remarks:</label>
            <textarea id="remarks" readonly>{{ $detail->remarks }}</textarea>
        </div>
    </div>
</div>
</body>
</html>
