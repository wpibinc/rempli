<?php

use App\Category;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Category::class, function (ModelConfiguration $model) {
    $model->setTitle('Категории');

    $model->enableAccessCheck();

    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display->paginate(15);
        return $display->setColumns([
            AdminColumn::text('name')->setLabel('Название'),
            AdminColumn::text('alias')->setLabel('Псевдоним'),
            AdminColumn::text('img')->setLabel('Фотография'),
            AdminColumn::text('email')->setLabel('E-mail'),
           // AdminColumn::count('orders')->setLabel('Заказы'),
        ]);
        //return AdminDisplay::tree()->setValue('name');
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
                             AdminFormElement::multiselect('lacategories', 'Категории La maree')
                                ->setModelForOptions(new \App\LaCategory)
                                ->setLoadOptionsQueryPreparer(function($item, $query) {
                                    return $query
                                        ->where('parent_id', 0);
                               })
                                ->setDisplay('name'),
                             AdminFormElement::multiselect('mecategories', 'Категории Metro')
                                ->setModelForOptions(new \App\MeCategory)
                                ->setLoadOptionsQueryPreparer(function($item, $query) {
                                    return $query
                                        ->join('me_categories AS parent_categories', 'me_categories.parent_id', '=', 'parent_categories.id')
                                        ->where('me_categories.parent_id', '!=', 0)
                                        ->select('me_categories.*', 'parent_categories.name as parent_name', \Illuminate\Support\Facades\DB::raw('CONCAT(me_categories.name, " (", parent_categories.name, ")") AS name'));
                               })
                                ->setDisplay('name'),
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