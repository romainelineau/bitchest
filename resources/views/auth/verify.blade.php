@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Vérifiez votre adresse email</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">Un lien de vérification vient d'être envoyé à votre adresse email.</div>
                    @endif

                    Avant d'aller plus loin, veuillez vérifiez le mail que nous vous avons envoyé contenant le lien de vérification.
                    Si vous n'avez pas reçu cet email,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Cliquez ici pour en recevoir un nouveau</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
