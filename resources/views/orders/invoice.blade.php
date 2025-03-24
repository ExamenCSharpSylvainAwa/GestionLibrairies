<!DOCTYPE html>
<html>
<head>
    <title>Facture</title>
</head>
<body>
    <h1>Facture Commande #{{ $order->id }}</h1>
    <p>Client: {{ $order->user->name }}</p>
    <p>Email: {{ $order->user->email }}</p>
    <table style="border:1">
        <thead>
            <tr>
                <th>Livre</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->pivot->quantity }}</td>
                    <td>{{ $book->pivot->price }} €</td>
                    <td>{{ $book->pivot->quantity * $book->pivot->price }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Total: {{ $order->total_amount }} €</strong></p>
</body>
</html>