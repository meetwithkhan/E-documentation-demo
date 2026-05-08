<?php

namespace App\Mail;

use App\Models\DeletionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeletionRequestMail extends Mailable
{
    use Queueable, SerializesModels;
    //public string $queue = 'emails';

    public function __construct(
        public DeletionRequest $deletionRequest
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠ Deletion Request — ' . $this->deletionRequest->targetUser->name . ' | ' . config('brand.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.deletion-request',
        );
    }
}