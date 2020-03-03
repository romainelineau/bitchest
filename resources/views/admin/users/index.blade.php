@extends('layouts.app')

@section('title')
    Utilisateurs
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Gestion des utilisateurs</h1>
        </div>
    </div>
    <div class="row mt-4 mb-5">
        <div class="col text-center">
            <a class="btn btn-success" href="{{ route('users.create') }}" role="button">Ajouter</a>
        </div>
    </div>

    @include('admin.users.partials.flash')

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
                    <p>{{ ucfirst($user->role) }}</p>
                </td>
                <td>
                    <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Modifier</a>
                    <form class="delete d-inline-block" method="POST" action="{{route('users.destroy', $user->id)}}">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-outline-secondary" role="button"><i class="fas fa-trash-alt"></i> Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>

@endsection
