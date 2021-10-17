<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\ProductsAttribute ; 
use App\ProductsImage ; 
use App\Section;
use App\Category;
use Session ;
use Image;
class ProductsController extends Controller
{
    
       
        public function products(){
          Session::put('page','products');
        	$products = Product::with(['category'=>function($query){
            $query->select('id','category_name');
          },'section'=>function($query){
            $query->select('id','name');
          }])->get();
        	/*$products = json_decode(json_encode($products));
        	echo "<pre>"; print_r($products); die ; */
        	return View('admin.products.products')->with(compact('products'));
        }
         


         public function updateProductStatus(Request $request){

        if($request->ajax()){

        	$data = $request->all();
        	/*echo "<pre>"; print_r($data); die ;*/
        	if($data['status']=="Active"){
        		$status = 0 ;
        	}else{
        		$status = 1 ;
        	}
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }

         

          public function deleteProduct($id){
          //Delete Product
          Product::where('id',$id)->delete();

            $message= 'Produit a été supprimé avec succès ! ';
           Session::flash('success_message',$message);
           return redirect()->back();


         }



         public function addEditProduct(Request $request,$id=null){
          if($id==""){
            $title ="Ajouter Produit";
            $product = new Product;
            $productdata = array();
            $message = "Produit ajouté avec succès !";
          }else{
            $title ="Modifier Produit";
            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata) , true);
            $product = Product::find($id);
            $message = "Produit mis a jour avec succès !";
          }


          if ($request->isMethod('post')){
            $data =$request->all();
            //echo "<pre>"; print_r($data); die ;

            // Product Validation 

                   $rules = [

                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
                
                
            ];

            $customMessages = [
                
                 'category_id.required' => "Le nom de la Categorie est obligatoire",
                 'product_name.required' => "Le nom du Produit est obligatoire",
                 'product_name.regex'    => "Un nom de Produit valide est Obligatoire",
                  'product_code.required' => "Le code du Produit est obligatoire",
                 'product_code.regex'    => "Un code de Produit valide est Obligatoire",
                  'product_price.required' => "Le prix du Produit est obligatoire",
                 'product_price.numeric'    => "Un prix de Produit valide est Obligatoire",
                  'product_color.required' => "La couleur du Produit est obligatoire",
                 'product_color.regex'    => "Une couleur de Produit valide est Obligatoire",
                 
                 

            ];

            $this->validate($request,$rules,$customMessages);



            if(empty($data['is_featured'])){

              $is_featured ="No";

            }else{
              $is_featured ="Yes";
            }
            


            //Upload Product Image
            if ($request->hasFile('main_image')){
                $image_tmp = $request->file('main_image');
                if($image_tmp->isValid()){
                    // Get Original Image Name
                    $image_name = $image_tmp->getClientOriginalName();
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Gnerate New Image Name
                    $imageName = $image_name.'-'.rand(111,999999).'.'.$extension;
                    // Get Paths for small,medium and large images
                    $large_image_path ='images/product_images/large/'.$imageName;
                    $medium_image_path ='images/product_images/medium/'.$imageName;
                    $small_image_path ='images/product_images/small/'.$imageName;
                    // Upload Large Image
                    Image::make($image_tmp)->save($large_image_path); // W:1000 H:1000
                    //Upload Medium and Small Images after Resize
                    Image::make($image_tmp)->resize(500,500)->save($medium_image_path);
                    Image::make($image_tmp)->resize(250,250)->save($small_image_path);
                    //save Product Main image in products table
                    $product->main_image = $imageName;
                }
                }
             
             //Upload Product Video

            if ($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                    //Upload Video
                   $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    
                    $videoName = $video_name.'-'.rand().'.'.$extension;
                    $video_path ='videos/product_videos/';
                    $video_tmp->move($video_path,$videoName);
                    // Save Video in products table
                    
                    $product->product_video = $videoName;
                }
                }


            
            // Save product details in product table

