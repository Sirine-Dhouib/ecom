<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Rebels' 99</title>
	<link rel="shortcut icon"   type="image" href="https://rebels99.com/wp-content/uploads/2021/05/logo-rebels99.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="csrf-token" content="{{  csrf_token() }}" />
	<!-- Front Awesome -->
     
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous">

	<!-- Front style -->
	<link id="callCss" rel="stylesheet" href="{{ url('css/front_css/front.min.css')}}" media="screen"/>
	<link href="{{ url('css/front_css/base.css')}}" rel="stylesheet" media="screen"/>
	<!-- Front style responsive -->
	<link href="{{ url('css/front_css/front-responsive.min.css')}}" rel="stylesheet"/>
	<link href="{{ url('css/front_css/font-awesome.css')}}" rel="stylesheet" type="text/css">
	<!-- Google-code-prettify -->
	<link href="{{ url('js/front_js/google-code-prettify/prettify.css')}}" rel="stylesheet"/>
	<!-- fav and touch icons -->
	<link rel="shortcut icon" href="{{ asset('images/front_images/ico/favicon.ico')}}">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/front_images/ico/apple-touch-icon-144-precomposed.png')}}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/front_images/ico/apple-touch-icon-114-precomposed.png')}}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/front_images/ico/apple-touch-icon-72-precomposed.png')}}">
	<link rel="apple-touch-icon-precomposed" href="{{ asset('images/front_images/ico/apple-touch-icon-57-precomposed.png')}}">
	<style type="text/css" id="enject"></style>
	<style>
        form.cmxform label.error , label.error {
    /* remove the next line when you have trouble in IE6 with labels in list */
    color: red;
    font-style: italic
     }
     </style>

</head>
<body>
@include('layouts.front_layout.front_header')
<!-- Header End====================================================================== -->
@include ('front.banners.home_page_banners')
<div id="mainBody">
	<div class="container">
		<div class="row">
			@include('layouts.front_layout.front_sidebar')
			
			@yield('content')
		</div>
	</div>
</div>
@include('layouts.front_layout.front_footer')

<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="{{ url('js/front_js/jquery.js')}}" type="text/javascript"></script>
<script src="{{ url('js/front_js/jquery.validate.js')}}" type="text/javascript"></script>
<script src="{{ url('js/front_js/front.min.js')}}" type="text/javascript"></script>
<script src="{{ url('js/front_js/google-code-prettify/prettify.js')}}"></script>

<script src="{{ url('js/front_js/front.js')}}"></script>

<script src="{{ url('js/front_js/front_script.js')}}"></script>

<script src="{{ url('js/front_js/jquery.lightbox-0.5.js')}}"></script>

</body>
</html>