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
    const URL_MAIN = 'https://online.metro-cc.ru';
    protected $meCategoryId;
    protected $categoryCount = 0;

    public function __construct(Request $request)
    {
        $this->path = public_path() . '/parser/cache/';
    }
    
    public function index(Request $request)
    {
        return $this->renderContent(view('admin.me-parser'));
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
        
        $parents = $doc->find('.l-category .col-left .subcatalog .subcatalog_list');
        if(!$parents){
            return back()->with('status', 'Категорий не найдено');
        }
        MeCategory::truncate();
        $categoriesCount = 0;
        foreach ($parents as $parent){
            $parentA = $parent->find('a.subcatalog_title', 0);

            if(!$parentA){
                continue;
            }
            $meCategory = new MeCategory();
            $meCategory->name = trim($parentA->plaintext);
            $meCategory->link = self::URL_MAIN .''. $parentA->href;
            $meCategory->parent_id = 0;
            $meCategory->order = $categoriesCount;
            $meCategory->save();
            $categoriesCount++;

            $subCategories = $parent->find('ul a');
            if(!$subCategories){
                continue;
            }
            foreach($subCategories as $a){
                    MeCategory::create([
                        'name' => trim($a->plaintext),
                        'link' => self::URL_MAIN .''. $a->href,
                        'parent_id' => $meCategory->id,
                        'order' => $categoriesCount
                    ]);
                    $categoriesCount++;
            }
        }
        return back()->with('status', 'Получено категорий '.$categoriesCount);
    }

    public function getProducts(Request $request)
    {
        $streamContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $products = MeProduct::all();
        foreach($products as $product){
            $product->delete();
        }

        $categories = MeCategory::where('parent_id', 0)->get();

        if(!count($categories)){
            return;
        }
        foreach($categories as $category){
            $this->meCategoryId = $category->id;
            $doc = HtmlDomParser::file_get_html( self::URL_CATALOG, false,  stream_context_create($streamContextOptions));
            $uls = $doc->find('ul.subcatalog_items > li.subcatalog_item');
            if($uls){
                foreach ($uls as $ul) {
                    $as = $ul->find('a.subcatalog_link', 0);
                    header('Content-Type: text/html; charset=utf-8');
                    echo "<pre>";
                    var_dump($as);
                    echo "</pre>";
                    die();
                    $order = 0;
                    foreach($as as $a){
                        $link = $a->attr('href');
                        $name = trim($a->text());
                        $parent = $category->id;
                        $laCategory = LaCategory::where('link', $link)->first();
                        if(!$laCategory){
                            LaCategory::create([
                                'name' => $name,
                                'link' => $link,
                                'parent_id' => $parent,
                                'order' => $order,
                            ]);
                            $order++;
                        }

                        $subDoc = hQuery::fromUrl($link);
                        $this->getProductsFromLink($subDoc);
                    }
                }

            }else{
                $this->getProductsFromLink($doc);
            }
        }


        return redirect('admin/parser-me')->with('status', 'Продукты получены');
    }
}

