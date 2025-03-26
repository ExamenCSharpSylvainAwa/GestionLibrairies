<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Passer une Commande</title>
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
        }

        .btn-danger {
            background-color: #e74c3c;
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

        .form-section {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
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
            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .header-right {
                flex-direction: column;
                gap: 10px;
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
                    <h1>Passer une Commande</h1>
                    <p class="header-subtitle">Sélectionnez les livres à commander</p>
                </div>
                <div class="header-right">
                    <a href="{{ route('orders.my_orders') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-icon" title="Déconnexion">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="form-section">
            <form action="{{ route('orders.store') }}" method="POST" id="order-form">
                @csrf
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Quantité</th>
                            <th>Sélectionner</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ number_format($book->price, 2) }} FCFA</td>
                                <td>{{ $book->stock }}</td>
                                <td>
                                    <input type="number" name="books[{{ $book->id }}][quantity]" class="form-control book-quantity" min="1" max="{{ $book->stock }}" value="1" {{ $book->stock > 0 ? '' : 'disabled' }}>
                                    <input type="hidden" name="books[{{ $book->id }}][id]" class="book-id" value="{{ $book->id }}" {{ $book->stock > 0 ? '' : 'disabled' }}>
                                </td>
                                <td>
                                    <input type="checkbox" class="book-checkbox" {{ $book->stock > 0 ? '' : 'disabled' }}>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Valider la Commande
                </button>
            </form>
        </section>
    </div>

    <footer>
        <div class="footer-content">
            <p>© {{ date('Y') }} Gestion Librairies. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        document.getElementById('order-form').addEventListener('submit', function(event) {
            const checkboxes = document.querySelectorAll('.book-checkbox');
            let atLeastOneSelected = false;

            checkboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const quantityInput = row.querySelector('.book-quantity');
                const idInput = row.querySelector('.book-id');

                if (checkbox.checked) {
                    atLeastOneSelected = true;
                    // S'assurer que les champs sont inclus dans la soumission
                    quantityInput.removeAttribute('disabled');
                    idInput.removeAttribute('disabled');
                } else {
                    // Supprimer les champs pour les livres non sélectionnés
                    quantityInput.removeAttribute('name');
                    idInput.removeAttribute('name');
                }
            });

            if (!atLeastOneSelected) {
                event.preventDefault();
                alert('Veuillez sélectionner au moins un livre pour passer une commande.');
            }
        });
    </script>
</body>
</html>