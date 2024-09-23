<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;
use NotificationChannels\OneSignal\OneSignalMessage;
use OneSignal;
class SendPushNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['onesignal'];
    }

    public function toOneSignal($notifiable)
    {
        return OneSignalMessage::create()
            ->subject("New Post Available")
            ->body("Check out our latest post now!");
    }
}
