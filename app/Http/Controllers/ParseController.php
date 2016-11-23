<?php

namespace App\Http\Controllers;

use duzun\hQuery;
use File;
use DB;
use Illuminate\Support\Facades\Artisan;
use SleepingOwl\Admin\Http\Controllers\AdminController;


class ParseController extends AdminController
{

    protected $path;
    const COUNT = 100;


    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->path = storage_path() . "/app/public/cache";
    }

    //    Получаем рубрики с главной страницы
    public function index()
    {

        hQuery::$cache_path = storage_path() . "/app/public/cache";
        $doc = hQuery::fromUrl('http://av.ru', ['Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.8']);
        $menu = $doc->find('.main-menu__item');
        $i = 0;
        foreach ($menu as $pos => $a) {
            $i = $i + 1;
            echo($i . '---');
            echo($a->attr('data-id') . '-');
            echo($a->find('.main-menu__title') . '<br>');
        }
    }


//    Получаем JSON с рубриками
    public function getHeaderJson()
    {
        $content = file_get_contents("http://av.ru/js-api/menu/header/");
        $data = json_decode($content);
        return $data;
    }

//    Массив рубрик АВ
    public function getAvRubric()
    {
        $data = $this->getHeaderJson();
        foreach ($data->list as $item) {
            $rubric[$item->id] = $item->name . ' ' . $item->subtitle;
        }
        dd($rubric);
    }


//    Наши рубрикии
    public function getRempliRubric()
    {
        $data = \App\Category::all(['id', 'name']);
        foreach ($data as $item) {
            $rubric[$item->id] = $item->name;
        }
        return $rubric;
    }

    public function admin()
    {
        $prod_last_date = 'Необходимо получить категории';
        $prod_diff_count = null;

        $content = file_get_contents("http://av.ru/js-api/menu/header/");
        $data = json_decode($content);
        $h = [];
        foreach ($data->list as $item) {
            $h[] = $item->name . "-[{$item->id}]";
            foreach ($item->submenu as $sitem) {
                foreach ($sitem as $s) {
                    $h[] = $s->name . "-[{$s->id}]";
                }
            }
        }

        // dd($h);
        $avcategory = \App\AvCategory::all('name')->pluck('name')->toArray();
        $cat_now_count = count($h);
        $cat_old_count = count($avcategory);
        $difference = array_merge(array_diff($avcategory, $h), array_diff($h, $avcategory));

        $cat_last_date = \App\AvCategory::all();

        if (!$cat_last_date->isEmpty()) {

            $cat_last_date = $cat_last_date->first()->updated_at->format('d.m.Y');

            $prod_now_count = 0;

            $categories = \App\AvCategory::where('parent_id', '<>', 0)
                ->where('parse', true)
                //->whereIn('id', [12785,12806])
                //->where('total','>',0)
                ->get();

            foreach ($categories as $category) {
                $url = "http://av.ru/js-api/catalog/list/{$category->link}/?expire=15m&user_can_view_alcohol=false&count=1";
                $content = file_get_contents($url);
                $item = json_decode($content);
                $prod_now_count = $prod_now_count + $item->total;

                $category->total = $item->total;
                $category->save();
            }

            $total = \App\AvProduct::count();

            $prod_diff_count = $prod_now_count - $total;

            $prod_last_date = \App\AvProduct::orderBy('updated_at', 'desc')->first();
            if (!$prod_last_date == null)
                $prod_last_date = $prod_last_date->updated_at->format('d.m.Y');
            else
                $prod_last_date = 'Необходимо получить категории';

        } else
            $cat_last_date = 'База пуста';


        return $this->renderContent(view('admin.parser', compact(
            'cat_now_count', 'cat_old_count', 'cat_last_date',
            'prod_now_count', 'prod_diff_count', 'prod_last_date'
        )));
    }


//    Парсинг
    public function gatAllCategory()
    {

        $exitCode = Artisan::call('db:seed', [
            '--class' => 'AvCategoriesTableSeeder'
        ]);
        return redirect()->back()->with('success_message', 'Категории обновленны.');
    }


    public function getTotalItem($category_id = 0)
    {
        $category = \App\AvCategory::find($category_id);
        $url = "http://av.ru/js-api/catalog/list/{$category->link}/?expire=15m&user_can_view_alcohol=false&count=1";

        //$file = $this->path . md5($url) . '.json';
        //if (!file_exists($file)) {
            $content = file_get_contents($url);
            //file_put_contents($file, $content);
//        } else {
  ///          $content = file_get_contents($file);
     //   }

        $data = json_decode($content);
        return $data->total;
    }


