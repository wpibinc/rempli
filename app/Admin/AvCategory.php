<?php

use App\AvCategory;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(AvCategory::class, function (ModelConfiguration $model) {
    $model->setTitle('Категории Азбуки вкуса');

    $model->disableCreating();
    //$model->disableEditing();
    $model->disableDeleting();

    $model->enableAccessCheck();

    $model->onDisplay(function () {
        return AdminDisplay::tree()->setValue(function ($instanse){
            if ($instanse->parse)
                return "<b>{$instanse->fullname}</b> [id:{$instanse->id}] <span class='badge'>{$instanse->total}</span>";
            else
                return "<strike><b>{$instanse->fullname}</b> [id:{$instanse->id}] <span class='badge'>{$instanse->total}</span></strike>";
        })
            ->setReorderable(false);
    });


    $model->onEdit(function($id = null) {
        $form = AdminForm::panel();

        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(
                    function() {
                        return [
                            AdminFormElement::text('id', 'ID')->setReadonly(true),
                            AdminFormElement::text('name', 'Название')->setReadonly(true),
                            AdminFormElement::text('link', 'Ссылка')->setReadonly(true),
                            AdminFormelement::checkbox('parse', 'Парсим?')

                        ];
                    }
                )->addColumn(function ()
                {return[];})
        );
        return $form;
    });
});
