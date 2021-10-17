<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Admin;
use Session;
use Hash ;
use Image;



class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
        return view('admin.admin_dashboard');
    }

    public function settings(){
        Session::put('page','settings');
        /*echo "<pre>"; print_r(Auth::guard('admin')->user()); die ;*/
        $adminDetails = Admin::where('email' , Auth::guard('admin')->user()->email )->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }


    public function login(Request $request){
        if ($request -> isMethod('post')){
            $data=$request -> all();

            /*echo "<pre>";
            print_r($data);
            die;*/

            $rules = [
                
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            
            $customMessages = [
                
                 'email.required' => "L'adresse e-mail est obligatoire",
                 'email.email'    => "Une adresse Email Valide est Obligatoire",
                 'password.required' => "Le mot de passe est obligatoire",

            ];

            $this->validate($request,$rules,$customMessages);


            if (Auth::guard('admin')->attempt(['email'=> $data['email'] , 'password'=> $data['password']] )){
                
                return redirect('admin/dashboard');
            }
            else {
                Session::flash('error_message','Email ou mot de passe invalide');
                return redirect() -> back();
            }

        }
        return view('admin.admin_login');

        }

         public function logout(){
             Auth::guard('admin') -> logout();
             return redirect('/admin');
        
         }
         public function checkCurrentPassword(Request $request){

             $data = $request->all();
             //echo "<pre>"; print_r($data); 
            
             if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
                 echo "Vrai";

             }else{
                 echo "Faux";
             }

         }  

         public function updateCurrentPassword(Request $request){
            if ($request->isMethod('post')){
                 $data=$request->all();
                /* echo "<pre>"; print_r($data); die ;*/
                // check if current password is correct or not
                 if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
                     //check if new and current password are matching
                     if ($data['new_pwd']==$data['confirm_pwd']){
                          
                          Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                          Session::flash('success_message','Le mot de passe a été mis à jour avec succès ! ');

                     } else{
                        Session::flash('error_message','Le nouveau mot de passe et Confirmer mot de passe ne correspondent pas');
                
                     }
                 }else{
                     Session::flash('error_message','Votre mot de passe actuel est incorrect');
                     

                 }
                 return redirect()->back();
             }
         }

          public function updateAdminDetails(Request $request){
            Session::put('page','update-admin-details');
            
              if($request->isMethod('post')){
              	
              $data=$request->all();
           //echo "<pre>"; print_r ($data); die ;

            $rules = [

                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image',
                
            ];

            $customMessages = [
                
                 'admin_name.required' => "Le nom de l'administrateur est obligatoire",
                 'admin_name.alpha'    => "Un nom Valide est Obligatoire",
                 'admin_mobile.required' => "Le numéro de Télèphone est obligatoire",
                 'admin_mobile.numeric'    => "Un numèro de Télèphone Valide est Obligatoire",
                 'admin_image.image'    => "Une image Valide est Obligatoire",
                 
            ];

            $this->validate($request,$rules,$customMessages);


            //Upload Image
            if ($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate new image name
                    $imageName = rand(111,999999).'.'.$extension;
                    $imagePath ='images/admin_images/admin_photos/'.$imageName;
                    //Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                }
                }else if (!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
                }else{
                    $imageName = "";
                }
        
        
            //update Admin Details
            Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image' =>$imageName]);
           session::flash('success_message',"Les détails de l'administrateur ont été mis à jour avec succès ! ");
           return redirect()->back();
        }
            return view('admin.update_admin_details');
          }



    }



