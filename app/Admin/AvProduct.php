<?php

use App\AvProduct;
use App\Category;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(AvProduct::class, function (ModelConfiguration $model) {
    $model->enableAccessCheck();
    $model->disableCreating();
    $model->disableEditing();
    $model->disableDeleting();
    $model->setTitle('Продукты Азбуки вкуса');

    // Display
    $model->onDisplay(function () {
        //$category = new Category;
        //$category->setKeyName('id');
        //$display = AdminDisplay::table();
        $display = AdminDisplay::datatablesAsync();
//        $display->setColumnFilters([
//            null,
//            null,
//            null,
//            null,
//            AdminColumnFilter::select()->setPlaceholder('Рубрика')->setModel($category)->setDisplay('name'),
//            ]);
//
//        $display->with('category');
//        $display->setFilters([
//            AdminDisplayFilter::related('category_id')->setModel(Category::class)
//        ]);
        return $display
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('id')->setLabel('ID'),
                AdminColumn::custom('image')
                    ->setCallback(function ($instance) {
                        return "<img src='http://av.ru{$instance->image}' width='100px'>";
                    })
                    ->setLabel('Изображение'),
                //AdminColumn::link('objectId')->setLabel('старый ID'),
                AdminColumn::link('name')->setLabel('Название'),
                //AdminColumn::text('category.name')->setLabel('Категория')->append(AdminColumn::filter('category_id')),
                AdminColumn::text('price')->setLabel('Цена'),
                AdminColumn::text('original_typical_weight')->setLabel('Вес'),
                AdminColumn::text('original_price_style')->setLabel('Кол-во')
            ])->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        $category = new Category;
        $category->setKeyName('category_id');

        return AdminForm::panel()->addBody([
               AdminFormElement::text('objectId', 'старый ID')->setReadonly(true),
               AdminFormElement::text('ctitles', 'Заголовки'),
               AdminFormElement::text('cvalues', 'Значения'),
               AdminFormElement::text('img', 'Url изображения')->required(),
               AdminFormElement::select('category_id', 'Категория')->setModelForOptions($category)->setDisplay('name'),
               AdminFormElement::text('product_name', 'Название')->required(),
               AdminFormElement::text('price', 'Цена')->required(),
               AdminFormElement::text('weight', 'Вес'),
               AdminFormElement::text('amount', 'Кол-во')->required(),
               AdminFormElement::textarea('description', 'Описание')->required(),
        ]);
    });
});