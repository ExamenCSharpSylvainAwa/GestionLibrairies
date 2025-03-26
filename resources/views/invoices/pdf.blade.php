<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-size: 24px;
            color: #2c3e50;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            margin: 5px 0;
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
        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Facture #{{ $order->id }}</h1>
            <p>Date : {{ now()->format('d/m/Y') }}</p>
        </div>

        <div class="details">
            <p><strong>Client :</strong> {{ $order->user->name }}</p>
            <p><strong>Email :</strong> {{ $order->user->email }}</p>
            <p><strong>Statut de la commande :</strong> {{ $order->status->label() }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->book->title }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->book->price, 2) }} FCFA</td>
                        <td>{{ number_format($item->quantity * $item->book->price, 2) }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Montant Total : {{ number_format($order->total_amount, 2) }} FCFA</p>

        <p style="text-align: center; margin-top: 40px;">
            Merci de votre achat !  
            Gestion Librairies
        </p>
    </div>
</body>
</html>