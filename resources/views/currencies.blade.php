@extends('master')

@section('title')
    Cours des crypto-monnaies
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Cours des crypto-monnaies</h1>
        </div>
    </div>
    @foreach ($currenciesPrice->RAW as $currency)
    <div class="row">
        <div class="col-3">
            <img class="img-fluid" src="https://www.cryptocompare.com{{ $currency->EUR->IMAGEURL }}">
        </div>
        <div class="col-3">
            <p>{{ $currency->EUR->FROMSYMBOL }}</p>
        </div>
        <div class="col-3">
            <p>{{ $currency->EUR->PRICE }}</p>
        </div>
        <div class="col-3">
            <a class="btn btn-primary" href="currency/{{ $currency->EUR->FROMSYMBOL }}">Voir l'historique</a>
        </div>
    </div>
    @endforeach

@endsection
