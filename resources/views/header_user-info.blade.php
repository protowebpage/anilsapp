
@if (Auth::guard('customer')->check())
	@include('customer.info')
	<ul class="logged-in">
		<li>
			you are <a class="" href="/my/orders"><strong>{{ Auth::guard('customer')->user()->email }}</strong> <span class="glyphicon glyphicon-user"></span></a>
		</li>
		<li>
			<a href="{{ url('/logout') }}"
			onclick="event.preventDefault();
			document.getElementById('logout-form').submit();">
			Logout
			</a>

			<form id="logout-form" action="{{ url('/customer/logout') }}" method="POST" style="display: none;">
			  {{ csrf_field() }}
			</form>
		</li>
	</ul>
@else
	<a href="#" data-toggle="modal" data-target="#modal-log-in">Log in</a>
@endif
