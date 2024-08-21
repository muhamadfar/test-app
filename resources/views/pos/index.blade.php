@extends('layouts.app')

@section('content')
<body>
    <div class="container">
        <div class="menu-grid">
            @foreach ($products as $product)
                <div class="menu-item" onclick="addToOrder('{{ $product->name }}', {{ $product->price }})">
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
        function addToOrder(productId) {
            $.post('/add-to-order', { product_id: productId, _token: '{{ csrf_token() }}' }, function(data) {
                updateOrderList(data.order);
                updateTotal(data.total);
            });
        }
    
        function saveOrder() {
            $.post('/save-order', { _token: '{{ csrf_token() }}' }, function(data) {
                alert(data.message);
            });
        }
    
        function chargeOrder() {
            let payment = prompt(`Total: Rp ${total}. Enter payment amount:`);
            $.post('/charge-order', { total: total, payment: payment, _token: '{{ csrf_token() }}' }, function(data) {
                alert(`Payment: Rp ${data.payment}\nChange: Rp ${data.change}`);
                if (data.change >= 0) {
                    location.reload();
                }
            });
        }
    
        function updateOrderList(order) {
            let orderList = $('#order-list');
            orderList.empty();
            order.forEach(product => {
                orderList.append(`<li>${product.name} x${product.quantity} - Rp ${product.total_price}</li>`);
            });
        }
    
        function updateTotal(total) {
            $('#total-amount').text(`Total: Rp ${total}`);
        }
    </script>
    @endsection
@section('js1')
<script>
    let order = [];
    let total = 0;

    function addToOrder(name, price) {
        let product = order.find(p => p.name === name);
        if (product) {
            product.quantity += 1;
            product.total += price;
        } else {
            order.push({ name, price, quantity: 1, total: price });
        }
        updateOrder();
    }

    function updateOrder() {
        let orderList = document.getElementById('order-list');
        orderList.innerHTML = '';
        total = 0;

        order.forEach(product => {
            total += product.total;
            orderList.innerHTML += `<li>${product.name} x${product.quantity} - Rp ${product.total}</li>`;
        });

        document.getElementById('total-amount').innerText = `Total: Rp ${total}`;
    }

    function saveOrder() {
        alert('Order saved!');
    }

    function printOrder() {
        window.print();
    }

    function chargeOrder() {
        let payment = prompt(`Total: Rp ${total}. Enter payment amount:`);
        let change = payment - total;

        alert(`Payment: Rp ${payment}\nChange: Rp ${change}`);
    }
</script>
@endsection