<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Order</title>
</head>
<body onload="window.print()">
    <h3>Order Details</h3>
    <ul>
        @foreach($order as $item)
            <li>{{ $item['name'] }} x{{ $item['quantity'] }} - Rp {{ number_format($item['total_price'], 0, ',', '.') }}</li>
        @endforeach
    </ul>
    <h4>Total: Rp {{ number_format(array_sum(array_column($order, 'total_price')), 0, ',', '.') }}</h4>
</body>
</html>