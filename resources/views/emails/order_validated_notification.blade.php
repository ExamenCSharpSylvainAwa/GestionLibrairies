<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle commande validée</title>
</head>
<body>
    <h1>Nouvelle commande validée #{{ $order->id }}</h1>
    <p>Bonjour,</p>
    <p>Une nouvelle commande a été validée par le client.</p>
    <p><strong>Commande # :</strong> {{ $order->id }}</p>
    <p><strong>Client :</strong> {{ $order->user->name }}</p>
    <p><strong>Email du client :</strong> {{ $order->user->email }}</p>
    <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Montant total :</strong> {{ number_format($order->total_amount, 2) }} FCFA</p>
    <h2>Détails des articles</h2>
    <ul>
        @foreach ($order->books as $book)
            <li>{{ $book->title }} - Quantité : {{ $book->pivot->quantity }} - Prix : {{ number_format($book->pivot->price, 2) }} FCFA</li>
        @endforeach
    </ul>
    <p>L'équipe Gestion Librairies</p>
</body>
</html>