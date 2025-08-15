<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 8px;">

        <h1 style="color: #10B981; font-size: 24px;">Thank you for your purchase!</h1>

        <p>You have successfully purchased <strong>{{ $order->items->first()->product->title }}</strong>.</p>

        <h2 style="margin-top: 20px;">Order Details:</h2>
        <ul>
            <li><strong>Order ID:</strong> {{ $order->id }}</li>
            <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
            <li><strong>Total Paid:</strong> €{{ number_format($order->total_price, 2) }}</li>
            <li><strong>Purchased On:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</li>
        </ul>

        <p style="margin-top: 20px;">
            <a href="{{ URL::signedRoute('download.file', ['order' => $order->id, 'product' => $order->items->first()->product->slug]) }}"
               style="display: inline-block; background-color: #10B981; color: white; padding: 12px 20px; border-radius: 5px; text-decoration: none;">
               Download Your Product
            </a>
        </p>

        <p style="margin-top: 20px;">
            <a href="{{ route('products.index') }}" style="color: #047857;">Continue Shopping</a>
        </p>
    </div>
</body>
</html>
