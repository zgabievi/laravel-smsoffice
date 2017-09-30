<?php

namespace Gabievi\LaravelSMSOffice;

use Illuminate\Notifications\Notification;
use Gabievi\LaravelSMSOffice\Exceptions\MissingRecipient;

class SMSOfficeChannel
{
    /** @var \Gabievi\LaravelSMSOffice\SMSOffice */
    protected $smsoffice;

    //
    public function __construct(SMSOffice $smsoffice)
    {
        $this->smsoffice = $smsoffice;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $to = $notifiable->routeNotificationFor('smsoffice');

        if (empty($to)) {
            throw new MissingRecipient;
        }

        $message = $notification->toSMSOffice($notifiable);

        if (is_string($message)) {
            $message = new SMSOfficeMessage($message);
        }

        $this->sendMessage($to, $message);
    }

    //
    protected function sendMessage($recipient, SMSOfficeMessage $message)
    {
        if (strpos($recipient, '+') === 0) {
            $recipient = substr($recipient, 1);
        }

        if (strpos($recipient, '00') === 0) {
            $recipient = substr($recipient, 2);
        }

        $params = [
            'destination' => urlencode($recipient),
            'content'     => $message->content,
        ];

        $this->smsoffice->send($params);
    }
}
