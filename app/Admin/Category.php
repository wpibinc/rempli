<?php

use App\Category;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Category::class, function (ModelConfiguration $model) {
    $model->setTitle('Категории');

    $model->enableAccessCheck();

    $model->onDisplay(function () {
        return AdminDisplay::tree()->setValue('name');
    });


    $model->onCreateAndEdit(function($id = null) {
        $form = AdminForm::panel();

        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(
                    function() {
                        return [
                            AdminFormElement::text('category_id', 'Старый ID')->required()->unique(),
                            AdminFormElement::text('name', 'Название')->required(),
                            AdminFormElement::text('alias', 'Короткий URL')->required(),
                            AdminFormElement::text('img', 'Url изображения')->required(),
                            AdminFormElement::multiselect('avcategories', 'Категории АВ')
                                ->setModelForOptions(new \App\AvCategory)
                                ->setDisplay('name'),
                                //->required(),
                        ];
                    }
                )->addColumn(function ()
                {return[];})
        );
        return $form;
    });
})
    ->addMenuPage(Category::class, 1)
    ->setIcon('fa fa-sitemap');