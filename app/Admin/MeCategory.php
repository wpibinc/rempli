<?php

use App\MeCategory;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(MeCategory::class, function (ModelConfiguration $model) {
    $model->setTitle('Категории Metro');

    $model->disableCreating();
    $model->disableEditing();
    $model->disableDeleting();

    $model->enableAccessCheck();

    $model->onDisplay(function () {
        return AdminDisplay::tree()->setValue(function ($instanse){
            return "{$instanse->name} [id:{$instanse->id}]";
        })
            ->setReorderable(true);
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

                        ];
                    }
                )->addColumn(function ()
                {return[];})
        );
        return $form;
    });
});
