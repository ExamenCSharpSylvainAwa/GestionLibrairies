<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Catalogue des Livres</title>
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
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
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
        
        .filter-section {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
        }
        
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .filter-group {
            flex: 1 1 200px;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--secondary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .book-card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .book-image {
            height: 300px;
            width: 100%;
            object-fit: cover;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .book-details {
            padding: 20px;
        }
        
        .book-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .book-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }
        
        .book-author {
            color: #7f8c8d;
        }
        
        .book-price {
            font-weight: 700;
            color: var(--secondary);
        }
        
        .book-category {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-bottom: 15px;
        }
        
        .book-description {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .book-stock {
            font-size: 0.9rem;
            margin-bottom: 20px;
            color: #7f8c8d;
        }
        
        .book-stock.low {
            color: var(--danger);
        }
        
        .card-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        
        .admin-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: flex-end;
        }
        
        .btn-sm {
            padding: 8px 16px;
            font-size: 0.85rem;
            width: 100%;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .text-danger {
            color: var(--danger);
            font-size: 0.9rem;
        }

        .orders-section {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 40px;
        }

        .orders-section h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
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

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination a, .pagination span {
            padding: 10px 15px;
            margin: 0 5px;
            border-radius: 5px;
            text-decoration: none;
            color: var(--dark);
            background-color: #fff;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: var(--secondary);
            color: white;
            border-color: var(--secondary);
        }

        .pagination .current {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
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
            
            .filter-group {
                flex: 1 1 100%;
            }
            
            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
            
            .admin-actions {
                align-items: center;
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
                    @if (auth()->check() && auth()->user()->isGestionnaire())
                        <h1>Tableau de Bord - Gestionnaire</h1>
                        <p class="header-subtitle">Gérez le catalogue des livres</p>
                    @else
                        <h1>Catalogue des Livres</h1>
                        <p class="header-subtitle">Découvrez notre collection exceptionnelle</p>
                    @endif
                </div>
                <div class="header-right">
                    @if (auth()->check())
                        <div class="user-info">
                            <span>Bonjour, {{ auth()->user()->name }}</span>
                        </div>
                    @endif
                    <div class="nav-buttons">
                        @if (auth()->check() && auth()->user()->isGestionnaire())
                            <a href="{{ route('books.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Ajouter un livre
                            </a>
                            <a href="{{ route('books.archived') }}" class="btn btn-warning">
                                <i class="fas fa-archive"></i> Voir les livres archivés
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> Toutes les Commandes
                            </a>
                            <a href="{{ route('payments.index') }}" class="btn btn-primary">
                                <i class="fas fa-money-bill"></i> Paiements
                            </a>
                            <a href="{{ route('statistics.index') }}" class="btn btn-primary">
                                <i class="fas fa-chart-bar"></i> Statistiques
                            </a>
                        @elseif (auth()->check() && !auth()->user()->isGestionnaire())
                            <a href="{{ route('orders.my_orders') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> Mes Commandes
                            </a>
                            <a href="#orders-section" class="btn btn-primary">
                                <i class="fas fa-file-invoice"></i> Mes Factures
                            </a>
                        @endif
                        @if (auth()->check())
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-icon" title="Déconnexion">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-icon" title="Connexion">
                                <i class="fas fa-sign-in-alt"></i>
                            </a>
                        @endif
                    </div>
                </div>
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
        @if ($errors->any())
            <div class="alert alert-danger" style="background-color: var(--danger); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <section class="filter-section">
            <form class="filter-form" method="GET" action="{{ route('books.index') }}">
                <div class="filter-group">
                    <input type="text" name="category" class="form-control" placeholder="Catégorie" value="{{ request('category') ?? '' }}">
                </div>
                <div class="filter-group">
                    <input type="text" name="author" class="form-control" placeholder="Auteur" value="{{ request('author') ?? '' }}">
                </div>
                <div class="filter-group">
                    <input type="number" name="price" class="form-control" placeholder="Prix max" value="{{ request('price') ?? '' }}" min="0" step="0.01">
                </div>
                <div class="filter-group">
                    <button type="submit" class="btn btn-primary" style="width:100%">
                        <i class="fas fa-filter"></i> Filtrer
                    </button>
                </div>
                <div class="filter-group">
                    <a href="{{ route('books.index') }}" class="btn btn-danger" style="width:100%">
                        <i class="fas fa-times"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </section>
        
        <section class="books-grid">
            @if ($books->isEmpty())
                <div class="empty-state">
                    <h3>Aucun livre trouvé</h3>
                    <p>Essayez de modifier vos filtres ou ajoutez de nouveaux livres.</p>
                </div>
            @else
                @foreach ($books as $book)
                    <div class="book-card">
                        <img src="{{ $book->image ? url('storage/' . $book->image) : 'https://placehold.co/400x320' }}" alt="{{ $book->title }}" class="book-image">
                        <div class="book-details">
                            <h3 class="book-title">
                                <a href="{{ route('books.show', $book) }}" style="text-decoration: none; color: inherit;">
                                    {{ $book->title }}
                                </a>
                            </h3>
                            <div class="book-info">
                                <span class="book-author">{{ $book->author }}</span>
                                <span class="book-price">{{ number_format($book->price, 2) }} FCFA</span>
                            </div>
                            @if ($book->category)
                                <p class="book-category">Catégorie: {{ $book->category }}</p>
                            @endif
                            @if ($book->description)
                                <p class="book-description">{{ $book->description }}</p>
                            @endif
                            <p class="book-stock">Stock: {{ $book->stock }} disponibles</p>
                            <div class="card-actions">
                                @if (auth()->check() && !auth()->user()->isGestionnaire() && $book->stock > 0)
                                    <a href="{{ route('books.show', $book) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-shopping-cart"></i> Commander
                                    </a>
                                @elseif ($book->stock <= 0)
                                    <p class="text-danger">Rupture de stock</p>
                                @endif
                                @if (auth()->check() && auth()->user()->isGestionnaire())
                                    <div class="admin-actions">
                                        <a href="{{ route('books.edit', $book) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="archive-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmArchive(this)">
                                                <i class="fas fa-archive"></i> Archiver
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </section>

        <!-- Ajouter les liens de pagination -->
        <div class="pagination">
            {{ $books->links() }}
        </div>

        @if (auth()->check() && !auth()->user()->isGestionnaire())
            <section class="orders-section" id="orders-section">
                <h2>Mes Factures</h2>
                @if ($orders->isEmpty())
                    <div class="empty-state">
                        <h3>Aucune commande trouvée</h3>
                        <p>Commencez par passer une commande pour voir vos factures ici.</p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>ID Commande</th>
                                <th>Montant Total</th>
                                <th>Statut</th>
                                <th>Facture</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ number_format($order->total_amount, 2) }} FCFA</td>
                                    <td>
                                     
                                            {{ $order->status->label() }}
                                       
                                    </td>
                                    <td>
                                        @if (in_array($order->status, [\App\Enums\OrderStatus::SHIPPED, \App\Enums\OrderStatus::PAID]))
                                            <a href="{{ route('orders.download_invoice', $order->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-download"></i> Télécharger
                                            </a>
                                        @else
                                            <span class="text-danger">Non disponible</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </section>
        @endif
    </div>

    <footer>
        <div class="footer-content">
            <p>© {{ date('Y') }} Gestion Librairies. Tous droits réservés.</p>
        </div>
    </footer>
  
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stockElements = document.querySelectorAll('.book-stock');
            stockElements.forEach(element => {
                const stockText = element.textContent;
                const stockNumber = parseInt(stockText.match(/\d+/)[0]);
                if (stockNumber <= 3) {
                    element.classList.add('low');
                }
            });
        });

        function confirmArchive(button) {
            if (confirm('Êtes-vous sûr de vouloir archiver ce livre ?')) {
                button.closest('form').submit();
            }
        }
    </script>
</body>
</html>