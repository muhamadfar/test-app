<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: column;
            width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .menu-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            cursor: pointer;
        }

        .menu-item img {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }

        .menu-item .title {
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        .invoice {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .invoice-header h2 {
            margin: 0;
        }

        .invoice-header button {
            padding: 8px 16px;
            background-color: #ddd;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .invoice-items {
            margin-bottom: 10px;
        }

        .invoice-items ul {
            list-style-type: none;
            padding: 0;
        }

        .invoice-items li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
        }

        .invoice-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
        }

        .invoice-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .invoice-buttons button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .invoice-buttons button.save {
            background-color: #4CAF50;
            color: white;
        }

        .invoice-buttons button.print {
            background-color: #ddd;
            color: black;
        }

        .invoice-buttons button.charge {
            background-color: #007bff;
            color: white;
            width: 100%;
        }
        </style>
    <div class="container">
        <div class="menu-grid">
            @foreach ($products as $product)
                <div class="menu-item" onclick="addToOrder('{{ $product->id }}')">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>
            @endforeach
        </div>

        <div class="invoice">
            <div class="invoice-header">New Customer</div>
            <ul id="invoice-items"></ul>
            <div id="total-amount" class="invoice-total">Total: Rp 0</div>
            <div class="invoice-buttons">
                <button class="save" onclick="saveOrder()">Save Bill</button>
                <button class="print" onclick="printOrder()">Print Bill</button>
                <button class="charge" onclick="chargeOrder()">Charge</button>
            </div>
        </div>
    </div>

    @yield('js0')
    @yield('js1')
</body>
</html>