@extends('layouts.app')

@section('title')
    Cours des crypto-monnaies
@endsection

@section('content')
    <div class="row bg-light rounded-lg mb-5 px-2 py-3">
        <div class="col-12 d-flex flex-wrap align-items-center">
            <h1 class="text-primary font-weight-bold fs-18 mb-1 w-100">Cours actuels</h1>
            <p class="font-weight-bold fs-24 m-0">Cours des crypto-monnaies depuis 24h</p>
        </div>
    </div>

    <div class="row d-none d-md-flex">
        <div class="col-4 font-weight-bold text-uppercase text-dark fs-14">Crypto-monnaie</div>
        <div class="col-2 font-weight-bold text-uppercase text-center text-dark fs-14">Prix actuel</div>
        <div class="col-2 font-weight-bold text-uppercase text-center text-dark fs-14">Depuis 24h</div>
        <div class="col-4"></div>
    </div>

    @foreach ($currenciesPrice->RAW as $currency)
    <div class="row rounded-lg bg-white shadow-sm my-3 px-2 py-3">
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center justify-content-center justify-content-sm-start">
            <img class="img-fluid currency-logo mr-3" src="https://www.cryptocompare.com{{ $currency->EUR->IMAGEURL }}">
            @foreach ($currenciesName as $currencyName)
                @if ($currencyName->initials == $currency->EUR->FROMSYMBOL)
                <p class="font-weight-bold fs-18 m-0">{{ $currencyName->name }}</p>
                <p class="text-secondary pl-2 m-0">({{ $currencyName->initials }})</p>
                @endif
            @endforeach
        </div>
        <div class="col-6 col-sm-3 col-md-2 d-flex align-items-center justify-content-end justify-content-sm-center mt-3 mt-sm-0">
            <p class="font-weight-bold m-0">{{ str_replace('.', ',', $currency->EUR->PRICE) }} €</p>
        </div>
        <div class="col-6 col-sm-3 col-md-2 d-flex align-items-center justify-content-start justify-content-sm-center mt-3 mt-sm-0">
            @if ($currency->EUR->CHANGEPCT24HOUR < 0)
            <p class="font-weight-bold m-0 text-danger">
                {{ number_format($currency->EUR->CHANGEPCT24HOUR, 2, ',', ' ') }} %
            </p>
            @else
            <p class="font-weight-bold m-0 text-success">
                + {{ number_format($currency->EUR->CHANGEPCT24HOUR, 2, ',', ' ') }} %
            </p>
            @endif
        </div>
        <div class="col-12 col-md-4 d-flex align-items-center justify-content-center justify-content-md-end mt-3 mt-md-0">
            @if ($user->role == 'client')
            <a class="btn btn-primary mx-2" href="{{ route('buy', $currency->EUR->FROMSYMBOL) }}">Acheter</a>
            @endif
            <a class="btn btn-outline-secondary" href="currency/{{ $currency->EUR->FROMSYMBOL }}">Historique</a>
        </div>
    </div>
    @endforeach

@endsection
