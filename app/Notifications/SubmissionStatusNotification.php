<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SubmissionStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;
    //public string $queue = 'emails';

    public function __construct(
        public Submission $submission,
        public string $message,
        public string $type = 'info'
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message'       => $this->message,
            'type'          => $this->type,
            'submission_id' => $this->submission->id,
            'register_name' => $this->submission->registerName(),
            'status'        => $this->submission->status,
            'url'           => route('submissions.index'),
        ];
    }
}