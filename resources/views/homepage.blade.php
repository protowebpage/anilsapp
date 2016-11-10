@extends('layouts.frontend')

@section('content')

<section id="app" class="screen1 badaboom"> 
	<p class="e i-would-like-a">I would like a</p>
	<p class="e of-my-design">of my design</p>
	<p class="e made-with">made with</p>
	<p class="e delivered-to">delivered to</p>

	@include('products.homepage_list')

	<div class="subproducts"></div>
	<div class="e upload-zone dropzone" id="design-upload"></div>

	<form method="post" action="" class="e subproduct-properties">
		<div class="form-group">
			<input type="text" class="form-control" name="variation_density" placeholder="Enter density">
			<span class="help-block"><strong></strong></span>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="variation_thickness" placeholder="Enter thickness">
			<span class="help-block"><strong></strong></span>
		</div>

		<button type="submit">Continue</button>
	</form>

	<div class="e file">
		<span class="filename">Filename.txt</span>
	</div>	

	<form method="post" action="" class="e form-comment">
		<textarea name="comment" cols="30" rows="7" placeholder="Enter your text here"></textarea>
		<button type="submit"><span class="glyphicon glyphicon-ok"></span> Confirm</button>
		<button type="reset"><span class="glyphicon glyphicon-repeat"></span> Reset</button>
	</form>

	<div class="e delivered-to-container">
		{{-- loaded via App.prototype.initAddressForm --}}
		{{-- @include('order.credentials') --}}
	</div>

</section>

@endsection
