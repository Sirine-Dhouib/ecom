<?php

use Illuminate\Database\Seeder;
use App\Category;
class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords =[

            ['id'=>1,'Parent_id'=>0,'section_id'=>1,'category_name'=>'T-Shirts & Debardeurs','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'t-shirts','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],

            ['id'=>2,'Parent_id'=>1,'section_id'=>1,'category_name'=>'T-Shirts Oversize','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'oversize-t-shirts','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],

             ['id'=>3,'Parent_id'=>1,'section_id'=>1,'category_name'=>'T-Shirts Regular Fit','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'regularfit-t-shirts','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],

            ['id'=>4,'Parent_id'=>1,'section_id'=>1,'category_name'=>'T-Shirts Debardeurs','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'debardeur-t-shirts','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],


            ['id'=>5,'Parent_id'=>0,'section_id'=>2,'category_name'=>'Polos','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'polos','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],

            ['id'=>6,'Parent_id'=>5,'section_id'=>2,'category_name'=>'Polo','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'polo','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],
            

            ['id'=>7,'Parent_id'=>0,'section_id'=>3,'category_name'=>'T-Shirts & Debardeurs','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'t-shirts','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],

            ['id'=>8,'Parent_id'=>7,'section_id'=>3,'category_name'=>'T-Shirts Oversize','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'oversize-t-shirts','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],

            ['id'=>9,'Parent_id'=>0,'section_id'=>4,'category_name'=>'Robes','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'robes','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],

            ['id'=>10,'Parent_id'=>9,'section_id'=>4,'category_name'=>'Robes T-Shirt','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'t-shirt-robes','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],

            ['id'=>11,'Parent_id'=>9,'section_id'=>4,'category_name'=>'Robes Polo','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'polo-robes','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],

            ['id'=>12,'Parent_id'=>0,'section_id'=>2,'category_name'=>'Polos','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'polos','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],

            ['id'=>13,'Parent_id'=>12,'section_id'=>2,'category_name'=>'Polo','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'polo','meta_title'=>'','meta_description'=>'',
            'meta_keywords'=>'','status'=>1],

        ];

        Category::insert($categoryRecords);
    }
}
