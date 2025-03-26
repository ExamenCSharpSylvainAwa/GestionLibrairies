<!DOCTYPE html>
<html lang="fr">
<head>
    <title>{{ $book->title }}</title>
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

        h1 {
            font-size: 2rem;
            font-weight: 700;
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

        .book-details {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 30px;
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .book-image img {
            max-width: 300px;
            border-radius: 10px;
            object-fit: cover;
        }

        .book-info {
            flex: 1;
        }

        .book-info p {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .book-info strong {
            color: var(--dark);
        }

        .form-group {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-control {
            padding: 8px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            width: 100px;
            font-size: 0.9rem;
        }

        .text-danger {
            color: var(--danger);
            font-size: 0.85rem;
            display: block;
            margin-top: 5px;
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

        /* Style pour le footer (harmonisé avec books/index.blade.php) */
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
            .book-details {
                flex-direction: column;
                align-items: center;
            }

            .book-image img {
                max-width: 100%;
            }

            .form-control {
                width: 80px;
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
                <h1>{{ $book->title }}</h1>
                <a href="{{ route('books.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Retour au catalogue
                </a>
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="book-details">
            <div class="book-image">
                @if ($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}">
                @else
                    <img src="https://via.placeholder.com/300" alt="Image par défaut">
                @endif
            </div>
            <div class="book-info">
                <p><strong>Auteur :</strong> {{ $book->author }}</p>
                <p><strong>Prix :</strong> {{ number_format($book->price, 2) }} FCFA</p>
                <p><strong>Stock :</strong> {{ $book->stock }}</p>
                <p><strong>Description :</strong> {{ $book->description ?? 'Aucune description disponible.' }}</p>

                @if (auth()->check() && !auth()->user()->isGestionnaire() && $book->stock > 0)
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <div class="form-group">
                            <label for="quantity">Quantité :</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" max="{{ $book->stock }}" value="1" required>
                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Confirmer la commande
                        </button>
                    </form>
                @elseif ($book->stock <= 0)
                    <p class="text-danger">Rupture de stock</p>
                @endif
            </div>
        </section>
    </div>

    <!-- Footer (identique à books/index.blade.php) -->
    <footer>
        <div class="footer-content">
            <p>© {{ date('Y') }} Gestion Librairies. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>