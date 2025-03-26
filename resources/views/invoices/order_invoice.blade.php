<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture Commande #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-size: 24px;
            color: #2c3e50;
        }
        .details, .items {
            margin-bottom: 30px;
        }
        .details p, .items p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Facture Commande #{{ $order->id }}</h1>
            <p>Date : {{ $order->created_at->format('d/m/Y') }}</p>
        </div>

        <div class="details">
            <p><strong>Client :</strong> {{ $order->user->name }}</p>
            <p><strong>Email :</strong> {{ $order->user->email }}</p>
        </div>

        <div class="items">
            <table>
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
                            <td>{{ number_format($book->pivot->price, 2) }} FCFA</td>
                            <td>{{ number_format($book->pivot->quantity * $book->pivot->price, 2) }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="total">
            <p>Total : {{ number_format($order->total_amount, 2) }} FCFA</p>
        </div>
    </div>
</body>
</html>