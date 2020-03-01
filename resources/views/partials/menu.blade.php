@guest
<nav class="navbar navbar-expand-md navbar-dark bg-primary navbar-fixed-left">
    <a class="navbar-brand" href="{{ url('/') }}">BitChest</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Connexion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Inscription</a>
            </li>
        </ul>
    </div>
</nav>
@else
<div class="container-fluid p-0 m-0">
    <div class="row p-0 m-0">
        <nav id ="navbar-admin" class="col-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <a class="navbar-brand" href="{{ url('/') }}">BitChest</a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('currencies') }}">Marchés</a>
                    </li>
                    @if (Auth::user()->role == 'client')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('wallet.index') }}">Portefeuille</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Utilisateurs</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('account') }}">Compte</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
@endguest
