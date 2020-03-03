@extends('layouts.app')

@section('title')
    Compte
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Mon compte</h1>
        </div>
    </div>

    @include('admin.users.partials.flash')

    <div class="row mb-3">
        <div class="col-6">
            <h2 class="my-3">Identité</h2>
            <div class="row">
                <div class="col-12"><p><strong>Prénom : </strong>{{ $user->first_name }}</p></div>
                <div class="col-12"><p><strong>Nom : </strong>{{ $user->last_name }}</p></div>
                <div class="col-12"><p><strong>Email : </strong>{{ $user->email }}</p></div>
                <div class="col-12"><a href="{{ route('account/edit') }}" class="btn btn-primary">Modifier mes informations</a></div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6">
            <h2 class="my-3">Mot de passe</h2>
            <div class="row">
                <div class="col-12"><a href="{{ route('account/reset-password') }}" class="btn btn-primary">Modifier mon mot de passe</a></div>
            </div>
        </div>
    </div>

@endsection
