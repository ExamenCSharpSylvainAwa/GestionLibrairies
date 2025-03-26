<?php

namespace App\Observers;

use App\Models\Order;
use App\Enums\OrderStatus;
use App\Mail\InvoiceEmail;
use App\Mail\OrderValidatedEmail;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        try {
            // Vérifier si le statut a changé à "Expédiée"
            if ($order->wasChanged('status') && $order->status === \App\Enums\OrderStatus::SHIPPED) {
                // Envoyer un email au client
                Mail::to($order->user->email)->send(new OrderShipped($order));

                // Générer la facture PDF
                $pdf = Pdf::loadView('orders.invoice', compact('order'));
                $pdfPath = storage_path("app/public/invoices/order-{$order->id}.pdf");
                $pdf->save($pdfPath);

                // Envoyer un email au gestionnaire avec la facture
                Mail::to('gestionnaire@librairie.com')->send(new InvoiceMail($order, $pdfPath));
            }

            // Vérifier si le statut a changé à "Validée"
            if ($order->wasChanged('status') && $order->status === \App\Enums\OrderStatus::VALIDATED) {
                // Envoyer un email au client
                Mail::to($order->user->email)->send(new OrderValidated($order));

                // Envoyer un email au gestionnaire
                Mail::to('gestionnaire@librairie.com')->send(new OrderValidatedNotification($order));
            }
        } catch (\Exception $e) {
            // Enregistrer l'erreur dans les logs
            Log::error('Erreur lors de l\'envoi des emails dans OrderObserver : ' . $e->getMessage());
        }
    }
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
  

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
