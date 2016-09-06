<?php
use App\Review;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Review::class, function (ModelConfiguration $model) {
    $model->enableAccessCheck();
    $model->setTitle('Отзывы');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display->paginate(15);
        return $display->setColumns([
            AdminColumn::text('name')->setLabel('Имя'),
            AdminColumn::text('content')->setLabel('Отзыв')->setWidth('400px'),
        ]);
    });
    
    $model->onCreateAndEdit(function() {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('content')->setLabel('Отзыв')->required(),
            AdminFormElement::text('name')->setLabel('Имя')->required()
        );
        return $form;

    });
})->addMenuPage(Review::class, 0)
    ->setIcon('fa fa-group');
