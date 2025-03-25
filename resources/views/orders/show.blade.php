<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Détails de la Commande</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
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
        }
        
        h1 {
            font-size: 2rem;
            font-weight: 700;
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
        
        .btn-primary {
            background-color: var(--secondary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        .order-details {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }
        .order-actions {
            margin-top: 20px;
        }

        .order-actions select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-right: 10px;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.85rem;
        }
        .order-info {
            margin-bottom: 20px;
        }
        
        .order-info p {
            font-size: 1rem;
            margin-bottom: 10px;
        }
        
        .order-info strong {
            color: var(--dark);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="header-content">
                <h1>Détails de la Commande #{{ $order->id }}</h1>
                <a href="{{ route('orders.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </header>
        
        @if (session('success'))
            <div class="alert alert-success" style="background-color: var(--success); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" style="background-color: var(--danger); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif
        
        <section class="order-details">
            <div class="order-info">
                <p><strong>Client :</strong> {{ $order->user->name }}</p>
                <p><strong>Livre :</strong> {{ $order->book->title }}</p>
                <p><strong>Quantité :</strong> {{ $order->quantity }}</p>
                <p><strong>Prix Total :</strong> {{ number_format($order->total_price, 2) }} FCFA</p>
                <p><strong>Statut :</strong> {{ $order->status }}</p>
                <p><strong>Date de commande :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                @if ($order->payment_date)
                    <p><strong>Date de paiement :</strong> {{ $order->payment_date->format('d/m/Y H:i') }}</p>
                @endif
                @if ($order->payment_amount)
                    <p><strong>Montant payé :</strong> {{ number_format($order->payment_amount, 2) }} FCFA</p>
                @endif
            </div>
            <div class="order-actions">
                <form action="{{ route('orders.update_status', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="status"><strong>Modifier le statut :</strong></label>
                    <select name="status" id="status">
                        <option value="En attente" {{ $order->status === 'En attente' ? 'selected' : '' }}>En attente</option>
                        <option value="En préparation" {{ $order->status === 'En préparation' ? 'selected' : '' }}>En préparation</option>
                        <option value="Expédiée" {{ $order->status === 'Expédiée' ? 'selected' : '' }}>Expédiée</option>
                        <option value="Payée" {{ $order->status === 'Payée' ? 'selected' : '' }}>Payée</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>