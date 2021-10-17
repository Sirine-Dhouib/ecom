<?php

use Illuminate\Database\Seeder;
use App\Product;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
      $productRecords = [
      ['id'=>1,'category_id'=>1,'section_id'=>1,'product_name'=>'T-Shirt Oversize','product_code'=>'TO001','product_color'=>'Black','product_price'=>'35','product_discount'=>1,'product_weight'=>200,'product_video'=>'','main_image'=>'','description'=>'produit test','wash_care'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occasion'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'No','status'=>1],


      ['id'=>2,'category_id'=>1,'section_id'=>1,'product_name'=>'T-Shirt Regular Fit','product_code'=>'TR001','product_color'=>'White','product_price'=>'45','product_discount'=>1,'product_weight'=>200,'product_video'=>'','main_image'=>'','description'=>'produit test','wash_care'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occasion'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'No','status'=>1],


      ['id'=>3,'category_id'=>1,'section_id'=>1,'product_name'=>'T-Shirt debardeur','product_code'=>'TD001','product_color'=>'Pink','product_price'=>'25','product_discount'=>1,'product_weight'=>200,'product_video'=>'','main_image'=>'','description'=>'produit test','wash_care'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occasion'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'No','status'=>1],


      ];
      
      Product::insert($productRecords);


    }
}
