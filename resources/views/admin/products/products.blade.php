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
              <li class="breadcrumb-item active">Produits</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
               
               @if(Session::has('success_message'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 15px;">

        {{ Session::get('success_message') }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        @endif

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tableau des Produits</h3>
                <a href="{{ url('admin/add-edit-product') }}" style="max-width: 150px; float:right; display: inline-block;"  class="btn btn-block btn-success"  >Ajouter Produit</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Nom Produit</th>
                    <th>Code Produit</th>
                    <th>Couleur Produit</th>
                    <th>Image Produit</th>
                    <th>Categorie</th>
                    <th>Section</th>
                    <th>Statut</th>
                    <th>Actions</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  	@foreach($products as $product)
        
                  <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }} </td>
                    <td>{{ $product->product_code }} </td>
                    <td>{{ $product->product_color }} </td>
                    
                    
                    
                    <td>
                      <?php $product_image_path = "images/product_images/small/".$product->main_image; ?>
                      @if (!empty($product->main_image) && file_exists($product_image_path))
                      <img style="width: 120px ;" src="{{ asset('images/product_images/small/'.$product->main_image) }}">
                      @else 
                      <img style="width: 120px ;" src="{{ asset('images/product_images/small/no-image.png') }}">
                      @endif

                     <td>{{ $product->category->category_name }} </td>
                    <td>{{ $product->section->name }} </td>
                    
                    <td>
                     @if ($product->status ==1 )
                    	<a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}"  href="javascript:void(0)">Active</a>
                    	@else 
                    	<a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}"  href="javascript:void(0)">Inactive</a>
                         @endif
                         </td>

                      <td>
                         <a  title="Ajouter/Modifier Attributs" href="{{ url('admin/add-attributes/'.$product->id ) }}" ><i class="fas fa-plus"></i></a> 
                        &nbsp; &nbsp;

                          <a  title="Ajouter Images" href="{{ url('admin/add-images/'.$product->id ) }}" ><i class="fas fa-plus-circle"></i></a> 
                        &nbsp; &nbsp;

                        <a  title="Modifier Produit" href="{{ url('admin/add-edit-product/'.$product->id ) }}"><i class="fas fa-edit"></i></a> 
                        &nbsp; &nbsp;
                        <a  title="Supprimer Produit" href="{{ url('admin/delete-product/'.$product->id ) }}" > <i class="fas fa-trash"></i> </a> 
                        
                      </td>                          
                  </tr>
                  @endforeach
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

@endsection 