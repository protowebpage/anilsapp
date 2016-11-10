@foreach ($products as $product)
	<div class="e product visible" data-id="{{ $product->id }}">
		<a href="#{{ $product->id }}" title="{{ $product->name }}">
			<img src="/storage/uploads/images/products/{{ $product->image }}" alt="{{ $product->name }}">
		</a>
		<h3>{{ $product->name }}</h3>
	</div>
@endforeach