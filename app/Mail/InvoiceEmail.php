<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Order;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    protected $pdfPath;
    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param string $pdfPath
     */

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, $pdfPath)
    {
        $this->order = $order;
        $this->pdfPath = $pdfPath;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Email',
        );
    }

    public function build()
    {
        return $this->markdown('emails.invoice')
                    ->subject('Votre facture pour la commande #' . $this->order->id)
                    ->attach($this->pdfPath, [
                        'as' => 'facture-commande-' . $this->order->id . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invoice',
        );
    }
    public function __destruct()
    {
        if (file_exists($this->pdfPath)) {
            unlink($this->pdfPath);
        }
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
