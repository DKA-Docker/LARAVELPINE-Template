<?php

namespace App\Mail\Dashboards\Apps\Deliveries;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $requestData;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($requestData, $user)
    {
        $this->requestData = $requestData;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Delivery Request Created Successfully - ' . $this->requestData->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.dashboards.apps.deliveries.request-created',
            with: [
                'requestOrder' => $this->requestData,
                'user' => $this->user,
            ],
        );
    }
}
