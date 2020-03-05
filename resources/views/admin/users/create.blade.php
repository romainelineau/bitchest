@extends('layouts.app')

@section('title')
    Créer un utilisateur
@endsection

@section('content')
    <div class="row d-flex flex-wrap align-items-center bg-light rounded-lg my-4 mt-md-0 px-2 py-3">
        <div class="col-12 col-md-10 text-center text-md-left">
            <h1 class="font-weight-bold fs-24 m-0">Création d'un utilisateur</h1>
        </div>
        <div class="col-12 col-md-2 text-center text-md-right mt-3 mt-md-0">
            <a class="btn btn-outline-primary" href="{{ route('users.index') }}" role="button">Retour</a>
        </div>
    </div>

    <div class="row d-flex flex-wrap bg-white rounded-lg shadow-sm py-5">

        <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data" class="col-12 col-md-8 col-lg-6 m-auto">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-12 col-sm-6">
                    <input class="form-control form-control-lg" name="first_name" value="{{ old('first_name') }}" type="text" placeholder="Prénom">
                    @if($errors->has('first_name'))
                    <div class="alert alert-danger mt-2" role="alert">{{$errors->first('first_name')}}</div>
                    @endif
                </div>
                <div class="form-group col-12 col-sm-6">
                    <input class="form-control form-control-lg" name="last_name" value="{{ old('last_name') }}" type="text" placeholder="Nom">
                    @if($errors->has('last_name'))
                    <div class="alert alert-danger mt-2" role="alert">{{$errors->first('last_name')}}</div>
                    @endif
                </div>
                <div class="form-group col-12">
                    <input class="form-control form-control-lg" name="email" value="{{ old('email') }}" type="text" placeholder="Email">
                    @if($errors->has('email'))
                    <div class="alert alert-danger mt-2" role="alert">{{$errors->first('email')}}</div>
                    @endif
                </div>
                <div class="form-group col-12">
                    <input class="form-control form-control-lg" name="password" value="{{ old('password') }}" type="password" placeholder="Mot de passe" required autocomplete="new-password">
                    @if($errors->has('password'))
                    <div class="alert alert-danger mt-2" role="alert">{{$errors->first('password')}}</div>
                    @endif
                </div>
                <div class="form-group col-12">
                    <input class="form-control form-control-lg" name="password_confirmation" value="{{ old('password') }}" type="password" placeholder="Confirmez le mot de passe" required autocomplete="new-password">
                    @if($errors->has('password'))
                    <div class="alert alert-danger mt-2" role="alert">{{$errors->first('password')}}</div>
                    @endif
                </div>
                <div class="form-group col-12">
                    <label for="roleUser" class="font-weight-bold">Rôle : </label>
                    <select class="form-control form-control-lg" id="roleUser" name="role">
                        <option value="client"
                            @if(old('role') == 'client')
                            selected
                            @endif
                        >Client</option>
                        <option value="admin"
                            @if(old('role') == 'admin')
                            selected
                            @endif
                        >Admin</option>
                    </select>
                    @if($errors->has('role'))
                    <div class="alert alert-danger mt-2" role="alert">{{$errors->first('role')}}</div>
                    @endif
                </div>
            </div>
            <div class="form-row py-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-add-admin font-weight-bold" role="button">Créer l'utilisateur</button>
            </div>
        </form>

    </div>

@endsection
