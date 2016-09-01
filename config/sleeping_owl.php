<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Title
    |--------------------------------------------------------------------------
    |
    | Displayed in title and header.
    |
    */

    'title' => 'Rempli administrator',

    /*
    |--------------------------------------------------------------------------
    | Admin Logo
    |--------------------------------------------------------------------------
    |
    | Displayed in navigation panel.
    |
    */

    'logo'      => '<span class="pull-left">Rempli</span>',
    'logo_mini' => 'R',

    /*
    |--------------------------------------------------------------------------
    | Admin URL prefix
    |--------------------------------------------------------------------------
    */

    'url_prefix' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Middleware to use in admin routes
    |--------------------------------------------------------------------------
    |
    | In order to create authentication views and routes
    | don't forget to execute `php artisan make:auth`.
    | See https://laravel.com/docs/5.2/authentication#authentication-quickstart
    |
    */

    'middleware' => ['web', 'enter'],

    /*
    |--------------------------------------------------------------------------
    | Authentication default provider
    |--------------------------------------------------------------------------
    |
    | @see config/auth.php : providers
    |
    */

    'auth_provider' => 'users',

    /*
    |--------------------------------------------------------------------------
    |  Path to admin bootstrap files directory
    |--------------------------------------------------------------------------
    |
    | Default: app_path('Admin')
    |
    */

    'bootstrapDirectory' => app_path('Admin'),

    /*
    |--------------------------------------------------------------------------
    |  Directory for uploaded images (relative to `public` directory)
    |--------------------------------------------------------------------------
    */

    'imagesUploadDirectory' => 'images/uploads',

    /*
    |--------------------------------------------------------------------------
    |  Directory for uploaded files (relative to `public` directory)
    |--------------------------------------------------------------------------
    */

    'filesUploadDirectory' => 'files/uploads',

    /*
    |--------------------------------------------------------------------------
    |  Admin panel template
    |--------------------------------------------------------------------------
    */

    'template' => SleepingOwl\Admin\Templates\TemplateDefault::class,

    /*
    |--------------------------------------------------------------------------
    |  Default date and time formats
    |--------------------------------------------------------------------------
    */

    'datetimeFormat' => 'd.m.Y H:i',
    'dateFormat'     => 'd.m.Y',
    'timeFormat'     => 'H:i',

    /*
    |--------------------------------------------------------------------------
    | Editors
    |--------------------------------------------------------------------------
    |
    | Select default editor and tweak options if needed.
    |
    */

    'wysiwyg' => [
        'default'   => 'ckeditor',

        /*
         * See http://docs.ckeditor.com/#!/api/CKEDITOR.config
         */
        'ckeditor'  => [
            'height' => 200,
        ],

        /*
         * See https://www.tinymce.com/docs/
         */
        'tinymce'   => [
            'height' => 200,
        ],

        /*
         * See https://github.com/NextStepWebs/simplemde-markdown-editor
         */
        'simplemde' => [
            'hideIcons' => ['side-by-side', 'fullscreen'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | DataTables
    |--------------------------------------------------------------------------
    |
    | Select default settings for datatable
    |
    */
    'datatables' => [
        'orderCellsTop'=>1
    ],

    /*
    |--------------------------------------------------------------------------
    | Breadcrumbs
    |--------------------------------------------------------------------------
    |
    */
    'breadcrumbs' => true,

    /*
   |--------------------------------------------------------------------------
   | Autoloaded Service Providers
   |--------------------------------------------------------------------------
   |
   | The service providers listed here will be automatically loaded on the
   | request to your application. Feel free to add your own services to
   | this array to grant expanded functionality to your applications.
   |
   */

    'providers' => [
        SleepingOwl\Admin\Providers\AliasesServiceProvider::class,
        KodiCMS\Assets\AssetsServiceProvider::class,
        Collective\Html\HtmlServiceProvider::class,
        SleepingOwl\Admin\Providers\AdminServiceProvider::class,
        DaveJamesMiller\Breadcrumbs\ServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started.
    |
    */

    'aliases' => [
        'Assets' => KodiCMS\Assets\Facades\Assets::class,
        'PackageManager' => KodiCMS\Assets\Facades\PackageManager::class,
        'Meta' => KodiCMS\Assets\Facades\Meta::class,
        'Form' => Collective\Html\FormFacade::class,
        'HTML' => Collective\Html\HtmlFacade::class,
        'WysiwygManager' => SleepingOwl\Admin\Facades\WysiwygManager::class,
        'Breadcrumbs' => DaveJamesMiller\Breadcrumbs\Facade::class,

        'AdminSection' => SleepingOwl\Admin\Facades\Admin::class,
        'AdminTemplate' => SleepingOwl\Admin\Facades\Template::class,
        'AdminNavigation' => SleepingOwl\Admin\Facades\Navigation::class,
        'AdminColumn' => SleepingOwl\Admin\Facades\TableColumn::class,
        'AdminColumnEditable' => SleepingOwl\Admin\Facades\TableColumnEditable::class,
        'AdminColumnFilter' => SleepingOwl\Admin\Facades\TableColumnFilter::class,
        'AdminDisplayFilter' => SleepingOwl\Admin\Facades\DisplayFilter::class,
        'AdminForm' => SleepingOwl\Admin\Facades\Form::class,
        'AdminFormElement' => SleepingOwl\Admin\Facades\FormElement::class,
        'AdminDisplay' => SleepingOwl\Admin\Facades\Display::class,
    ],
];
