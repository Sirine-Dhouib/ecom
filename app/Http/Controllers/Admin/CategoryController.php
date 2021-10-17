<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Section;
use Session;
use Image;


class CategoryController extends Controller
{
    public function categories(){
    	Session::put('page','categories');
    	$categories =Category::with(['section','parentcategory'])->get();
    	/*$categories = json_decode(json_encode($categories));
    	echo "<pre>"; print_r($categories); die ;*/
    	return View('admin.categories.categories')->with(compact('categories'));
    }
       
        

       public function updateCategoryStatus(Request $request){

        if($request->ajax()){

        	$data = $request->all();
        	/*echo "<pre>"; print_r($data); die ;*/
        	if($data['status']=="Active"){
        		$status = 0 ;
        	}else{
        		$status = 1 ;
        	}
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }

      public function addEditCategory(Request $request , $id=null){
          //Add Category Functionality
         if ($id==""){
            $title = "Ajouter Categorie";
            $category = new Category;
            $categorydata = array();
            $getCategories = array();
            $message = "Categorie ajoutée avec succès !";
            //Edit Category Functionnality
         }else{
            $title = "Modifier Categorie";
            $categorydata = Category::where('id',$id)->first();
            $categorydata = json_decode(json_encode($categorydata),true);
            $getCategories = Category::with('subcategories')->where (['parent_id'=>0,'section_id'=>$categorydata['section_id']])->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            //echo "<pre>"; print_r($getCategories); die ;
            $category = Category::find($id);
            $message = "Categorie mise a jour avec succès !";
            
         }



         if($request->isMethod('post')){
          $data = $request->all();
          /*echo "<pre>"; print_r($data); die;*/
         //category validations
               $rules = [

                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
                'category_image' => 'image',
                
            ];

            $customMessages = [
                
                 'category_name.required' => "Le nom de la Categorie est obligatoire",
                 'category_name.regex'    => "Un nom de Categorie valide est Obligatoire",
                 'section_id.required' => "Le champs Section est obligatoire",
                 'url.required'    => "L'URL de Categorie est Obligatoire",
                 'category_image.image'    => "Une image de Categorie Valide est Obligatoire",
                 

            ];

            $this->validate($request,$rules,$customMessages);

              //Upload Category  Image
            if ($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if($image_tmp->isValid()){
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate new image name
                    $imageName = rand(111,999999).'.'.$extension;
                    $imagePath ='images/category_images/'.$imageName;
                    //Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                    //save category image
                    $category->category_image = $imageName;
                }
                }

              
          $category->parent_id = $data['parent_id'];
          $category->section_id = $data['section_id'];
          $category->category_name = $data['category_name'];
          //$category->category_image = $data['category_image'];
          $category->category_discount = $data['category_discount'];
          $category->description = $data['description'];
          $category->url = $data['url'];
          $category->meta_title = $data['meta_title'];
          $category->meta_description = $data['meta_description'];
          $category->meta_keywords = $data['meta_keywords'];
          $category->status = 1;
          $category->save(); 
           
           Session::flash('success_message',$message);
           return redirect('admin/categories');

         }
            
         
          //Get All Sections

              $getSections = Section::get();

         return view('admin.categories.add_edit_category')->with(compact('title','getSections','categorydata' , 'getCategories'));


      }
           

         public function appendCategoryLevel(Request $request){
          if ($request->ajax()){
            $data = $request->all();
           /* echo "<pre>" ; print_r($data) ; die ; */
            $getCategories = Category::with('subcategories')->where(['section_id'=>$data['section_id'], 'parent_id'=>0 , 'status'=>1])->get();

            $getCategories = json_decode(json_encode($getCategories),true);
              /*echo "<pre>" ; print_r($getCategories) ;  die ;*/
              return view('admin.categories.append_categories_level')->with(compact('getCategories'));
          }
         }



         public function deleteCategoryImage($id){
          //Get Category Image
          $categoryImage = Category::select('category_image')->where('id',$id)->first();

          //Get Category Image¨Path
          $category_image_path = 'images/category_images/';

          //Delete Category Image from category_images folder if exists
          if (file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
          }

          // Delete Category Image from categories table

          Category::where('id',$id)->update(['category_image' => '']);
           $message= 'Image Categorie a été supprimée avec succès ! ';
           Session::flash('success_message',$message);
           return redirect()->back();
          

          
         }
         

         public function deleteCategory($id){
          //Delete Category
          Category::where('id',$id)->delete();

            $message= 'Categorie a été supprimée avec succès ! ';
           Session::flash('success_message',$message);
           return redirect()->back();


         }
}
