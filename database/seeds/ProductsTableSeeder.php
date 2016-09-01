<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = resource_path() . '/json/';
        $categories = 'categories2.json';
        $json = File::get($path . $categories);
        $data = json_decode($json, true);
        foreach ($data as $item) {
            \App\Product::updateOrCreate(['objectId' => $item['objectId']],
                [
                    'objectId'      => $item['objectId'],
                    'category_id'   => \App\Category::where('alias', $item['category'])->first()->category_id,
                    'cvalues'       => implode(", ", $item['cvalues']),
                    'ctitles'       => implode(", ", $item['ctitles']),
                    'img'           => $item['img_sm'],
                    'product_name'  => $item['product_name'],
                    'price'         => $item['price'],
                    'amount'        => $item['amount'],
                    'description'   => $item['description'],
                ]
            );

            // $product->save();

        }
    }
}
