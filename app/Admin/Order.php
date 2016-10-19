<?php

use App\Order;
use SleepingOwl\Admin\Model\ModelConfiguration;
use Carbon\Carbon;

AdminSection::registerModel(Order::class, function (ModelConfiguration $model) {
    $model->setTitle('Заказы');

    $model->enableAccessCheck();

    $model->onDisplay(function () {
        //$display = AdminDisplay::datatablesAsync()->setHtmlAttribute('class', 'table-primary');
        $display = AdminDisplay::datatables()
            ->setHtmlAttribute('class', 'table-primary');
        $display->setOrder([[4, 'desc']]);;


        $display->setColumns(
            [
                AdminColumn::text('id')->setLabel('ID'),
                AdminColumn::custom()->setLabel('Статус')->setCallback(function (Order $model) {
                    switch ($model->status) {
                        case 'новый':
                            return "<span class=\"label label-info\">$model->status</span>";
                            break;
                        case 'в работе':
                            return "<span class=\"label label-warning\">$model->status</span>";
                            break;
                        case 'выполнен':
                            return "<span class=\"label label-success\">$model->status</span>";
                            break;
                        case 'отменен':
                            return "<span class=\"label label-default\">$model->status</span>";
                            break;
                    }
                    })->setWidth('50px')->setHtmlAttribute('class', 'text-center')->setOrderable(false),
                AdminColumn::link('name')->setLabel('Имя'),
                AdminColumn::link('phone')->setLabel('Телефон'),
                AdminColumn::datetime('date')->setLabel('Дата')->setFormat('d.m.Y H:m'),
                AdminColumn::custom()->setLabel('Магазин')->setCallback(function(Order $model){
                    switch($model->shop){
                        case 'La': return 'La Maree';
                            break;
                        default: return 'Азбука вкуса';
                            break;
                    }
                }),
            ]
        );

        return $display;
    });


    $model->onCreateAndEdit(function($id = null) {

        $form = AdminForm::panel();
        $all=[];
        $data = \App\OrderItem::where('order_id', $id)->get();
        foreach ($data as $item) {
            $avp=\App\AvProduct::where('id',$item['objectId'])->get();
            $all[] = (! $avp->isEmpty()) ? $avp : \App\Product::where('id',$item['objectId'])->get();
        }

        $now = Carbon::now();
        $order = Order::find($id);
        $user = $order->user;
        $haveSubs = false;
        $subscription = \App\Subscription::where('user_id', $user->id)
                ->where('end_subscription', '>', $now)
                ->first();

        if($subscription){
            if($subscription->auto_subscription == 0){
                $haveSubs = true;
            }elseif ($subscription->is_free){
                $haveSubs = true;
            } else {
                $subs = $subscription->invoices()->where('title', 'Продление подписки')->first();
                if($subs->is_paid){
                    $haveSubs = true;
                }
            }
        }
        $form->addBody([
            AdminFormElement::select('status', 'Статус') ->setEnum(['новый','в работе','выполнен','отменен']),
            AdminFormElement::view('misc.over8kg')->setData(['order' => $order, 'haveSubs'=>$haveSubs]),
            AdminFormElement::text('name', 'Имя'),
            AdminFormElement::text('phone', 'Телефон'),
            AdminFormElement::text('address', 'Адрес'),
            AdminFormElement::text('house', 'Дом'),
            AdminFormElement::text('korp', 'корпус'),
            AdminFormElement::text('flat', 'квартира'),
            AdminFormElement::textarea('comment', 'Комментарий к заказу')->setRows(2),
            AdminFormElement::view('misc.cart')->setData(['order' => $data, 'items'=>$all]),
            AdminFormElement::text('mass', 'Вес'),
            AdminFormElement::text('cost', 'Стоимость')

        ]);

        return $form;

    });
})
    ->addMenuPage(Order::class, 1)
    ->setIcon('fa fa-usd');