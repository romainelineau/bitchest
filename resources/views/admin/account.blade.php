@extends('layouts.app')

@section('title')
    Compte
@endsection

@section('content')
    <div class="row bg-light rounded-lg mb-5 px-2 py-3">
        <div class="col-12 d-flex flex-wrap align-items-center">
            <h1 class="text-primary font-weight-bold fs-18 mb-1 w-100">Mon compte</h1>
            <p class="font-weight-bold fs-24 m-0">Modifiez vos informations personnelles</p>
        </div>
    </div>

    @include('admin.users.partials.flash')

    <div class="row mb-3">
        <div class="col-12 col-sm-6 text-center text-sm-left">
            <h2 class="my-3 text-dark">Identité</h2>
            <div class="row text-center text-sm-left bg-white rounded-lg shadow-sm px-4 py-3 mb-3">
                <div class="col-12 px-0"><p><strong>Prénom : </strong>{{ $user->first_name }}</p></div>
                <div class="col-12 px-0"><p><strong>Nom : </strong>{{ $user->last_name }}</p></div>
                <div class="col-12 px-0"><p class="mb-0"><strong>Email : </strong>{{ $user->email }}</p></div>
            </div>
            <a href="{{ route('account/edit') }}" class="btn btn-primary">Modifier mes informations</a>
        </div>
        <div class="col-12 col-sm-6 text-center text-sm-left mt-3 mt-sm-0">
            <h2 class="my-3 text-dark text-center text-sm-left">Mot de passe</h2>
            <a href="{{ route('account/reset-password') }}" class="btn btn-primary">Modifier mon mot de passe</a>
        </div>
    </div>

@endsection
