<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Détails de la Commande</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Styles similaires à ceux de my_orders.blade.php */
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #2ecc71;
            --warning: #f39c12;
            --danger: #e74c3c;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: var(--primary);
            color: white;
            padding: 20px 0;
            margin-bottom: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(44, 62, 80, 0.1);
            background-image: linear-gradient(135deg, #2c3e50 0%, #4a6785 100%);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-left {
            flex: 1;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .header-subtitle {
            font-size: 1.1rem;
            opacity: 0.8;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 0.9rem;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background-color: var(--secondary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }

        .btn-icon {
            padding: 10px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .order-details {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
        }

        .order-details h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .order-details p {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: var(--primary);
            color: white;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .alert-success {
            background-color: var(--success);
            color: white;
        }

        .alert-danger {
            background-color: var(--danger);
            color: white;
        }

        footer {
            background-color: var(--primary);
            color: white;
            padding: 20px 0;
            margin-top: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(44, 62, 80, 0.1);
            background-image: linear-gradient(135deg, #2c3e50 0%, #4a6785 100%);
            text-align: center;
        }

        .footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            padding: 0 40px;
        }

        .footer-content p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                gap: 10px;
                padding: 0 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="header-content">
                <div class="header-left">
                    <h1>Détails de la Commande #{{ $order->id }}</h1>
                    <p class="header-subtitle">Informations sur la commande</p>
                </div>
                <div class="header-right">
                    <a href="{{ auth()->user()->isGestionnaire() ? route('orders.index') : route('orders.my_orders') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    @if (auth()->check())
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-icon" title="Déconnexion">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <section class="order-details">
            <h2>Informations de la Commande</h2>
            <p><strong>Utilisateur :</strong> {{ $order->user->name }}</p>
            <p><strong>Statut :</strong> 
              
                    {{ $order->status->label() }}
               
            </p>
            <p><strong>Montant Total :</strong> {{ number_format($order->total_amount, 2) }} FCFA</p>
            <p><strong>Date de Création :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

            <h2>Livres Commandés</h2>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
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
                            <td>{{ number_format($book->pivot->price * $book->pivot->quantity, 2) }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>

    <footer>
        <div class="footer-content">
            <p>© {{ date('Y') }} Gestion Librairies. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>