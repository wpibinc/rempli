<?php

namespace App\Listeners;

use App\Events\SmsEvent;
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
        $text1 = "$name. Сумма заказа $cost руб.";



        $userPhone = $user->phone;
        $text2 = 'Ваш заказ на сумму '.$cost.' рублей принят. В ближайшее время мы свяжемся с Вами для подтверждения';
        $sms2 = new \Zelenin\SmsRu\Entity\Sms($userPhone, $text2);
        $sms = new \Zelenin\SmsRu\Entity\Sms($phone, $text1);

//        $client->smsSend($sms);
//        $client->smsSend($sms2);
    }
}
