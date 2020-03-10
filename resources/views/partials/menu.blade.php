@guest
<nav id ="navbar-guest" class="navbar navbar-fixed d-flex flex-wrap justify-content-center justify-content-sm-between bg-primary px-5 py-4">
    <a class="navbar-brand text-center" href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="BitChest"></a>
    <ul class="d-flex align-items-center list-unstyled mt-4 mt-md-0">
        <li class="">
            <a class="btn bg-white text-primary" href="{{ route('login') }}">Connexion</a>
        </li>
        <li class="ml-2">
            <a class="btn bg-primary text-white" href="{{ route('register') }}">S'inscrire</a>
        </li>
    </ul>
</nav>
@else
<div class="navbar-admin-mobile z-index-1 bg-light d-flex justify-content-between align-items-center px-3">
    <a class="d-block d-lg-none" href="{{ url('/') }}"><img src="{{ asset('images/logo-min-reverse.png') }}" alt="BitChest"></a>
    <button class="toggle-menu d-block d-lg-none text-info bg-none"><i class="fas fa-ellipsis-v"></i></button>
</div>
<nav id ="navbar-admin" class="">
    <div id="navbar-admin-nav" class="bg-light d-none d-lg-flex flex-column justify-content-around justify-content-lg-between align-items-center w-100 h-100 py-4">
        <a class="d-none d-lg-block text-center" href="{{ url('/') }}"><img src="{{ asset('images/logo-min-reverse.png') }}" alt="BitChest"></a>
        <ul class="list-unstyled fs-18">
            <li class="text-center py-3">
                <a class="text-decoration-none fs-16 font-weight-bold text-info {{ (request()->is('admin/currenc*')) ? 'active' : '' }}" href="{{ route('currencies') }}"><i class="fas fa-dollar-sign"></i> Cours actuels</a>
            </li>
            @if (Auth::user()->role == 'client')
            <li class="text-center py-3">
                <a class="text-decoration-none fs-16 font-weight-bold text-info {{ (request()->is('admin/wallet*')) ? 'active' : '' }}" href="{{ route('wallet.index') }}"><i class="fas fa-wallet"></i> Portefeuille</a>
            </li>
            @else
            <li class="text-center py-3">
                <a class="text-decoration-none fs-16 font-weight-bold text-info {{ (request()->is('admin/user*')) ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="fas fa-user-friends"></i> Utilisateurs</a>
            </li>
            @endif
            @if (Auth::user()->role == 'client')
            <p class="balance fs-14 text-center rounded font-weight-bold text-info px-3 py-2 mt-3"><i class="fas fa-university"></i> {{ number_format($balance, 2, ',', ' ') }} €</p>
            @endif
        </ul>
        <ul class="list-unstyled fs-18 font-weight-bold text-info w-100 px-4">
            <li class="text-center py-4">
                <a class="text-decoration-none fs-16 font-weight-bold text-info {{ (request()->is('admin/account*')) ? 'active' : '' }}" href="{{ route('account') }}"><i class="fas fa-user-circle"></i> Mon compte</a>
            </li>
            <li class="text-center border-top pt-4">
                <a class="text-decoration-none fs-16 font-weight-bold text-info" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
@endguest
