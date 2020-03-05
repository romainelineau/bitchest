@extends('layouts.app')

@section('title')
    Modifier les informations personnelles
@endsection

@section('content')
    <div class="row d-flex flex-wrap align-items-center bg-light rounded-lg my-4 mt-md-0 px-2 py-3">
        <div class="col-12 col-md-10 text-center text-md-left">
            <h1 class="font-weight-bold fs-24 m-0">Modifier les informations personnelles</h1>
        </div>
        <div class="col-12 col-md-2 text-center text-md-right mt-3 mt-md-0">
            <a class="btn btn-outline-primary" href="
            @if(isset($accountEdit))
            {{ route('account') }}
            @else
            {{ route('users.index') }}
            @endif
            " role="button">Retour</a>
        </div>
    </div>

    <div class="row d-flex flex-wrap bg-white rounded-lg shadow-sm py-5">

        <form action="
            @if(isset($accountEdit))
            {{route('account.update')}}
            @else
            {{route('users.update', $user->id)}}
            @endif
            " method="POST" enctype="multipart/form-data" class="col-12 col-md-8 col-lg-6 m-auto">
            @method('PUT')
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-12 col-sm-6">
                    <input class="form-control form-control-lg" name="first_name" value="{{ $user->first_name }}" type="text" placeholder="Prénom">
                    @if($errors->has('first_name'))
                    <div class="alert alert-danger mt-2" role="alert">{{$errors->first('first_name')}}</div>
                    @endif
                </div>
                <div class="form-group col-12 col-sm-6">
                    <input class="form-control form-control-lg" name="last_name" value="{{ $user->last_name }}" type="text" placeholder="Nom">
                    @if($errors->has('last_name'))
                    <div class="alert alert-danger mt-2" role="alert">{{$errors->first('last_name')}}</div>
                    @endif
                </div>
                <div class="form-group col-12">
                    <input class="form-control form-control-lg" name="email" value="{{ $user->email }}" type="text" placeholder="Email">
                    @if($errors->has('email'))
                    <div class="alert alert-danger mt-2" role="alert">{{$errors->first('email')}}</div>
                    @endif
                </div>
                @if(!isset($accountEdit))
                <div class="form-group col-12">
                    <label for="roleUser" class="font-weight-bold">Rôle : </label>
                    <select class="form-control form-control-lg" id="roleUser" name="role">
                        <option value="client"
                            @if($user->role == 'client')
                            selected
                            @endif
                        >Client</option>
                        <option value="admin"
                            @if($user->role == 'admin')
                            selected
                            @endif
                        >Admin</option>
                    </select>
                    @if($errors->has('role'))
                    <div class="alert alert-danger mt-2" role="alert">{{$errors->first('role')}}</div>
                    @endif
                </div>
                @endif
            </div>
            <div class="form-row py-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-add-admin font-weight-bold" role="button">Mettre à jour</button>
            </div>
        </form>

    </div>

@endsection
