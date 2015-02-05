@include('_partials/header')

	<div class="main">
		<div class="row">
			<div class="col-md-6">
				<h1>{{$user->first_name}} {{$user->last_name}}</h1>
				<address>
				{{$user->company}}<br>
				{{$user->address1}} {{$user->address2}}<br>
				{{$user->city}}, {{$user->state}} {{$user->postal_code}} <br>
				{{$user->phone}}<br>
				{{$user->email}}<br>
				</address>
				<p><a class="btn btn-info" href="{{route('account.address')}}">Update address</a></p>
			</div>
			<div class="col-md-6">
				<h2>Payment</h2>
				<p>Card on file:</p>
				<p><strong>****{{$user->last_four}}  Exp. {{$user->exp_month}}/{{$user->exp_year}}</strong></p>
				<p><a class="btn btn-info" href="https://{{Config::get('foxycart.store-url')}}.foxycart.com/cart?cart=updateinfo">Update payment method</a></p>
			</div>
		</div>

		<h2>Transactions</h2>
		<table class="table">
		<thead>
		<tr>
			<th>Order #</th>
			<th>Date</th>
			<th>Total</th>
		</tr>
		</thead>
		{{--
		@foreach($user->transactions() as $transaction)
			<td>{{$transaction->id}}</td>
			<td>{{$transaction->date}}</td>
			<td>{{$transaction->total}}</td>
		@endforeach
		--}}
		</table>
	</div>   

@include('_partials/footer')