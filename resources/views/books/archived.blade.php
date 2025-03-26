<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Livres Archivés</title>
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: var(--primary);
            color: white;
            padding: 30px 0;
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
        
        .btn-primary {
            background-color: var(--secondary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        .btn-success {
            background-color: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background-color: #27ae60;
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
        
        .card-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            gap: 10px;
        }
        
        .btn-sm {
            padding: 8px 16px;
            font-size: 0.85rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* Style pour le footer (harmonisé avec books/index.blade.php) */
        footer {
            background-color: var(--primary);
            color: white;
            padding: 20px 0;
            margin-top: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(44, 62, 80, 0.1); /* Même box-shadow que le header */
            background-image: linear-gradient(135deg, #2c3e50 0%, #4a6785 100%); /* Même dégradé que le header */
            text-align: center;
        }

        .footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            padding: 0 40px; /* Même padding que .header-content */
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
            
            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }

            .footer-content {
                flex-direction: column;
                gap: 10px;
                padding: 0 20px; /* Ajustement pour mobile */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="header-content">
                <div>
                    <h1>Livres Archivés</h1>
                    <p class="header-subtitle">Gérez les livres archivés</p>
                </div>
                <div class="admin-button">
                    <a href="{{ route('books.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Retour au catalogue
                    </a>
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
        
        <section class="books-grid">
            @if ($books->isEmpty())
                <div class="empty-state">
                    <h3>Aucun livre archivé</h3>
                    <p>Vous n'avez aucun livre archivé pour le moment.</p>
                </div>
            @else
                @foreach ($books as $book)
                    <div class="book-card">
                        <img src="{{ $book->image ? url('storage/' . $book->image) : 'https://placehold.co/400x320' }}" alt="{{ $book->title }}" class="book-image">
                        <div class="book-details">
                            <h3 class="book-title">{{ $book->title }}</h3>
                            <div class="book-info">
                                <span class="book-author">{{ $book->author }}</span>
                                <span class="book-price">{{ number_format($book->price, 2) }} FCFA</span>
                            </div>
                            <div class="card-actions">
                                <form action="{{ route('books.restore', $book->id) }}" method="POST" class="restore-form">
                                    @csrf
                                    <button type="button" class="btn btn-success btn-sm" onclick="confirmRestore(this)">
                                        <i class="fas fa-undo"></i> Restaurer
                                    </button>
                                </form>
                                <form action="{{ route('books.forceDelete', $book->id) }}" method="POST" class="force-delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmForceDelete(this)">
                                        <i class="fas fa-trash"></i> Supprimer définitivement
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </section>
    </div>

    <!-- Footer (identique à books/index.blade.php) -->
    <footer>
        <div class="footer-content">
            <p>© {{ date('Y') }} Gestion Librairies. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Fonction de confirmation pour la restauration
        function confirmRestore(button) {
            if (confirm('Êtes-vous sûr de vouloir restaurer ce livre ? Il sera de nouveau visible dans le catalogue.')) {
                button.closest('form').submit();
            }
        }

        // Fonction de confirmation pour la suppression définitive
        function confirmForceDelete(button) {
            if (confirm('Êtes-vous sûr de vouloir supprimer définitivement ce livre ? Cette action est irréversible.')) {
                button.closest('form').submit();
            }
        }
    </script>
</body>
</html>