<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ActionAgenceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $actionBy;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $actionBy)
    {
        $this->message = $message;
        $this->actionBy = $actionBy;
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
    /*
    
    */

    /**
     * Store notification in database.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => $this->message,
        'action_by' => $this->actionBy,
        'type' => 'paiement',
        'timestamp' => now(),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'action_by' => $this->actionBy,
        ];
    }
}
