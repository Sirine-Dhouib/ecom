
@extends('layouts.front_layout.front_layout')
@section('content')


<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Page d'accueil</a> <span class="divider">/</span></li>
		<li class="active"> Panier d'achat</li>
    </ul>
	<h3>  PANIER D'ACHAT [ <small>3 Article(s) </small>]<a href="products.html" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continuer les achats </a></h3>	
	<hr class="soft"/>
	<table class="table table-bordered">
		<tr><th> JE SUIS DÉJÀ INSCRIT  </th></tr>
		 <tr> 
		 <td>
			<form class="form-horizontal">
				<div class="control-group">
				  <label class="control-label" for="inputUsername">Nom d'utilisateur</label>
				  <div class="controls">
					<input type="text" id="inputUsername" placeholder="Nom d'utilisateur">
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label" for="inputPassword1">Mot de passe</label>
				  <div class="controls">
					<input type="password" id="inputPassword1" placeholder="Mot de passe">
				  </div>
				</div>
				<div class="control-group">
				  <div class="controls">
					<button type="submit" class="btn">Se connecter</button> OU <a href="register.html" class="btn">Inscrivez-vous dès maintenant !</a>
				  </div>
				</div>
				<div class="control-group">
					<div class="controls">
					  <a href="forgetpass.html" style="text-decoration:underline">Mot de passe oublié ?</a>
					</div>
				</div>
			</form>
		  </td>
		  </tr>
	</table>	
	 @if(Session::has('success_message'))
      <div class="alert alert-success" role="alert" >

        {{ Session::get('success_message') }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        @endif

         @if(Session::has('error_message'))
      <div class="alert alert-danger" role="alert" >

        {{ Session::get('error_message') }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        @endif
	
		<div id="AppendCartItems">	
	    @include('front.products.cart_items')
		</div>
		
            <table class="table table-bordered">
			<tbody>
				 <tr>
                  <td> 
				<form class="form-horizontal">
				<div class="control-group">
				<label class="control-label"><strong> CODE PROMO : </strong> </label>
				<div class="controls">
				<input type="text" class="input-medium" placeholder="CODE PROMO">
				<button type="submit" class="btn"> AJOUTER </button>
				</div>
				</div>
				</form>
				</td>
                </tr>
				
			</tbody>
			</table>
			
			<!-- <table class="table table-bordered">
			 <tr><th>ESTIMATE YOUR SHIPPING </th></tr>
			 <tr> 
			 <td>
				<form class="form-horizontal">
				  <div class="control-group">
					<label class="control-label" for="inputCountry">Country </label>
					<div class="controls">
					  <input type="text" id="inputCountry" placeholder="Country">
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="inputPost">Post Code/ Zipcode </label>
					<div class="controls">
					  <input type="text" id="inputPost" placeholder="Postcode">
					</div>
				  </div>
				  <div class="control-group">
					<div class="controls">
					  <button type="submit" class="btn">ESTIMATE </button>
					</div>
				  </div>
				</form>				  
			  </td>
			  </tr>
            </table> -->		
	<a href="products.html" class="btn btn-large"><i class="icon-arrow-left"></i> Continuer les achats </a>
	<a href="login.html" class="btn btn-large pull-right">Suivant <i class="icon-arrow-right"></i></a>
	
</div>


@endsection