<!DOCTYPE html>
<html>
<head>
    <title>Mes Commandes</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Mes Commandes</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Montant Total</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->total_amount }} €</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @if (auth()->user()->isGestionnaire())
                                <form action="{{ route('orders.update', $order) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="En attente" {{ $order->status == 'En attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="En préparation" {{ $order->status == 'En préparation' ? 'selected' : '' }}>En préparation</option>
                                        <option value="Expédiée" {{ $order->status == 'Expédiée' ? 'selected' : '' }}>Expédiée</option>
                                        <option value="Payée" {{ $order->status == 'Payée' ? 'selected' : '' }}>Payée</option>
                                    </select>
                                </form>
                                @if (!$order->payment)
                                    <form action="{{ route('payments.store', $order) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="number" name="amount" value="{{ $order->total_amount }}" step="0.01" required>
                                        <input type="date" name="payment_date" required>
                                        <button type="submit" class="btn btn-success">Enregistrer Paiement</button>
                                    </form>
                                @endif
                                <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Annuler</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>