            $categoryDetails = Category::find($data['category_id']);
            //echo "<pre>"; print_r($categoryDetails); die ;
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->meta_title = $data['meta_title'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->meta_description = $data['meta_description'];
            $product->is_featured = $is_featured;
            $product->status = 1;
            
            
            $product->save();

            Session::flash('success_message',$message);
           return redirect('admin/products');


          }

          //Product Filters
          $productFilters = Product::productFilters();
          $fabricArray = $productFilters['fabricArray'];
          $sleeveArray = $productFilters['sleeveArray'];
          $patternArray = $productFilters['patternArray'];
          $fitArray = $productFilters['fitArray'];
          $occasionArray = $productFilters['occasionArray'];

          
          //echo "<pre>"; print_r($productFilters); die;
          

          //Sections with Categories and Subcategories

          $categories = Section::with('categories')->get();
          $categories = json_decode(json_encode($categories), true);
         /* echo "<pre>"; print_r($categories); die ; */

          return View('admin.products.add_edit_product')->with(compact('title' , 'fabricArray' , 'sleeveArray' , 'patternArray' ,'fitArray' , 'occasionArray' , 'categories' , 'productdata'));
         }




         public function deleteProductImage($id){
          //Get Product Image
          $productImage = Product::select('main_image')->where('id',$id)->first();

          //Get Product Image¨Path
          $small_image_path = 'images/product_images/small/';
          $medium_image_path = 'images/product_images/medium/';
          $large_image_path = 'images/product_images/large/';

          //Delete Product small Image if exists in small  folder
          if (file_exists($small_image_path.$productImage->main_image)){
            unlink($small_image_path.$productImage->main_image);
          }

           //Delete Product medium Image if exists in small  folder
          if (file_exists($medium_image_path.$productImage->main_image)){
            unlink($medium_image_path.$productImage->main_image);
          }

           //Delete Product large Image if exists in small  folder
          if (file_exists($large_image_path.$productImage->main_image)){
            unlink($large_image_path.$productImage->main_image);
          }

          // Delete Product Image from Products table

          Product::where('id',$id)->update(['main_image' => '']);
           $message= 'Image Produit a été supprimée avec succès ! ';
           Session::flash('success_message',$message);
           return redirect()->back();
          

          
         }



         public function deleteProductVideo($id){
          //Get Product Video
          $productVideo = Product::select('product_video')->where('id',$id)->first();

          //Get Product Video¨Path
          $product_video_path = 'videos/product_videos/';
          

          //Delete Product  Video from products_videos if exists in  folder
          if (file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
          }

          
          // Delete Product Video from Products table

          Product::where('id',$id)->update(['product_video' => '']);


           $message= 'Video Produit a été supprimée avec succès ! ';
           Session::flash('success_message',$message);
           return redirect()->back();
          

          
         }




         public function addAttributes(Request $request,$id){

          if($request->isMethod('post')){

           $data = $request->all();
            //echo "<pre>"; print_r($data); die ; 
            foreach ($data['sku'] as $key => $value){
            
            if (!empty($value)){ 

              // SKU already exists check
              $attrCountSKU = ProductsAttribute::where('sku', $value)->count();
              if ($attrCountSKU>0){

              $message = 'SKU existe déjà. Veuillez en insérer une autre.';
              Session::flash('error_message', $message);
              return redirect()->back();

              }

              // SizeSKU already exists check
              $attrCountSize = ProductsAttribute::where( ['product_id'=>$id, 'size'=>$data['size'][$key] ] )->count();
              if ($attrCountSize>0){

              $message = 'Taille existe déjà. Veuillez en insérer une autre.';
              Session::flash('error_message', $message);
              return redirect()->back();

              }

              $attribute = new ProductsAttribute ;
              $attribute->product_id = $id ;
              $attribute->sku = $value ;
              $attribute->size = $data['size'][$key];
              $attribute->price = $data['price'][$key];
              $attribute->stock = $data['stock'][$key];
              $attribute->status = 1;

              $attribute->save();
            }



            }
          
              
           $success_message = 'Attribut(s) du Produit ajouté(s) avec succès ! ';

              Session::flash('success_message', $success_message);
              return redirect()->back();


          }

         $productdata = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_price', 'main_image')->with('attributes')->find($id);
         $productdata = json_decode(json_encode($productdata),true);
         //echo "<pre>"; print_r($productdata); die ; 
         $title = "Attributs Produits";
         return view('admin.products.add_attributes')->with(compact('productdata' , 'title'));

         }


         public function editAttributes (Request $request, $id){

            if ($request->isMethod('post')){
              $data = $request->all();
             // echo "<pre>"; print_r($data); die ;

              foreach ($data['attrId'] as $key => $attr) {
               
                if (!empty($attr)){

                  ProductsAttribute::where(['id'=>$data['attrId'] [$key]])->update(['price'=>$data['price'][$key] , 'stock'=>$data['stock'][$key]]);
                }


              }

              $success_message = 'Les attributs du produit ont été mis à jour avec succès ! ';

              Session::flash('success_message', $success_message);
              return redirect()->back();
             
             

            }

         }


        

        public function updateAttributeStatus(Request $request){

        if($request->ajax()){

          $data = $request->all();
          /*echo "<pre>"; print_r($data); die ;*/
          if($data['status']=="Active"){
            $status = 0 ;
          }else{
            $status = 1 ;
          }
            ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }





    public function updateImageStatus(Request $request){

        if($request->ajax()){

          $data = $request->all();
          /*echo "<pre>"; print_r($data); die ;*/
          if($data['status']=="Active"){
            $status = 0 ;
          }else{
            $status = 1 ;
          }
            ProductsImage::where('id',$data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
        }
    }



       


        public function deleteAttribute($id){
          //Delete Product
          ProductsAttribute::where('id',$id)->delete();

            $message= ' Attribut Produit a été supprimé avec succès ! ';
           Session::flash('success_message',$message);
           return redirect()->back();


         }




         public function addImages(Request $request ,  $id){


         if ($request->isMethod('post')){
         
          if ($request->hasFile('images')){
             
            $images = $request->file('images');

           // echo "<pre>";  print_r($images); die ; 

            foreach ($images as $key =>$image){
              $productImage = new ProductsImage ; 
              $image_tmp = Image::make($image);
              $extension = $image->getClientOriginalExtension();
              $imageName = rand(111,999999).time().".".$extension;


              // Get Paths for small,medium and large images
                    $large_image_path ='images/product_images/large/'.$imageName;
                    $medium_image_path ='images/product_images/medium/'.$imageName;
                    $small_image_path ='images/product_images/small/'.$imageName;
                    // Upload Large Image
                    Image::make($image_tmp)->save($large_image_path); // W:1040 H:1200
                    //Upload Medium and Small Images after Resize
                    Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                    //save Product Main image in products table
                    $productImage->image = $imageName;
                    $productImage->product_id = $id;
                    $productImage->status = 1 ;
                    $productImage->save();


            }

             $message= ' Image(s) Produit ajoutée(s) avec succès ! ';
           Session::flash('success_message',$message);
             return redirect()->back();
          }
         }

 
         $productdata = Product::with('images')->select('id','product_name','product_code','product_color','main_image')->find($id);
         $productdata = json_decode(json_encode($productdata),true);
         //echo "<pre>"; print_r($productdata); die;
         $title = "Images Produit" ;
         return view('admin.products.add_images')->with(compact('title', 'productdata'));



         }

         
         public function deleteImage($id){
          //Get Product Image
          $productImage = ProductsImage::select('image')->where('id',$id)->first();

          //Get Product Image¨Path
          $small_image_path = 'images/product_images/small/';
          $medium_image_path = 'images/product_images/medium/';
          $large_image_path = 'images/product_images/large/';

          //Delete Product small Image if exists in small  folder
          if (file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
          }

           //Delete Product medium Image if exists in small  folder
          if (file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
          }

           //Delete Product large Image if exists in small  folder
          if (file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
          }

          // Delete Product Image from Products_images table

          ProductsImage::where('id',$id)->delete();
           $message= 'Image Produit a été supprimée avec succès ! ';
           Session::flash('success_message',$message);
           return redirect()->back();
          

          
         }





}
