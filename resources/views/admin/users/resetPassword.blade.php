@extends('layouts.app')

@section('title')
    Réinitialiser mon mot de passe
@endsection

@section('content')
    <div class="row d-flex flex-wrap align-items-center bg-light rounded-lg my-4 mt-md-0 px-2 py-3">
        <div class="col-12 col-md-10 text-center text-md-left">
            <h1 class="font-weight-bold fs-24 m-0">Réinitialiser mon mot de passe</h1>
        </div>
        <div class="col-12 col-md-2 text-center text-md-right mt-3 mt-md-0">
            <a class="btn btn-outline-primary" href="{{ route('account') }}" role="button">Retour</a>
        </div>
    </div>

    <div class="row d-flex flex-wrap bg-white rounded-lg shadow-sm py-5">

        <form action="{{route('account.updatePassword')}}" method="POST" enctype="multipart/form-data" class="col-12 col-md-8 col-lg-6 m-auto">
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
