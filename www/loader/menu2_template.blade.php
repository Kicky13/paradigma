<nav class="secondary_menu add_fix">
	<a href="{{ route('web.home', ['locale' => 'id']) }}" {!! (App::getLocale() == 'id') ? "class='active'": ""!!}>INA</a>
	|
	<a href="{{ route('web.home', ['locale' => 'en']) }}" {!! (App::getLocale() == 'en') ? "class='active'": ""!!}>ENG</a>
	@if (Auth::check())
	<a href="#" class="cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> 0</a>
	<a class="signin dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} &nbsp;<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
	<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="{{ route('web.memberprofile', ['locale' => App::getLocale()]) }}"><span><img src="{{ asset('/public/assets/images/member.png') }}" width="30"></span><b>Lihat Profil</b></a>
			<a class="dropdown-item" href="{{ route('auth.logout', ['locale' => App::getLocale()]) }}"><span><i class="fa fa-sign-out" aria-hidden="true"></i></span>Sign out</a>
	</div>
	@else
	<a href="{{ route('auth.login', ['locale' => App::getLocale()]) }}" class="signin">Sign In</a>
	@endif
	<form action="{{ route('web.search') }}" method="post">
		<input type="text" placeholder="Search">
		<input class="search" type="button" value="">
	</form>
</nav>
