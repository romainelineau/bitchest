@extends('layouts.app')

@section('title')
    Utilisateurs
@endsection

@section('content')
    <div class="row bg-light rounded-lg mb-5 px-2 py-3">
        <div class="col-12 d-flex flex-wrap align-items-center">
            <h1 class="text-primary font-weight-bold fs-18 mb-1 w-100">Utilisateurs</h1>
            <p class="font-weight-bold fs-24 m-0">Gérez les données de vos utilisateurs</p>
        </div>
    </div>
    <div class="row mt-4 mb-5">
        <div class="col text-center">
            <a class="btn btn-primary" href="{{ route('users.create') }}" role="button">Ajouter un utilisateur</a>
        </div>
    </div>

    @include('admin.users.partials.flash')

    @foreach ($users as $user)
    <div class="row rounded-lg bg-white shadow-sm my-3 px-2 py-3">
        <div class="col-12 col-sm-6 col-md-2 d-flex flex-wrap align-items-center ">
            <p class="font-weight-bold text-center text-sm-left fs-18 m-0 text-break w-100">{{ $user->last_name }}</p>
            <p class="text-info text-center text-sm-left m-0 w-100">Nom</p>
        </div>
        <div class="col-12 col-sm-6 col-md-2 d-flex flex-wrap align-items-center  mt-3 mt-sm-0">
            <p class="font-weight-bold text-center text-sm-left fs-18 m-0 text-break w-100">{{ $user->first_name }}</p>
            <p class="text-info text-center text-sm-left m-0 w-100">Prénom</p>
        </div>
        <div class="col-12 col-sm-6 col-md-3 d-flex flex-wrap align-items-center mt-3 mt-sm-0">
            <p class="font-weight-bold text-center text-sm-left fs-18 m-0 text-break w-100">{{ $user->email }}</p>
            <p class="text-info text-center text-sm-left m-0 w-100">Email</p>
        </div>
        <div class="col-12 col-sm-6 col-md-2 d-flex flex-wrap align-items-center mt-3 mt-sm-0">
            <p class="font-weight-bold text-center text-sm-left fs-18 m-0 w-100">{{ ucfirst($user->role) }}</p>
            <p class="text-info text-center text-sm-left m-0 w-100">Rôle</p>
        </div>
        <div class="col-12 col-md-3 d-flex flex-wrap align-items-center justify-content-center justify-content-md-end mt-3 mt-md-0">
            <a class="btn btn-dark mr-2 my-1" href="{{ route('users.edit', $user->id) }}"><i class="fas fa-edit"></i> Modifier</a>
            <form class="delete d-inline-block" method="POST" action="{{route('users.destroy', $user->id)}}">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" class="btn btn-outline-secondary my-1" role="button"><i class="fas fa-trash-alt"></i> Supprimer</button>
            </form>
        </div>
    </div>
    @endforeach

@endsection
