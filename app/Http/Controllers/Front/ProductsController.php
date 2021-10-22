<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use Session;
use App\Cart;
use Auth;

class ProductsController extends Controller
{
    public function listing(Request $request){

        Paginator::useBootstrap();
        
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $url = $data['url'];
             $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
        if ($categoryCount>0){
            $categoryDetails = Category::catDetails($url);
            $categoryProducts = Product::whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);


            

            // If Fabric Filter selected

            if (isset( $data['fabric'] ) && !empty($data['fabric']) ){


            $categoryProducts->whereIn('products.fabric', $data['fabric']);


            }


            

            // If Sleeve Filter selected

            if (isset( $data['sleeve'] ) && !empty($data['sleeve']) ){


            $categoryProducts->whereIn('products.sleeve', $data['sleeve']);


            }  


            // If Pattern Filter selected

            if (isset( $data['pattern'] ) && !empty($data['pattern']) ){


            $categoryProducts->whereIn('products.pattern', $data['pattern']);


            }  



              // If Fit Filter selected

            if (isset( $data['fit'] ) && !empty($data['fit']) ){


            $categoryProducts->whereIn('products.fit', $data['fit']);


            }  



            // If Occasion Filter selected

            if (isset( $data['occasion'] ) && !empty($data['occasion']) ){


            $categoryProducts->whereIn('products.occasion', $data['occasion']);


            }  


            // If Sort Option selected 

            if (isset( $data['sort'] ) && !empty($data['sort']) ){

                if ($data['sort']=="product_latest"){
                    $categoryProducts->orderBy('id','Desc');
                }else if ($data['sort']=="product_name_a_z"){
                    $categoryProducts->orderBy('product_name','Asc');
                }else if ($data['sort']=="product_name_z_a"){
                    $categoryProducts->orderBy('product_name','Desc');
                }else if ($data['sort']=="price_lowest"){
                    $categoryProducts->orderBy('product_price','Asc');
                }else if ($data['sort']=="price_highest"){
                    $categoryProducts->orderBy('product_price','Desc');
                }

                

            }else{
               
                $categoryProducts->orderBy('id', 'Desc');

            }

            $categoryProducts = $categoryProducts->paginate(70);

            //echo "<pre>"; print_r($categoryDetails); die ; 

          
            
            return view('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProducts' , 'url'));
            
        }else{
            abort(404);
        }


        }else{
             $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
        if ($categoryCount>0){
            $categoryDetails = Category::catDetails($url);
            $categoryProducts = Product::whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
            $categoryProducts = $categoryProducts->paginate(30);
            //echo "<pre>"; print_r($categoryDetails); die ;
            
             
               //Product Filters
          $productFilters = Product::productFilters();
          $fabricArray = $productFilters['fabricArray'];
          $sleeveArray = $productFilters['sleeveArray'];
          $patternArray = $productFilters['patternArray'];
          $fitArray = $productFilters['fitArray'];
          $occasionArray = $productFilters['occasionArray'];

          $page_name="listing";



            return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts' , 'url' ,'fabricArray' , 'sleeveArray' , 'patternArray' ,'fitArray' , 'occasionArray', 'page_name'));
            
        }else{
            abort(404);
        }

        } 

    	
    }

      

      public function detail($id){

        $productDetails = Product::with(['category','attributes'=>function($query){ $query->where('status',1); } ,'images'])->find($id)->toArray();
        //dd($productDetails); die;

         $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');
         $relatedProducts = Product::where('category_id',$productDetails['category']['id'])->where('id', '!=',$id)->limit(3)->inRandomOrder()->get()->toArray();
         //dd($relatedProducts); die;

        return view('front.products.detail')->with(compact('productDetails', 'total_stock','relatedProducts')) ;
      }
       
       
       public function getProductPrice(Request $request){

       if($request->ajax()){

        $data = $request->all();
        //echo "<pre>"; print_r($data); die;
        $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($data['product_id'], $data['size']);

        return $getDiscountedAttrPrice; 

       }

       }


       public function addtocart(Request $request){
        if ($request->isMethod('post')){
          $data = $request->all();
          //echo "<pre>"; print_r($data); die ;

      // Check Product Stock is available or not
          $getProductStock = ProductsAttribute::where(['product_id'=>$data['product_id'], 'size'=>$data['size']])->first()->toArray();
          //echo $getProductStock['stock']; die ;

          if ($getProductStock['stock']<$data['quantity'] ){
            $message = "La quantité requise n'est pas disponible ! ";
            session::flash('error_message',$message);
            return redirect(')->back(');
          }


          //Generate Session Id if not exists
          $session_id = Session::get('session_id');
          if (empty($session_id)){
            $session_id = Session::getId();
            Session::put('session_id',$session_id);
          }

          //Check Product if already exists in User Cart

          if (Auth::check()){
             //User is logged in 
            
             $countProducts = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'],'user_id'=>Auth::user()->id])->count();

          }else{
            //User is not logged in 
              
              $countProducts = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'],'session_id'=>Session::get('session_id')])->count();
          }


           
           if ($countProducts>0){
           $message = "Le Produit existe déjà ! ";
            session::flash('error_message',$message);
            return redirect()->back();



           }

            if (Auth::check()){
              $user_id = Auth::user()->id;
            }else {
              $user_id = 0 ;
            }



        
          //Save Product in Cart

          //Cart::insert(['session_id'=>$session_id,'product_id'=>$data['product_id'], 'size'=>$data['size'], 'quantity'=>$data['quantity'] ]);

          
          $cart = new Cart;
          $cart->session_id = $session_id;
          $cart->user_id = $user_id;
          $cart->product_id = $data['product_id'];
          $cart->size = $data['size'];
          $cart->quantity = $data['quantity'];
          $cart->save();





          $message = "Le produit a été ajouté au panier ! ";
          session::flash('success_message', $message);
          return redirect('cart');







        }
       }



       public function cart(){

        $userCartItems = Cart::userCartItems();
        //echo "<pre>"; print_r($userCartItems); die ;

       return view('front.products.cart')->with(compact('userCartItems')) ;

       }



      public function updateCartItemQty(Request $request){

         if ($request->ajax()){
          $data = $request->all();

          //echo "<pre>"; print_r($data); die;

          //Get Cart Details

          $cartDetails = Cart::find($data['cartid']);

          //Get available Product Store

          $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size']])->first()->toArray();
         

          //Check stock is available or not

          if ($data['qty']>$availableStock['stock'] ){
            $userCartItems = Cart::userCartItems();
            return response()->json([
              'status'=>false,
              'message'=>'Le stock du produit nest pas disponible!',
              'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))

            ]);
          }
          
          //check size available or not
          $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size'] , 'status'=>1])->count();
          if ($availableSize==0){

            $userCartItems = Cart::userCartItems();
            return response()->json([
              'status'=>false,
              'message'=>'La taille du produit nest pas disponible!',
              'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))

            ]);

          }



         
          Cart::where('id', $data['cartid'])->update(['quantity'=>$data['qty']]);
          $userCartItems = Cart::userCartItems();
          return response()->json([
            'status'=>true,
            'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
          ]);
         }


      }

      

      public function deleteCartItem(Request $request){

        if ($request->ajax()){

          $data = $request->all();
          Cart::where('id',$data['cartid'])->delete();
          $userCartItems = Cart::userCartItems();
          return response()->json([
            
            'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))

           ]);
        }
      }









}
