<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UpdateInventarisNotification extends Notification
{
    use Queueable;

    protected $dataNotif;

    public function __construct($dataNotif)
    {
        $this->dataNotif = $dataNotif;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->dataNotif['title'],
            'message' => $this->dataNotif['message'],
            'url' => $this->dataNotif['url'] ?? null,
        ];
    }
}