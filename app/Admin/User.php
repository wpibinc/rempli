<?php

use App\User;
use App\Order;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
    $model->enableAccessCheck();
    $model->setTitle('Пользователи');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display->paginate(15);
        $display->with('orders');
        return $display->setColumns([
            
            AdminColumn::text('fname')->setLabel('Имя'),
            AdminColumn::text('sname')->setLabel('Фамилия'),
            AdminColumn::text('phone')->setLabel('Телефон'),
            AdminColumn::text('email')->setLabel('E-mail'),
            AdminColumn::text('confirmed')->setLabel('Активный'),
            AdminColumn::count('orders')->setLabel('Заказы'),
        ]);
    });
    
    $model->onEdit(function() {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('fname')->setLabel('Имя')->required(),
            AdminFormElement::text('sname')->setLabel('Фамилия')->required(),
            AdminFormElement::text('confirmed')->setLabel('Активный')->required()
        );
        return $form;

    });
})->addMenuPage(User::class, 0)
    ->setIcon('fa fa-group');

