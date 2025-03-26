<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Statistiques</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Ajout de Chart.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .stat-card h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
        }

        .chart-section {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .chart-section h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        canvas {
            max-width: 100%;
            height: 300px;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            padding: 5px 0;
            font-size: 1rem;
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
                    <h1>Statistiques</h1>
                    <p class="header-subtitle">Aperçu des performances de la librairie</p>
                </div>
                <div class="header-right">
                    <a href="{{ route('books.index') }}" class="btn btn-primary">
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
            <div class="alert alert-success" style="background-color: var(--success); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" style="background-color: var(--danger); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <section class="stats-grid">
            <div class="stat-card">
                <h3>Commandes en cours aujourd'hui</h3>
                <p>{{ $ongoingOrders ?? '0' }}</p>
            </div>
            <div class="stat-card">
                <h3>Commandes validées aujourd'hui</h3>
                <p>{{ $validatedOrders ?? '0' }}</p>
            </div>
            <div class="stat-card">
                <h3>Revenus aujourd'hui</h3>
                <p>{{ number_format($dailyRevenue ?? 0, 2) }} FCFA</p>
            </div>
        </section>

        <section class="chart-section">
            <h2>Commandes par mois ({{ now()->year }})</h2>
            <canvas id="ordersPerMonthChart"></canvas>
            <ul>
                @for ($month = 1; $month <= 12; $month++)
                    <li>
                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}: 
                        {{ $ordersPerMonth[$month] ?? 0 }} commandes
                    </li>
                @endfor
            </ul>
        </section>

        <section class="chart-section">
            <h2>Livres vendus par catégorie par mois ({{ now()->year }})</h2>
            @if (isset($booksSoldByCategoryPerMonth) && !$booksSoldByCategoryPerMonth->isEmpty())
                <canvas id="booksSoldByCategoryPerMonthChart"></canvas>
                <ul>
                    @foreach ($booksSoldByCategoryPerMonth as $categoryData)
                        <li>{{ $categoryData['category'] }} :
                            @for ($month = 1; $month <= 12; $month++)
                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}: {{ $categoryData['data'][$month] }} livres vendus
                                @if ($month < 12), @endif
                            @endfor
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Aucune donnée disponible.</p>
            @endif
        </section>

        <section class="chart-section">
            <h2>Livres vendus par catégorie ({{ now()->year }})</h2>
            @if (isset($booksSoldByCategory) && !empty($booksSoldByCategory))
                <canvas id="booksSoldByCategoryChart"></canvas>
                <ul>
                    @foreach ($booksSoldByCategory as $category => $count)
                        <li>{{ $category }}: {{ $count }} livres vendus</li>
                    @endforeach
                </ul>
            @else
                <p>Aucune donnée disponible.</p>
            @endif
        </section>
    </div>

    <footer>
        <div class="footer-content">
            <p>© {{ date('Y') }} Gestion Librairies. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Préparer les données pour le graphique "Commandes par Mois"
        <?php
        $ordersPerMonthData = [];
        if (isset($ordersPerMonth)) {
            for ($month = 1; $month <= 12; $month++) {
                $ordersPerMonthData[] = $ordersPerMonth[$month] ?? 0;
            }
        } else {
            $ordersPerMonthData = array_fill(0, 12, 0);
        }
        ?>

        const ordersPerMonthChart = new Chart(document.getElementById('ordersPerMonthChart'), {
            type: 'bar',
            data: {
                labels: [
                    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                ],
                datasets: [{
                    label: 'Nombre de Commandes',
                    data: <?php echo json_encode($ordersPerMonthData); ?>,
                    backgroundColor: 'rgba(52, 152, 219, 0.6)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre de Commandes'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mois'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        // Préparer les données pour le graphique "Livres Vendus par Catégorie par Mois"
        @if (isset($booksSoldByCategoryPerMonth) && !$booksSoldByCategoryPerMonth->isEmpty())
            const booksSoldByCategoryPerMonthData = @json($booksSoldByCategoryPerMonth);
            const booksSoldByCategoryPerMonthChart = new Chart(document.getElementById('booksSoldByCategoryPerMonthChart'), {
                type: 'line',
                data: {
                    labels: [
                        'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                    ],
                    datasets: booksSoldByCategoryPerMonthData.map(category => ({
                        label: category.category,
                        data: Object.values(category.data),
                        borderColor: '#' + Math.floor(Math.random()*16777215).toString(16), // Couleur aléatoire
                        backgroundColor: 'rgba(0, 0, 0, 0.1)',
                        fill: false,
                    }))
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nombre de livres vendus'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mois'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        @endif

        // Préparer les données pour le graphique "Livres Vendus par Catégorie"
        @if (isset($booksSoldByCategory) && !empty($booksSoldByCategory))
            const booksSoldByCategoryLabels = <?php echo json_encode(array_keys($booksSoldByCategory)); ?>;
            const booksSoldByCategoryData = <?php echo json_encode(array_values($booksSoldByCategory)); ?>;

            const booksSoldByCategoryChart = new Chart(document.getElementById('booksSoldByCategoryChart'), {
                type: 'pie',
                data: {
                    labels: booksSoldByCategoryLabels,
                    datasets: [{
                        label: 'Livres Vendus',
                        data: booksSoldByCategoryData,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right'
                        }
                    }
                }
            });
        @endif
    </script>
</body>
</html>