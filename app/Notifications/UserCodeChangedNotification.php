<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserCodeChangedNotification extends Notification
{
    use Queueable;

    protected $code;
    protected $url;

    /**
     * Create a new notification instance.
     *
     * @param $code
     */
    public function __construct($code, $url = null)
    {
        $this->code = $code;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->url) {
            return (new MailMessage)
                ->subject('Security code changed!')
                ->from('noreply@glorycitychurch.com', 'GCC - Central Hub Notification')
                ->line('Your new security code is: ' . $this->code)
                ->line('Alternatively, click the button below: ')
                ->action('Check here', $this->url);
        } else {
            return (new MailMessage)
                ->subject('Security code changed!')
                ->from('noreply@glorycitychurch.com', 'GCC - Central Hub Notification')
                ->line('Your new security code is: ' . $this->code);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
