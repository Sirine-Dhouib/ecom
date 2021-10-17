<?php

use Illuminate\Database\Seeder;
use App\ProductsAttribute;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
       $productsAttributesRecords = [

       [ 'id'=> 1, 'product_id'=> 1,'size'=>'Small', 'price'=>30.0, 'stock'=>10, 'sku'=>'BTO001-S', 'status'=>1 ],


       [ 'id'=> 2, 'product_id'=> 1,'size'=>'Medium', 'price'=>45.0, 'stock'=>20, 'sku'=>'TRF001-M', 'status'=>1 ],

       [ 'id'=> 3, 'product_id'=> 1,'size'=>'Large', 'price'=>35.0, 'stock'=>30, 'sku'=>'RTO001-L', 'status'=>1 ],


       ];


       ProductsAttribute::insert($productsAttributesRecords) ; 

    }
}
