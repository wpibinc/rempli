<?php

use App\Product;
use App\Category;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Product::class, function (ModelConfiguration $model) {
    $model->enableAccessCheck();
    $model->setTitle('Продукты');

    // Display
    $model->onDisplay(function () {
        $category = new Category;
        $category->setKeyName('category_id');
        //$display = AdminDisplay::table();
        $display = AdminDisplay::datatablesAsync();
        $display->setColumnFilters([
            null,
            null,
            null,
            null,
            AdminColumnFilter::select()->setPlaceholder('Рубрика')->setModel($category)->setDisplay('name'),
            ]);

        $display->with('category');
        $display->setFilters([
            AdminDisplayFilter::related('category_id')->setModel(Category::class)
        ]);
        return $display
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('id')->setLabel('ID'),
                AdminColumn::image('img')->setLabel('Изображение')
                    ->setWidth('100px'),
                //AdminColumn::link('objectId')->setLabel('старый ID'),
                AdminColumn::link('product_name')->setLabel('Название'),
                AdminColumn::text('category.name')->setLabel('Категория')->append(AdminColumn::filter('category_id')),
                AdminColumn::text('price')->setLabel('Цена'),
                AdminColumn::text('weight')->setLabel('Вес'),
                AdminColumn::text('amount')->setLabel('Кол-во')
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
})->addMenuPage(Product::class, 1)
    ->setIcon('fa fa-gift');