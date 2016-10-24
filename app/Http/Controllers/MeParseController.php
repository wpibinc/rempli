<?php
namespace App\Http\Controllers;

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
        define('MAX_FILE_SIZE', 6000000);
        set_time_limit(21600); //6 hours
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

        $doc = HtmlDomParser::file_get_html(self::URL_CATALOG, false, stream_context_create($streamContextOptions));
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
//        $doc = HtmlDomParser::file_get_html('https://online.metro-cc.ru/category/produkty/gotovye-bljuda-polufabrikaty/pizza/grecheskie-pirogi-bontier-brecel-picca-130g', false, stream_context_create($streamContextOptions));
//        $price_style = trim(str_replace('ME:', '', preg_replace('/\t+/', "", $doc->find('div.b-product-sidebar-price-info', 0)->plaintext)));
//        dd($price_style);
//        \DB::table('test')->truncate();
        MeProduct::truncate();
        $doc = HtmlDomParser::file_get_html(self::URL_CATALOG, false, stream_context_create($streamContextOptions));
        $uls = $doc->find('div[class=subcatalog cat1]', 0)->find('ul.subcatalog_items > li.subcatalog_item');
        if($uls){
            foreach ($uls as $ul) {
                $as = $ul->find('a.subcatalog_link', 0);
                $sub_doc = HtmlDomParser::file_get_html(self::URL_MAIN .''. $as->href. '?limit=999999999', false, stream_context_create($streamContextOptions));
                $sub_as = $sub_doc->find('.catalog-i_link');
                $category_name = trim($sub_doc->find('ul.horizontal > li.active > a', 0)->plaintext);
                $category = MeCategory::where('name', $category_name)->first();
                foreach ($sub_as as $sub_a) {
//                    \DB::table('test')->insert([
//                        'page' => $sub_a->href,
//                        'created' => Carbon::now()
//                    ]);
                    $meProduct = new MeProduct();
                    $meProduct->link = $sub_a->href;
                    $product_doc = HtmlDomParser::file_get_html($meProduct->link, false, stream_context_create($streamContextOptions));
                    $meProduct->articul = trim($product_doc->find('span[itemprop="productID"]', 0)->plaintext);
                    $meProduct->name = trim($product_doc->find('h1[itemprop="name"]', 0)->plaintext);
                    $meProduct->me_category_id = $category->id;
                    $meProduct->price = trim(str_replace(' ', '', $product_doc->find('.int', 0)->plaintext)) . '.' . trim($product_doc->find('.float', 0)->plaintext);

//                    $price_style = trim(str_replace('ME:', '', preg_replace('/\t+/', '', $doc->find('div.b-product-sidebar-price-info', 0)->plaintext)));
//                    $sep = $product_doc->find('span.sep', 0)->plaintext;
//                    if (strpos($price_style, $sep) !== false) {
//                        $price_style = explode($sep, $price_style)[0];
//                    }
//                    $meProduct->price_style = $price_style;
                    $meProduct->price_style = trim(str_replace('ME:', '', str_replace('\t', '', $product_doc->find('div.b-product-sidebar-price-info', 0)->plaintext)));
                    $meProduct->price_style = trim(str_replace('ME:', '', preg_replace('/\t+/', '', $product_doc->find('div.b-product-sidebar-price-info', 0)->plaintext)));
                    $meProduct->image = $product_doc->find('img[itemprop="image"]', 0) ? trim($product_doc->find('img[itemprop="image"]', 0)->src) : null;
                    $description = $product_doc->find('div.b-product-main__info-descr', 0) ? trim($product_doc->find('div.b-product-main__info-descr', 0)->plaintext) : null;
                    $attrs = $doc->find('ul.b-product-main__info-attrs', 0) ? '<br>' . trim(preg_replace('/\t+/', "", $product_doc->find('ul.b-product-main__info-attrs', 0)->outertext)) : null;
                    $meProduct->description = $description . '' . $attrs;
                    $meProduct->save();
                }
            }
        }


        return redirect('admin/parser-me')->with('status', 'Продукты получены');
    }
}

