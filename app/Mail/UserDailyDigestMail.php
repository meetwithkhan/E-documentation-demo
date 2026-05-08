<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Collection;

class UserDailyDigestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    //public string $queue = 'emails';

    public function __construct(
        public $user,
        public int $pendingCount,
        public $editRequests
    ) {}

    public function envelope(): Envelope
    {
        $total = $this->pendingCount + $this->editRequests->count();
        return new Envelope(
            subject: "📋 Daily Update — {$total} " .
                     ($total === 1 ? 'Entry Needs' : 'Entries Need') .
                     " Attention | " . config('brand.name'),
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.user-daily-digest');
    }
}