<!DOCTYPE html>
<html>
<head>
    <title>Print Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: white;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        li:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .value {
            margin-left: 10px;
            color: #000;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Delivery Note</h1>
    <ul>
        <li><span class="label">Dealer Name:</span><span class="value">{{ $deliveryNote->username }}</span></li>
        <li><span class="label">Dealer Phone:</span><span class="value">{{ $deliveryNote->userphone }}</span></li>
        <li><span class="label">Dealer Address:</span><span class="value">{{ $deliveryNote->address }}</span></li>
        <li><span class="label">Product Name:</span><span class="value">{{ $deliveryNote->invertername }}</span></li>
        <li><span class="label">Quantity:</span><span class="value">{{ $deliveryNote->qty }}</span></li>
        <li><span class="label">Date:</span><span class="value">{{ date('d M, Y', strtotime($deliveryNote->createdat)) }}</span></li>
    </ul>
</div>
</body>
</html>
