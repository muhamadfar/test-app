@extends('layouts.app')

@section('content')
<body>
    <div class="container">
        <div class="menu-grid">
            @foreach ($products as $product)
                <div class="menu-item" onclick="addToOrder('{{ $product->id }}', '{{ $product->name }}', {{ $product->price }})">
                    <img src="path-to-image/{{ $product->image }}" alt="{{ $product->name }}">
                    <div class="title">{{ $product->name }}<br>Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>
            @endforeach
        </div>

        <div class="invoice">
            <div class="invoice-header">
                <h2>Invoice</h2>
                <button onclick="saveOrder()">Save Bill</button>
            </div>
            <div class="invoice-items">
                <ul id="order-list"></ul>
            </div>
            <div class="invoice-total">
                <span id="total-amount">Total: Rp 0</span>
            </div>
            <div class="invoice-buttons">
                <button class="print" onclick="printOrder()">Print Bill</button>
                <button class="charge" onclick="chargeOrder()">Charge</button>
            </div>
        </div>
    </div>
</body>
@endsection

@section('js0')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let order = [];
    let total = 0;

    function addToOrder(id, name, price) {
        let product = order.find(p => p.id === id);
        if (product) {
            product.quantity += 1;
            product.total += price;
        } else {
            order.push({ id, name, price, quantity: 1, total: price });
        }
        updateOrder();
    }

    function updateOrder() {
        let orderList = $('#order-list');
        orderList.empty();
        total = 0;

        order.forEach(product => {
            total += product.total;
            orderList.append(`<li>${product.name} x${product.quantity} - Rp ${product.total}</li>`);
        });

        $('#total-amount').text(`Total: Rp ${total}`);
    }

    function saveOrder() {
        $.ajax({
            url: '/save-order', 
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                order: order,
                total: total
            },
            success: function(response) {
                alert('Order saved!');
                order = [];
                total = 0;
                updateOrder();
            },
            error: function() {
                alert('Failed to save order.');
            }
        });
    }

    function printOrder() {
        window.print();
    }

    function chargeOrder() {
        let payment = parseFloat(prompt(`Total: Rp ${total}. Enter payment amount:`));
        if (isNaN(payment) || payment < total) {
            alert('Insufficient payment amount.');
            return;
        }

        let change = payment - total;
        alert(`Payment: Rp ${payment}\nChange: Rp ${change}`);
        order = [];
        total = 0;
        updateOrder();
    }
</script>
@endsection