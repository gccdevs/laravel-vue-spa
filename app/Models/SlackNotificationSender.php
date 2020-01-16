<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SlackNotificationSender extends Model
{
    use Notifiable;

    public function routeNotificationForSlack()
    {
        return env('LOG_SLACK_WEBHOOK_URL');
    }
}
