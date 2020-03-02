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

    <div class="row mb-3">
        <div class="col-6">
            <h2 class="my-3">Identité</h2>
            <div class="row">
                <div class="col-12"><p><strong>Prénom : </strong>{{ $user->first_name }}</p></div>
                <div class="col-12"><p><strong>Nom : </strong>{{ $user->last_name }}</p></div>
                <div class="col-12"><p><strong>Email : </strong>{{ $user->email }}</p></div>
                <div class="col-12"><button class="btn btn-primary">Modifier mes informations</button></div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6">
            <h2 class="my-3">Rôle</h2>
            <div class="row">
                <div class="col"><p>{{ ucfirst($user->role) }}</p></div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6">
            <h2 class="my-3">Mot de passe</h2>
            <div class="row">
                <div class="col"><button class="btn btn-primary">Modifier mon mot de passe</button></div>
            </div>
        </div>
    </div>

@endsection