//    Получить все продукты заданной категории
    public function getProductOfCategory($av_category_id = 0, $sleep = 0)
    {
        $data = '';
        $category = \App\AvCategory::find($av_category_id);
        $all = [];
        $total = $this->getTotalItem($category->id);
        $file = $this->path . $category->id . "[{$total}].json";
        $category_id = $category->categories->first();
        if (!$category_id == null)
            $category_id = $category_id->id;
        else
            $category_id = 0;

        if (!file_exists($file)) {
            for ($p = 0; $p <= $total / $this::COUNT; $p++) {
                $url = "http://av.ru/js-api/catalog/list/{$category->link}/?p={$p}expire=15m&user_can_view_alcohol=false&count=" . $this::COUNT;
                sleep($sleep);
                $content = file_get_contents($url);
                $data = json_decode($content);
                $all = array_merge($all, $data->list);
            }
        } else {            
            $content = file_get_contents($file);            
            $all = json_decode($content);
        }
       // dd($all);
        file_put_contents($file, json_encode($all));
        foreach ($all as $item) {
            $info = $this->getProductInfo(0, $item->link, true);           

            $e=\App\AvProduct::create([

                    'id' => $item->id,
                    'av_category_id' => $av_category_id,
                    'category_id' => $category_id,
                    'name' => $item->name,
                    'link' => $item->link,
                    'image' => $item->image,
                    'price' => $item->price,
                    'original_price' => $item->original_price,
                    'price_style' => $item->price_style,
                    'original_price_style' => $item->original_price_style,
                    'original_typical_weight' => $item->original_typical_weight,
                    'available_to_order' => $item->available_to_order,
                    'brand' => $item->brand,
                    'ctitles' => $info['ctitles'],
                    'cvalues' => $info['cvalues'],
                    'description' => $info['description'],
                ]
            );

           // echo ($e);
        }
        return $total;
    }

    public function getAllProducts()
    {
        $categories = \App\AvCategory::where('parent_id', '<>', 0)
            ->where('parse', true)
            //->whereIn('id', [12785,12806])
            //->where('total','>',0)
            ->get();
        $total = $categories->sum('total');
        DB::table('av_products')->truncate();
        $status = \App\Status::Create([
            'count' => 0,
            'procent' => 0,
            'status' => 'ok',
            'status_message' => 'Пуск...'
        ]);

        foreach ($categories as $category) {
            $result = $this->getProductOfCategory($category->id);
            $this->saveStatus($status->id, $result, $total, $category->name);
        }

        $this->saveStatus($status->id, $total, $total, 'Готово!');
    }


    public function getProductInfo($id = 0, $link = '', $convert = false)
    {
        if ($id) {
            $product = \App\AvProduct::find($id);
            $link = $product->link;
        }

        $url = "http://av.ru/js-api/catalog/product-detail/{$link}/?expire=1h&user_can_view_alcohol=false";
        $file = $this->path . '/info/' . md5($url) . '.json';
        if (!file_exists($file)) {
            $content = file_get_contents($url);
            file_put_contents($file, $content);
            $data = json_decode($content);
        }
        else
        {
            $content = file_get_contents($file);
            $data = json_decode($content);
        }

        $convert = true;

        if ($convert) {
            $p = $data->properties;



            if($i = $this->isNull($p->item_properties->brand)){
                $ctitles[] = $i->title;
                $cvalues [] = $i->value;
                }

            if($i = $this->isNull($p->item_properties->origin_country)){
                $ctitles[] = $i->title;
                $cvalues [] = $i->value;
            }

            if($i = $this->isNull($p->terms_of_storage_and_consumption->terms_of_storage)){
                $ctitles[] = $i->title;
                $cvalues [] = $i->value;
            }

            if($i = $this->isNull($p->terms_of_storage_and_consumption->terms_of_consumption)){
                $ctitles[] = $i->title;
                $cvalues [] = $i->value;
            }

            if($i = $this->isNull($p->terms_of_storage_and_consumption->shelf_life)){
                $ctitles[] = $i->title;
                $cvalues [] = $i->value;
            }

            if($i = $this->isNull($p->nutrition_facts->caloric_value)){
                $ctitles[] = $i->title;
                $cvalues [] = $i->value;
            }

            if($i = $this->isNull($p->nutrition_facts->proteins)){
                $ctitles[] = $i->title;
                $cvalues [] = $i->value;
            }

            if($i = $this->isNull($p->nutrition_facts->carbohydrates)){
                $ctitles[] = $i->title;
                $cvalues [] = $i->value;
            }

            if($i = $this->isNull($p->product_content_group->product_content)){
                $ctitles[] = $i->title;
                $cvalues [] = $i->value;
            }

            $d['ctitles'] = isset($ctitles) ? implode(';', $ctitles) : '';
            $d['cvalues'] = isset($cvalues) ? implode(';', $cvalues) : '';

            $d['description'] = implode("\n", $data->annotation);

            return $d;
        } else
            return $data;
    }

    protected function isNull($val)
    {
        if (is_null($val->value))
            return false;
        else
            return $val;
    }

    public function status()
    {
        $status = \App\Status::orderBy('updated_at', 'desc')->first();
        return $status;
    }

    protected function saveStatus($id, $count = 1, $total = 0, $message = 'В процессе...')
    {
        $status = \App\Status::find($id);
        $procent = ($status->count + $count) / ($total / 100);
        $status->update(
            [
                'count' => $status->count + $count,
                'procent' => $procent,
                'status' => 'ok',
                'status_message' => $message
            ]
        );
        return $status;
    }

    public function clear()
    {
        $success = File::cleanDirectory($this->path);
        return redirect()->back()->with('success_message', 'Кеш очищен.');
    }


}