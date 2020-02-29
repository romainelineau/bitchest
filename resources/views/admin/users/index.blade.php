@extends('layouts.app')

@section('title')
    Utilisateurs
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Gestion des utilisateurs</h1>
        </div>
    </div>
    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Email</th>
            <th scope="col">Rôle</th>
            <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>
                    <p>{{ $user->last_name }}</p>
                </td>
                <td>
                    <p>{{ $user->first_name }}</p>
                </td>
                <td>
                    <p>{{ $user->email }}</p>
                </td>
                <td>
                    <p>{{ $user->role }}</p>
                </td>
                <td>
                    <a class="btn btn-outline-primary" href="#">Modifier</a>
                    <a class="btn btn-primary" href="#">Supprimer</a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>

@endsection
