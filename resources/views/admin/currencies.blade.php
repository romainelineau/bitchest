@extends('layouts.app')

@section('title')
    Cours des crypto-monnaies
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Cours des crypto-monnaies</h1>
        </div>
    </div>

    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Crypto-monnaie</th>
            <th scope="col">Prix actuel</th>
            <th scope="col">Comp. 24h</th>
            <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($currenciesPrice->RAW as $currency)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>
                    <p><img class="img-fluid currency-logo pr-2" src="https://www.cryptocompare.com{{ $currency->EUR->IMAGEURL }}">

                        @foreach ($currenciesName as $currencyName)
                            @if ($currencyName->initials == $currency->EUR->FROMSYMBOL)
                                {{ $currencyName->name }}
                                <span class="text-secondary">({{ $currencyName->initials }})</span>
                            @endif
                        @endforeach

                    </p>
                </td>
                <td><p>{{ $currency->EUR->PRICE }} €</p></td>
                <td>
                    @if ($currency->EUR->CHANGEPCT24HOUR < 0)
                    <p class="color-red">
                        {{ number_format($currency->EUR->CHANGEPCT24HOUR, 2, '.', ' ') }} %
                    </p>
                    @else
                    <p class="color-green">
                        + {{ number_format($currency->EUR->CHANGEPCT24HOUR, 2, '.', ' ') }} %
                    </p>
                    @endif
                </td>
                <td>
                    <a class="btn btn-outline-primary" href="currency/{{ $currency->EUR->FROMSYMBOL }}">Voir l'historique</a>
                    @if ($user->role == 'client')
                    <a class="btn btn-primary" href="{{ route('buy', $currency->EUR->FROMSYMBOL) }}">Acheter</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>

@endsection
