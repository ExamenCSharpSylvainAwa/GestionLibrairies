<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPaid extends Mailable
{
    use Queueable, SerializesModels;
    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Paid',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-paid',
        );
    }
    public function build()
    {
        // Générer le PDF directement ici
        $pdf = Pdf::loadView('invoices.order_invoice', ['order' => $this->order]);

        return $this->subject('Votre commande a été expédiée')
                    ->view('emails.order_shipped')
                    ->attachData($pdf->output(), 'facture-'.$this->order->id.'.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
