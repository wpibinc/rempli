<?php
namespace App\Http\Controllers;

use duzun\hQuery;
use File;
use DB;
use Illuminate\Support\Facades\Artisan;
use SleepingOwl\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\LaCategory;
use App\LaProduct;
use App\Jobs\ParseLaMaree;
use Carbon\Carbon;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MeParseController extends AdminController
{
    const URL_CATALOG = 'https://online.metro-cc.ru/category/produkty';
    
    public function __construct(Request $request)
    {
        $this->path = public_path() . '/parser/cache/';
    }
    
    public function index(Request $request)
    {
        return $this->renderContent(view('admin.me-parser'));
    }
    
    public function getProducts(Request $request)
    {
        
    }
    
    public function getCategories(Request $request)
    {
        $doc = hQuery::fromUrl(self::URL_CATALOG);
        $parents = $doc->find('.l-category .col-left .subcatalog .subcatalog_list');
        if(!$parents){
            return back()->with('status', 'Категорий не найдено');
        }
        foreach ($parents as $parent){
            $parentLink = $parent->attr('href');
            //$parentNam
        }
    }
}

