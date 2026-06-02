<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly string $temporaryPassword) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to Apex Estate Operations — Set Your Password')
            ->greeting("Hello, {$notifiable->name}!")
            ->line('An account has been created for you on Apex Estate Operations.')
            ->line('Use the temporary password below to log in for the first time:')
            ->line("**Temporary Password:** `{$this->temporaryPassword}`")
            ->action('Log In Now', url('/admin/login'))
            ->line('You will be required to set a new password immediately after logging in.')
            ->line('If you did not expect this email, please contact your administrator.');
    }
}
