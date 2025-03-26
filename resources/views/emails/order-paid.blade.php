@component('mail::message')
# Commande #{{ $order->id }} Payée

Bonjour {{ $order->user->name }},

Nous vous informons que votre commande #{{ $order->id }} a été payée avec succès !

## Détails de la commande
- **Montant total** : {{ number_format($order->total_amount, 2) }} FCFA
- **Date de la commande** : {{ $order->created_at->format('d/m/Y H:i') }}

Merci de votre confiance !

Cordialement,  
L'équipe de Gestion Librairies

@component('mail::button', ['url' => route('orders.show', $order->id)])
Voir la commande
@endcomponent
@endcomponent