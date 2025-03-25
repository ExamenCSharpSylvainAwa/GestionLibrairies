<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Facture</h1>
            <p>Commande #{{ $order->id }}</p>
            <p>Date: {{ now()->format('d/m/Y') }}</p>
        </div>
        
        <div class="invoice-details">
            <p><strong>Client :</strong> {{ $order->user->name }}</p>
            <p><strong>Email :</strong> {{ $order->user->email }}</p>
        </div>
        
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
                <tr>
                    <td>{{ $order->book->title }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ number_format($order->book->price, 2) }} FCFA</td>
                    <td>{{ number_format($order->total_price, 2) }} FCFA</td>
                </tr>
            </tbody>
        </table>
        
        <p><strong>Total :</strong> {{ number_format($order->total_price, 2) }} FCFA</p>
    </div>
</body>
</html>