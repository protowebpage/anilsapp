@if (Auth::guard('customer')->check())
		<li class="profile-link account">
			{{-- you are <a class="" href="/my/orders"><strong>{{ Auth::guard('customer')->user()->email }}</strong> <span class="glyphicon glyphicon-user"></span></a> --}}
			<a class="" href="/my/orders">My account <span class="glyphicon glyphicon-user"></span></a>
		</li>
		<li class="profile-link logout">
			<a href="{{ url('/customer/logout') }}"
			onclick="event.preventDefault();
			document.getElementById('logout-form').submit();">
			Logout
			</a>

			<form id="logout-form" action="{{ url('/customer/logout') }}" method="POST" style="display: none;">
			  {{ csrf_field() }}
			</form>
		</li>
@else
	<li class="profile-link"><a href="#" data-toggle="modal" data-target="#modal-log-in">Log in</a></li>
@endif