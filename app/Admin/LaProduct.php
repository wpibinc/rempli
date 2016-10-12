<?php

use App\LaProduct;
use App\Category;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(LaProduct::class, function (ModelConfiguration $model) {
    $model->enableAccessCheck();
    $model->disableCreating();
    $model->disableEditing();
    $model->disableDeleting();
    $model->setTitle('Продукты La maree');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync();
        return $display
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('articul')->setLabel('артикул'),
                AdminColumn::custom('image')
                    ->setCallback(function ($instance) {
                        return "<img src='{$instance->image}' width='100px'>";
                    })
                    ->setLabel('Изображение'),
                AdminColumn::link('name')->setLabel('Название'),
                AdminColumn::text('price')->setLabel('Цена'),
                AdminColumn::text('price_style')->setLabel('Кол-во')
            ])->paginate(20);
    });
});

