<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Mes Commandes</title>
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
            --border-color: #e0e0e0;
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
            max-width: 1400px;
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
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
        }
        
        .user-info span {
            color: var(--light);
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
        
        .nav-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
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
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .btn-success {
            background-color: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .btn-warning {
            background-color: var(--warning);
            color: white;
        }
        
        .btn-warning:hover {
            background-color: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
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
        
        .action-buttons {
            display: flex;
            flex-direction: row;
            gap: 8px;
            align-items: center;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
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
            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
            
            .header-right {
                flex-direction: column;
                gap: 10px;
            }
            
            .nav-buttons {
                justify-content: center;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            .action-buttons {
                flex-direction: row;
                gap: 6px;
                justify-content: center;
            }

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
                    <h1>Mes Commandes</h1>
                    <p class="header-subtitle">Suivez vos commandes</p>
                </div>
                <div class="header-right">
                    @if (auth()->check())
                        <div class="user-info">
                            <span>Bonjour, {{ auth()->user()->name }}</span>
                        </div>
                    @endif
                    <div class="nav-buttons">
                        <a href="{{ route('books.index') }}" class="btn btn-primary">
                            <i class="fas fa-book"></i> Retour au catalogue
                        </a>
                    </div>
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

        <section>
            @if ($orders->isEmpty())
                <div class="empty-state">
                    <h3>Aucune commande trouvée</h3>
                    <p>Vous n'avez pas encore passé de commande.</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Commande #</th>
                            <th>Livres</th>
                            <th>Montant Total</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    @foreach ($order->books as $book)
                                        {{ $book->title }} ({{ $book->pivot->quantity }} x {{ number_format($book->pivot->price, 2) }} FCFA)<br>
                                    @endforeach
                                </td>
                                <td>{{ number_format($order->total_amount, 2) }} FCFA</td>
                                <td>
                                   
                                        {{ $order->status->label() }}
                                  
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <!-- Bouton Voir pour tous -->
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-icon" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <!-- Actions pour les gestionnaires -->
                                        @if (auth()->check() && auth()->user()->isGestionnaire())
                                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-icon" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-icon" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <!-- Action pour les clients : Annuler la commande -->
                                        @if (auth()->check() && !auth()->user()->isGestionnaire() && auth()->user()->id === $order->user_id && $order->status === \App\Enums\OrderStatus::PENDING)
                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-icon" title="Annuler">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </section>
    </div>
    <footer>
        <div class="footer-content">
            <p>© {{ date('Y') }} Gestion Librairies. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>