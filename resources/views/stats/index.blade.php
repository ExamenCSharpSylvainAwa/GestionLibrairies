<!DOCTYPE html>
<html>
<head>
    <title>Statistiques</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Statistiques</h1>
        <p>Commandes aujourd'hui: {{ $ordersToday }}</p>
        <p>Commandes validées aujourd'hui: {{ $completedOrdersToday }}</p>
        <p>Recettes aujourd'hui: {{ $revenueToday }} €</p>

        <h2>Commandes par mois</h2>
        <canvas id="ordersChart"></canvas>

        <h2>Livres vendus par catégorie</h2>
        <canvas id="booksChart"></canvas>
    </div>

    <script>
        // Commandes par mois
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Commandes',
                    data: @json(array_replace(array_fill(1, 12, 0), $ordersPerMonth)),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Livres vendus par catégorie
        const booksCtx = document.getElementById('booksChart').getContext('2d');
        new Chart(booksCtx, {
            type: 'pie',
            data: {
                labels: @json(array_keys($booksSoldByCategory)),
                datasets: [{
                    label: 'Livres vendus',
                    data: @json(array_values($booksSoldByCategory)),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>