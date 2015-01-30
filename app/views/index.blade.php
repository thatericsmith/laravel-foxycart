<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">

<title>Laravel + Foxycart</title>

<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet"  />
<link href='http://fonts.googleapis.com/css?family=EB+Garamond|Open+Sans:400,700' rel='stylesheet' type='text/css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet"  />

<!-- Favicon -->
<link rel="shortcut icon" href="{{URL::asset('assets/favicon.ico')}}">

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
<div class="container">
	<header>
	<h1>Laravel + Foxycart</h1>
	</header>

	<div class="main">

	<form class="form-inline" action="https://{{Config::get('foxycart.store-url')}}.foxycart.com/cart" method="post" accept-charset="utf-8">
	     <input type="hidden" name="name" value="Subscription">
	     <input type="hidden" name="price" value="25">
	     <select class="form-control" name="sub_frequency">
	         <option value="1m">Monthly ($25/mo)</option>
	         <option value="1y{p:270}">Yearly ($270/yr, save 10%!)</option>
	     </select>
	     <button class="btn btn-primary" type="submit">Subscribe</button>
	</form>


	</div>   

	<footer>
		<div class="copyright">
	    	<p>Built by <a target="_blank" href="http://www.thatericsmith.com">@thatericsmith</a></p>
	    	<div class="cl"></div>
		</div>
	</footer>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="{{URL::asset('assets/js/includes.js')}}"></script>
<script src="//cdn.foxycart.com/{{Config::get('foxycart.store-url')}}/loader.js" async defer></script>
<script src="{{URL::asset('assets/js/site.js')}}"></script>
</body>
</html>