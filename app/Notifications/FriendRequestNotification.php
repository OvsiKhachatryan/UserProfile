<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FriendRequestNotification extends Notification
{
    use Queueable;
    public $from_user_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($from_user_id)
    {
        $this->from_user_id = $from_user_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'from_user_id' => $this->from_user_id,
            'type' => "friend-request",
            'data' => "friend-request",
        ];
    }
}
