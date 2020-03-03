@extends('layouts.app')

@section('title')
    Réinitialiser mon mot de passe
@endsection

@section('content')
    <div class="row mb-5">
        <div class="col-2">
            <a class="btn btn-outline-primary" href="{{ route('account') }}" role="button">Retour</a>
        </div>
        <div class="col-8">
            <h1 class="text-center">Réinitialiser mon mot de passe</h1>
        </div>
    </div>

    <div class="row d-flex flex-wrap">

        <form action="{{route('account.updatePassword')}}" method="POST" enctype="multipart/form-data" class="col-12">
            @method('PUT')
            {{ csrf_field() }}
            <div class="form-row">
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
            </div>
            <div class="form-row py-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-add-admin font-weight-bold" role="button">Modifier mon mot de passe</button>
            </div>
        </form>

    </div>

@endsection
