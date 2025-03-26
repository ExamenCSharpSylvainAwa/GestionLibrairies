@component('mail::message')
# Votre facture pour la commande #{{ $order->id }}

Bonjour {{ $order->user->name }},

Votre commande a été expédiée ! Vous trouverez votre facture en pièce jointe.

**Détails de la commande :**
- **ID Commande** : {{ $order->id }}
- **Montant Total** : {{ number_format($order->total_amount, 2) }} FCFA
- **Statut** : {{ $order->status->label() }}

Merci de votre confiance !

Cordialement,  
L'équipe Gestion Librairies

@component('mail::button', ['url' => route('orders.my_orders')])
Voir mes commandes
@endcomponent

@endcomponent