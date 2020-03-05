@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <h1 class="text-center text-white font-weight-bold w-100 fs-32 mb-5">Connectez-vous</h1>
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-lg">
                <div class="card-body p-4 p-sm-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row mb-4">
                            <div class="col-12">
                                <input id="email" type="email" class="px-3 py-4 form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Adresse e-mail" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-12">
                                <input id="password" type="password" class="px-3 py-4 form-control @error('password') is-invalid @enderror" name="password" placeholder="Mot de passe" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Se souvenir de moi</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary font-weight-bold w-100 p-3">Se connecter</button>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-12 text-center">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link mb-3" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                                @endif
                                <p class="text-secondary mb-0">Vous n'avez pas de compte ? <a class="text-primary font-weight-bold text-decoration-none" href="{{ route('register') }}">Inscrivez-vous</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
