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
            padding: 8px;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 1rem;
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        /* Styles pour le tableau */
        .table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        /* Définir des largeurs spécifiques pour les colonnes */
        th:nth-child(1), td:nth-child(1) { /* Commande # */
            width: 8%;
        }

        th:nth-child(2), td:nth-child(2) { /* Livres */
            width: 25%;
        }

        th:nth-child(3), td:nth-child(3) { /* Montant Total */
            width: 12%;
        }

        th:nth-child(4), td:nth-child(4) { /* Statut */
            width: 10%;
        }

        th:nth-child(5), td:nth-child(5) { /* Date */
            width: 15%;
        }

        th:nth-child(6), td:nth-child(6) { /* Paiement */
            width: 20%;
        }

        th:nth-child(7), td:nth-child(7) { /* Actions */
            width: 20%;
        }

        tr:hover {
            background-color: #f9f9f9;
            transition: background-color 0.3s ease;
        }

        /* Styles pour les statuts */
        .status-pending {
            color: var(--warning);
            font-weight: 600;
        }

        .status-processing {
            color: var(--secondary);
            font-weight: 600;
        }

        .status-shipped {
            color: var(--success);
            font-weight: 600;
        }

        .status-paid {
            color: var(--accent);
            font-weight: 600;
        }

        .status-cancelled {
            color: var(--danger);
            font-weight: 600;
        }

        /* Style pour la colonne Paiement */
        .payment-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 0.85rem;
        }

        .payment-info span {
            display: inline-block;
        }

        .payment-info .amount {
            font-weight: 600;
            color: var(--success);
        }

        .payment-info .date {
            color: #7f8c8d;
        }

        .payment-info .method {
            color: #34495e;
        }

        .not-paid {
            color: var(--danger);
            font-weight: 600;
        }

        /* Style pour la colonne Actions */
        .actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }

        .action-buttons {
            display: flex;
            flex-direction: row; /* Alignement horizontal pour Modifier et Supprimer */
            gap: 6px;
        }

        .action-forms {
            display: flex;
            flex-direction: column; /* Alignement vertical pour les formulaires */
            gap: 6px;
            width: 100%; /* Prendre toute la largeur disponible */
            max-width: 300px; /* Limiter la largeur des formulaires */
        }

        /* Style pour le formulaire de mise à jour du statut */
        .status-form {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Pousse le bouton à droite */
            gap: 6px;
            background-color: #f9f9f9;
            padding: 6px 8px;
            border-radius: 5px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .status-form:hover {
            background-color: #f1f1f1;
            border-color: var(--secondary);
        }

        .status-form select {
            padding: 5px 8px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 0.8rem;
            background-color: #fff;
            color: var(--dark);
            cursor: pointer;
            transition: border-color 0.3s ease;
            width: 150px; /* Ajuster la largeur pour laisser de l'espace au bouton */
        }

        .status-form select:focus {
            outline: none;
            border-color: var(--secondary);
        }

        .status-form input[type="number"],
        .status-form input[type="date"] {
            padding: 5px 8px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 0.8rem;
            background-color: #fff;
            color: var(--dark);
            transition: border-color 0.3s ease;
            width: 100px;
        }

        .status-form input[type="number"]:focus,
        .status-form input[type="date"]:focus {
            outline: none;
            border-color: var(--secondary);
        }

        /* Style pour les alertes */
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

        /* Responsivité */
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

            /* Ajuster les colonnes pour les petits écrans */
            th, td {
                font-size: 0.8rem;
                padding: 8px;
            }

            th:nth-child(1), td:nth-child(1) { /* Commande # */
                width: 10%;
            }

            th:nth-child(2), td:nth-child(2) { /* Livres */
                width: 20%;
            }

            th:nth-child(3), td:nth-child(3) { /* Montant Total */
                width: 15%;
            }

            th:nth-child(4), td:nth-child(4) { /* Statut */
                width: 15%;
            }

            th:nth-child(5), td:nth-child(5) { /* Date */
                display: none; /* Masquer la colonne Date sur mobile */
            }

            th:nth-child(6), td:nth-child(6) { /* Paiement */
                width: 20%;
            }

            th:nth-child(7), td:nth-child(7) { /* Actions */
                width: 20%;
            }

            .action-buttons {
                gap: 4px;
            }
            .footer-content {
                flex-direction: column;
                gap: 10px;
            }
            .action-forms {
                gap: 4px;
                max-width: 100%;
            }

            .status-form {
                gap: 4px;
                padding: 4px 6px;
            }

            .status-form select,
            .status-form input[type="number"],
            .status-form input[type="date"] {
                width: 90px;
                font-size: 0.75rem;
                padding: 4px 6px;
            }

            .btn-icon {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }

            .payment-info {
                font-size: 0.75rem;
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
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Aucune commande trouvée</h3>
                    <p>Vous n'avez pas encore passé de commande.</p>
                    <a href="{{ route('books.index') }}" class="btn btn-primary">
                        <i class="fas fa-book"></i> Passer une commande
                    </a>
                </div>
            @else
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Commande #</th>
                                <th>Livres</th>
                                <th>Montant Total</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Paiement</th>
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
                                    <td class="status-{{ strtolower($order->status->name) }}">
                                        {{ $order->status->value }}
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if ($order->payment)
                                            <div class="payment-info">
                                                <span class="amount">{{ number_format($order->payment->amount, 2) }} FCFA</span>
                                                <span class="date">
                                                    Payé le {{ $order->payment->payment_date instanceof \Carbon\Carbon ? $order->payment->payment_date->format('d/m/Y') : $order->payment->payment_date }}
                                                </span>
                                                <span class="method">Méthode : {{ $order->payment->payment_method }}</span>
                                            </div>
                                        @else
                                            <span class="not-paid">Non payé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="actions">
                                            @if (auth()->check())
                                                <!-- Conteneur pour les boutons Modifier et Supprimer (horizontal) -->
                                                @if (auth()->user()->isGestionnaire() || (auth()->user()->id === $order->user_id && $order->status->value === 'En attente'))
                                                    <div class="action-buttons">
                                                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-icon" title="Modifier">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-icon" title="Supprimer">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                                <!-- Conteneur pour les formulaires (vertical) -->
                                                @if (auth()->user()->isGestionnaire())
                                                    <div class="action-forms">
                                                        <!-- Formulaire pour mettre à jour le statut -->
                                                        <form action="{{ route('orders.update', $order) }}" method="POST" class="status-form">
                                                            @csrf
                                                            @method('PUT')
                                                            <select name="status">
                                                                @foreach (\App\Enums\OrderStatus::cases() as $status)
                                                                    @if ($status->value !== \App\Enums\OrderStatus::PAID->value && $status->value !== \App\Enums\OrderStatus::VALIDATED->value)
                                                                        <option value="{{ $status->value }}" {{ $order->status->value == $status->value ? 'selected' : '' }}>
                                                                            {{ $status->value }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <button type="submit" class="btn btn-primary btn-icon" title="Mettre à jour le statut">
                                                                <i class="fas fa-save"></i>
                                                            </button>
                                                        </form>
                                                        <!-- Formulaire pour marquer une commande comme payée -->
                                                        @if ($order->status->value === 'Expédiée' && !$order->payment)
                                                            <form action="{{ route('orders.pay', $order) }}" method="POST" class="status-form">
                                                                @csrf
                                                                <input type="number" name="amount" placeholder="Montant" required step="0.01" min="0">
                                                                <input type="date" name="payment_date" required>
                                                                <button type="submit" class="btn btn-success btn-icon" title="Marquer comme payée">
                                                                    <i class="fas fa-money-bill"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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