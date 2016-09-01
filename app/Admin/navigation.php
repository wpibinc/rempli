<?php

use App\Category;
use SleepingOwl\Admin\Navigation\Page;

$submenu = [];

if (! \App::runningInConsole()) {
    $categories = Category::all();

foreach ($categories as $category) {
    $submenu[] =
        [
            'title' => $category['name'],
            'icon' => 'fa fa-plus',
            'url' => '/admin/products?category_id=' . $category['category_id']
        ];
}
};

$menu = [
    [
        'title' => 'Панель управления',
        'icon'  => 'fa fa-dashboard',
        'url'   => route('admin.dashboard'),
        'priority' => 0
    ],
    [
        'title' => 'Продукты по категориям',
        'icon' => 'fa fa-group',
        'pages' => $submenu,
        'priority' => 9,
        'AccessLogic' => function() {
            return auth()->user()->username=='admin';
        }

    ],
    [
        'title' => 'Экспорт продуктов',
        'icon'  => 'fa fa-download',
        'url'   => 'admin/export',
        'priority' => 10,
        'AccessLogic' => function() {
            return auth()->user()->username=='admin';
        }
    ],
    [
        'title' => 'Парсер',
        'icon'  => 'fa fa fa-globe',
        //'url'   => 'admin/parser',
        'pages' => [

            (new Page(\App\AvCategory::class))
                ->setIcon('fa fa-plus')
                ->setTitle('Категории АВ')
                ->setPriority(0),
            (new Page(\App\AvProduct::class))
                ->setIcon('fa fa-plus')
                ->setTitle('Продукты АВ')
                ->setPriority(1),
            [
                'title' => 'Парсер',
                'icon' => 'fa fa-plus',
                'url' => '/admin/parser'
            ],
        ],
        'priority' => 11,
        'AccessLogic' => function() {
            return auth()->user()->username=='admin';
        }
    ],
    [
        'title' => 'Кеш',
        'icon'  => 'fa fa-trash-o',
        'url'   => 'admin/cache',
        'priority' => 12
    ],
    [
        'title' => 'Выход',
        'icon'  => 'fa fa-sign-out',
        'url'   => '/logout',
        'priority' => 100
    ]
];

return $menu;