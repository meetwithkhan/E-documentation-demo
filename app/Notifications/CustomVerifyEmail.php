<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email — ' . config('brand.name'))
            ->view('emails.verify-email', [
                'url'  => $verificationUrl,
                'user' => $notifiable, // Pass the $notifiable variable directly
            ]);
    }
}