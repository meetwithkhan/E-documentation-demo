<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewSubmissionNotification extends Notification implements ShouldQueue
{
    use Queueable;
    //public string $queue = 'emails';

    public function __construct(public Submission $submission) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message'       => $this->submission->user->name .
                               ' submitted a new ' .
                               $this->submission->registerName() . ' entry.',
            'type'          => 'info',
            'submission_id' => $this->submission->id,
            'register_name' => $this->submission->registerName(),
            'status'        => 'pending',
            'url'           => route('manager.dashboard'),
        ];
    }
}