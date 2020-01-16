<?php

namespace App\Notifications;

use App\Notifications\Traits\BaseNotificationTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FundRaisingReceivedNotification extends Notification
{
    use Queueable, BaseNotificationTrait;

    protected $emailView = 'emails.fund-raising.index';

    protected $transaction;

    protected $lang = null;

    /**
     * Create a new notification instance.
     *
     * @param $transaction
     */
    public function __construct($transaction, $lang = null)
    {
        $this->transaction = $transaction;
        if ($lang) {
            $this->lang = $lang;
        }
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
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.fund-raising.index', [
                'lang'        => $this->lang,
                'transaction' => $this->transaction,
                'logo'        => $this->getGCCLogo()])
            ->subject('Thank you! Donation Received')->from('admin@glorycitychurch.com', 'GCC Fundraising');
    }

    public function getGCCLogo()
    {
        $logo = asset('img/logo--short.png');
        if ($logo) {
            $type = 'png';
            $data = file_get_contents($logo);
            $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return $logo;
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

    /**
     * Get custom variables
     * @return mixed
     */
    public function getVariables()
    {
        return $this->transaction->toArray();
    }
}
