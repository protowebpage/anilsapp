
	<form action="" type="post" class="form-address">
		<div class="shipping-address row">
			<h4>Shipping Address</h4>
			<div class="col-xs-6">
				<div class="form-group">
					<input name="address1" type="text" class="form-control" id="address1" placeholder="Enter Address">
					<span class="help-block"><strong></strong></span>
				</div>
				@if (Auth::guard('customer')->guest())
					<div class="form-group">
						<input name="email" type="text" class="form-control" placeholder="Your E-mail">
						<span class="help-block"><strong></strong></span>
					</div>		
				@endif
			</div>
			<div class="col-xs-6">
				@if (Auth::guard('customer')->guest())
					<div class="form-group">
						<input name="password" type="password" class="form-control" placeholder="Password">
						<span class="help-block"><strong></strong></span>
					</div>
					<div class="form-group">
						<input name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password">
						<span class="help-block"><strong></strong></span>
					</div>	
				@else
					<p>You're logged in as {{ Auth::guard('customer')->user()->email }}</p>
				@endif
			</div>
		</div>
{{-- 		<div class="paypal">
			<h4>PayPal</h4>
		</div>
 --}}		<button type="submit"><span class="glyphicon glyphicon-ok"></span>Checkout with PayPal</button>
	</form>

