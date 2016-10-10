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
                AdminColumn::text('articul')->setLabel('articul'),
                AdminColumn::custom('image')
                    ->setCallback(function ($instance) {
                        return "<img src='{$instance->image}' width='100px'>";
                    })
                    ->setLabel('Изображение'),
                //AdminColumn::link('objectId')->setLabel('старый ID'),
                AdminColumn::link('name')->setLabel('Название'),
                //AdminColumn::text('category.name')->setLabel('Категория')->append(AdminColumn::filter('category_id')),
                AdminColumn::text('price')->setLabel('Цена'),
                AdminColumn::text('weight')->setLabel('Вес'),
                AdminColumn::text('price_style')->setLabel('Кол-во')
            ])->paginate(20);
    });
});

