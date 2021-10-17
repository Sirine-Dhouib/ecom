@extends('layouts.admin_layout.admin_layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Paramètres de l'administrateur</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Page d'accueil</a></li>
              <li class="breadcrumb-item active">Paramètres de l'administrateur</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
         <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Mettre à jour le Mot de Passe de l'administrateur</h3>
                </div>
                <!-- /.card-header -->

                @if(Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 15px;">
          
                  {{ Session::get('error_message') }}
          
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
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



                <!-- form start -->
                <form method="post" action=" {{ url('/admin/update-current-pwd') }} " name = "updatePasswordForm" id="updatePasswordForm">@csrf
                  <div class="card-body">


                  <?php /*  <div class="form-group">
                        <label for="exampleInputEmail1">Nom de l'Administrateur</label>
                        <input  type="text" class="form-control" value="{{ $adminDetails->name }}" placeholder="Entrez le nom de l'administrateur
                        /sous administrateur" id = "admin_name" name = "admin_name">
                      </div> */ ?>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Adresse e-mail</label>
                      <input  class="form-control" value="{{ $adminDetails->email }}" readonly="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Type d'administrateur</label>
                        <input  class="form-control" value="{{ $adminDetails->type }}" readonly="">
                      </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Mot de Passe actuel</label>
                      <input type="password" class="form-control"  name="current_pwd" id="current_pwd" placeholder="Entrez le mot de passe actuel" 
                      required=""> 
                      <span id="checkCurrentPwd"></span>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1"> Nouveau Mot de Passe </label>
                        <input type="password" class="form-control" name="new_pwd" id="new_pwd" placeholder="Entrez le nouveau mot de passe "
                        required="">
                      </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">Confimer Mot de Passe </label>
                        <input type="password" class="form-control" name="confirm_pwd" id="confirm_pwd" placeholder="Confirmez le nouveau mot de passe"
                        required="">
                    </div> 

                    
                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->

  
            </div>
            <!--/.col (left) -->
            
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->




 
  </div>
  <!-- /.content-wrapper -->
  @endsection