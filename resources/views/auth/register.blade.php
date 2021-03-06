@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <h1 class="text-center text-white font-weight-bold w-100 fs-32 mb-5">Créez votre compte</h1>
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-lg">
                <div class="card-body p-4 p-sm-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <input id="first_name" type="text" class="px-3 py-4 form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="Prénom" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <input id="last_name" type="text" class="px-3 py-4 form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Nom" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input id="email" type="email" class="px-3 py-4 form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Adresse e-mail" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input id="password" type="password" class="px-3 py-4 form-control @error('password') is-invalid @enderror" name="password" placeholder="Mot de passe" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input id="password-confirm" type="password" class="px-3 py-4 form-control" name="password_confirmation" placeholder="Confirmez le mot de passe" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary font-weight-bold w-100 p-3">Créer un compte</button>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-12 text-center">
                                <p class="text-secondary mb-0">Vous avez déjà un compte ? <a class="text-primary font-weight-bold text-decoration-none" href="{{ route('login') }}">Connectez-vous</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
