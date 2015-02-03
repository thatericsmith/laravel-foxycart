@include('_partials/header')

	<div class="main">

		<form class="form-inline" action="https://{{Config::get('foxycart.store-url')}}.foxycart.com/cart" method="post" accept-charset="utf-8">
		     <input type="hidden" name="name" value="{{Config::get('foxycart.subscription-name')}}">
		     <input type="hidden" name="price" value="{{Config::get('foxycart.subscription-monthly-price')}}">
		     <select class="form-control" name="sub_frequency">
		         <option value="1m">Monthly (${{Config::get('foxycart.subscription-monthly-price')}}/mo)</option>
		         <option value="1y{p:{{Config::get('foxycart.subscription-monthly-price') * 12 * 0.9}}}">Yearly (${{Config::get('foxycart.subscription-monthly-price') * 12 * 0.9}}/yr, save 10%!)</option>
		     </select>
		     <button class="btn btn-primary" type="submit">Subscribe</button>
		</form>

	</div>   

@include('_partials/footer')