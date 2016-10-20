<?php
namespace App\Http\Controllers;

use duzun\hQuery;
use SleepingOwl\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\MeCategory;
use App\MeProduct;
use Carbon\Carbon;
use Sunra\PhpSimple\HtmlDomParser;
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
        $streamContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );  
        $doc = HtmlDomParser::file_get_html( self::URL_CATALOG, false,  stream_context_create($streamContextOptions));
        
//        $doc = hQuery::fromUrl(self::URL_CATALOG);
//        $parents = $doc->find('.l-category .col-left .subcatalog .subcatalog_list');
//        if(!$parents){
//            return back()->with('status', 'Категорий не найдено');
//        }
//        $categoriesCount = 0;
//        foreach ($parents as $parent){
//            $parentA = $parent->find('a.subcatalog_title');
//            if(!$parentA){
//                continue;
//            }
//            $meCategory = new MeCategory();
//            $meCategory->name = trim($parentA->text());
//            $meCategory->link = $parentA->attr('href');
//            $meCategory->parent_id = 0;
//            $meCategory->order = $categoriesCount;
//            $meCategory->save();
//            $categoriesCount++;
//            $subCategories = $parent->find('ul a');
//            if(!$subCategories){
//                continue;
//            }
//            foreach($subCategories as $a){
//                MeCategory::create([
//                    'name' => trim($a->text()),
//                    'link' => $a->attr('href'),
//                    'parent_id' => $meCategory->id,
//                    'order' => $categoriesCount
//                ]);
//                $categoriesCount++;
//            }
//        }
//        return back()->with('status', 'Получено категорий '.$categoriesCount);
    }
}

