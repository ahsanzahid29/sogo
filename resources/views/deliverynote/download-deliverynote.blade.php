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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #eee;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
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
        <li><span class="label">Head Office DO Number:</span><span class="value">{{ $deliveryNote->do_no }}</span></li>
    </ul>
    <table>
        <thead>
        <tr>
            <th>Model No</th>
            <th>Serial No</th>
            <th>Delivery Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($deliveryItems as $row)
            <tr>
                <td>{{ $row->modalNo }}</td>
                <td>{{ $row->sno }}</td>
                <td>{{ date('d/m/Y',strtotime($row->delivery_date)) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
