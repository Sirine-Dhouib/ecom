@extends('layouts.front_layout.front_layout')
@section('content')



<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Page d'Accueil</a> <span class="divider">/</span></li>
		<li class="active">Connexion</li>
    </ul>
	<h3> Connexion / Inscription</h3>	
	<hr class="soft"/>
	 @if(Session::has('error_message'))
      <div class="alert alert-danger" role="alert" >

        {{ Session::get('error_message') }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        @endif
	
	<div class="row">
		<div class="span4">

             

			<div class="well">
			<h5>CRÉER VOTRE COMPTE</h5>
			Saisissez vos Coordonnèes pour créer un compte.<br/><br/>
			<form id="registerForm" action="{{  url('/register') }}" method="post" >@csrf
				<div class="control-group">
				<label class="control-label" for="name">Nom et Prènom</label>
				<div class="controls">
				  <input class="span3"  type="text" id="name" name="name" placeholder="Taper votre Nom et Prènom">
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="mobile">Numèro de Télèphone</label>
				<div class="controls">
				  <input class="span3"  type="text" id="mobile" name="mobile" placeholder="Taper votre Numèro de Télèphone">
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="email">Adresse E-mail</label>
				<div class="controls">
				  <input class="span3"  type="email" id="email" name="email" placeholder="Taper votre E-mail">
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="password">Mot de Passe</label>
				<div class="controls">
				  <input class="span3"  type="password" id="password" name="password" placeholder="Taper votre Mot de Passe">
				</div>
			  </div>
			  <div class="controls">
			  <button type="submit" class="btn block">Créer votre compte</button>
			  </div>
			</form>
		</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
			<h5>DÉJÀ INSCRIT ?</h5>
			<form id="loginForm" action="{{ url('/login') }}" method="post" >@csrf
			  <div class="control-group">
				<label class="control-label" for="email"> Adresse E-mail</label>
				<div class="controls">
				  <input class="span3"  type="email" id="email" name="email" placeholder="Taper votre E-mail">
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="password">Mot de Passe</label>
				<div class="controls">
				  <input class="span3"  type="password" id="password" name="password" placeholder="Taper votre Mot de Passe">
				</div>
			  </div>
			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">Connectez-vous</button> &emsp;<a href="forgetpass.html">Mot de passe oublié ?</a>
				</div>
			  </div>
			</form>
		</div>
		</div>
	</div>	
	
</div>


@endsection