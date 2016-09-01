<?php

use Illuminate\Database\Seeder;

class AvCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $content=file_get_contents("http://av.ru/js-api/menu/header/");
        $data=json_decode($content);

        $i=0;
        foreach ($data->list as $item) {


            \App\AvCategory::updateOrCreate(['id' => $item->id],
                [
                    'name' => $item->name,
                    'subtitle' => $item->subtitle,
                    'link' => $item->link,
                    'parent_id' => 0,
                    'order' => $i++

                ]
            );
            foreach ($item->submenu as $sitem) {
                foreach($sitem as $s){
                    \App\AvCategory::updateOrCreate(['id' => $s->id],
                        [
                            'name' => $s->name,
                            'link' => $s->link,
                            'parent_id' => $item->id,
                            'order' => $i++
                        ]
                    );
                }

            }
        }
    }
}


