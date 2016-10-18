<?php

namespace App\Listeners;

use App\Events\SmsEvent;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SmsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SmsEvent  $event
     * @return void
     */
    public function handle(SmsEvent $event)
    {

        $apiId = 'BAFD72FC-2E9F-6C9F-77BF-4F2BDEEBD21F';
        $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth($apiId));

        $phone = '89645805819';
        $text = 'Добрый день, '.$event->user->fname. ' ' .$event->user->sname. '. Напоминаем, что у Вас имеются неоплаченные счета на сумму ' .$event->user->getInvoicesTotal(). ' руб. Просьба оплатить счет в течение 24 часов.';
        $userPhone = $event->user->phone;
        $sms = new \Zelenin\SmsRu\Entity\Sms($userPhone, $text);

        $client->smsSend($sms);
    }
}
