@extends('layouts.admin_layout.admin_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Page d'accueil</a></li>
              <li class="breadcrumb-item active">Categories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      	@if ($errors->any())
    <div class="alert alert-danger" style="margin-top: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
       @endif 

       @if(Session::has('success_message'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 15px;">

        {{ Session::get('success_message') }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        @endif
            
            <form name="categoryForm"  id ="categoryForm" @if(empty($categorydata['id'])) action= "{{ url('admin/add-edit-category') }}"  @else action= "{{ url('admin/add-edit-category/'.$categorydata['id']) }}" @endif
            method="post" enctype="multipart/form-data" >@csrf

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
         
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">

                    
                    <label for="category_name">Nom Categorie</label>
                    <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Entrez Nom Categorie "
                    @if(!empty($categorydata['category_name'])) value="{{ $categorydata['category_name'] }}" @else value="{{ old('category_name') }}" @endif   >
                  </div>
                     
                   <div id="appendCategoriesLevel" >
                  @include('admin.categories.append_categories_level')
                </div>

                  
                
                
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label>Selectionner Section</label>
                  <select name="section_id"  id="section_id" class="form-control select2" style="width: 100%;">
                    <option value="">Selectionner</option>
                    @foreach($getSections as $section)
                    <option value="{{ $section->id }}" @if(!empty($categorydata['section_id']) && $categorydata['section_id']==$section->id) selected @endif >{{ $section->name  }}</option>
                    @endforeach

                  </select>
                </div>

                
                
                <div class="form-group">
                    <label for="exampleInputFile">Image Categorie</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="category_image" name="category_image" >
                        <label class="custom-file-label" for="category_image">Choisir un fichier</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>

                    </div>

                      @if(!empty($categorydata['category_image']))
                      <div ><img style="width:80px; margin-top:5px ; " src="{{ asset('images/category_images/'.$categorydata['category_image']) }}"> &nbsp;  
                         <a href="{{ url('admin/delete-category-image/'.$categorydata['id']  ) }}">
                       Supprimer Image </a></div>
                      
                      @endif
                  </div>
                
              </div>
              
            </div>
          
            
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">

                     <label for="category_discount">Remise Categorie</label>
                    <input type="text" class="form-control" id="category_discount"  name="category_discount" placeholder="Entrez Remise Categorie "  @if(!empty($categorydata['category_discount']))  value="{{$categorydata['category_discount'] }}" @else value="{{ old('category_discount') }}" @endif >
                  </div>
                     

                       <div class="form-group">
                                    
                        <label for="description">Description Categorie</label>
                    <textarea  name="description" id="description" class="form-control" rows="3" placeholder="Entrez Description Categorie ..." > @if(!empty($categorydata['description'])){{ $categorydata['description'] }} @else {{ old('description') }} @endif</textarea>
                  </div>



              </div>
              
              <div class="col-12 col-sm-6">

                <div class="form-group">

                     <label for="url">Url Categorie</label>
                    <input type="text" class="form-control" id="url" name="url" placeholder="Entrez Url Categorie" 
                    @if(!empty($categorydata['url'])) value="{{ $categorydata['url']}}" @else value=" {{ old('url') }}" @endif> 
                  </div>


                 <div class="form-group">        
                     <label for="meta_title">Meta Titre</label>
                    <textarea id="meta_title" name="meta_title" class="form-control" rows="3" placeholder="Entrez Meta Titre ..."> @if(!empty($categorydata['meta_title'])){{ $categorydata['meta_title'] }} @else {{ old('meta_title') }} @endif </textarea>
                  </div>

                
              </div>
             
            </div>

               <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">

                     <label for="meta_description">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" class="form-control" rows="3" placeholder="Entrez Meta Description ..."> @if(!empty($categorydata['meta_description'])){{ $categorydata['meta_description'] }} @else {{ old('meta_description') }} @endif</textarea>
                  </div>
                   



              </div>
              
              <div class="col-12 col-sm-6">
                <div class="form-group">

                     <label for="meta_keywords">Meta Mots Cles</label>
                    <textarea name="meta_keywords" name="meta_keywords" class="form-control" rows="3" placeholder="Entrez Meta Mots Cles ..."> @if(!empty($categorydata['meta_keywords'])){{ $categorydata['meta_keywords'] }} @else {{ old('meta_keywords') }} @endif  
                    </textarea>
                  </div>


                 

                
              </div>
             
            </div>

            
          </div>
          </div>


          <div class="card-footer">
           <button  type="submit" class="btn btn-primary" >Envoyer</button>
          </div>
        </div>
        </form>
        
        
      </div>
      
    </section>
    
  </div>
  
@endsection 