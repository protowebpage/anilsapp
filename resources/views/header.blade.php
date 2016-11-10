<header>
	<ul>
		@include('customer.profile-links')
	</ul>
	
	<h1 class="title">
		@if (Request::is('/')) prototype
		@else	<a href="{{ url('/') }}">prototype</a>
		@endif
	</h1>
	<p class="tagline">some tagline here</p>
</header>
