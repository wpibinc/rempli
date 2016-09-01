<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            0    => 'Орехи и масла',
            267  => 'Фрукты и овощи',
            521  => 'Макароны и крупы',
            758  => 'Соль и специи',
            972  => 'Соусы',
            1182 => 'Завтраки и чипсы',
            1372 => 'Консервы',
            1838 => 'Рыба',
            2111 => 'Кулинарея',
            2676 => 'Хлеб',
            2958 => 'Сладости',
            3551 => 'Шоколад',
            3655 => 'Мясные деликатесы',
            3952 => 'Творог и йогурты',
            4117 => 'Чай и кофе',
            4471 => 'Молочные продукты',
            4703 => 'Мясо',
            4875 => 'Печенье',
            5049 => 'Вода и напитки',
            5309 => 'Сыры',
            5538 => 'Соки',
            5720 => 'Замороженные продукты',
            6040 => 'Детское питание'
        ];

        $path = resource_path() . '/json/';
        $file= 'categories.json';
        $json = File::get($path . $file);
        $data = json_decode($json, true);

        foreach ($data as $item) {
            $category[] = $item['category'];
        }
        $u_category = array_unique($category);

        foreach ($u_category as $key =>$value) {
            \App\Category::updateOrCreate(['category_id' => $key],
                [
                    'alias' => $value,
                    'img'   => 'http://rempli.ru/img/types/'. $value .'.png',
                    'name'  =>  $categories[$key]
                ]
            );
        }
    }
}


