<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendingTaskReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    //public string $queue = 'emails';

    public function __construct(
        public $manager,
        public $pendingSubmissions,
        public int $pendingCount
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "⏰ {$this->pendingCount} Pending " .
                     ($this->pendingCount === 1 ? 'Entry' : 'Entries') .
                     " Awaiting Review — " . config('brand.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pending-reminder',
        );
    }
}