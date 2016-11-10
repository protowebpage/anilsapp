<div>
	@foreach ($variations as $variation)
		<div class="e subproduct" data-id="{{ $variation->id }}">
			<a href="#">
				<img src="/storage/uploads/images/variations/{{ $variation->image }}" alt="{{ $variation->name }}">
			</a>
			<h3>{{ $variation->name }}</h3>
		</div>
	@endforeach
</div>