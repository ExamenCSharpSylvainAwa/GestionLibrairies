@component('mail::message')
# Nouvelle commande validée #{{ $order->id }}

Bonjour,

Une nouvelle commande a été validée par l'utilisateur **{{ $order->user->name }}**.

**Détails de la commande :**
- **ID Commande** : {{ $order->id }}
- **Montant Total** : {{ number_format($order->total_amount, 2) }} FCFA
- **Statut** : {{ $order->status->label() }}

Veuillez vérifier et traiter cette commande.

Cordialement,  
L'équipe Gestion Librairies

@component('mail::button', ['url' => route('orders.index')])
Voir toutes les commandes
@endcomponent

@endcomponent