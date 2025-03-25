@component('mail::message')
# Commande Expédiée

Bonjour {{ $order->user->name }},

Votre commande #{{ $order->id }} a été expédiée avec succès. Vous trouverez la facture en pièce jointe.

## Détails de la commande
- **Livre** : {{ $order->book->title }}
- **Quantité** : {{ $order->quantity }}
- **Prix Total** : {{ number_format($order->total_price, 2) }} FCFA

Merci pour votre achat !

Cordialement,  
L'équipe Bookstore

@component('mail::button', ['url' => route('orders.my_orders')])
Voir mes commandes
@endcomponent
@endcomponent