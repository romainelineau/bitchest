@extends('layouts.app')

@section('title')
    Portefeuille
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Mon portefeuille</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <h2>Investissements en cours</h2>
            <p>{{ number_format($totalInvestments, 2, '.', ' ') }} €</p>
        </div>
        <div class="col-4">
            <h2>Gains en cours</h2>
            <p>{{ number_format($totalPotentialGain, 2, '.', ' ') }} €</p>
        </div>
        <div class="col-4">
            <h2>Total des gains récupérés</h2>
            <p>{{ number_format($totalGain, 2, '.', ' ') }} €</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2>En cours</h2>
        </div>
    </div>

    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Date</th>
            <th scope="col">Crypto-monnaie</th>
            <th scope="col">Montant investi</th>
            <th scope="col">Quantité</th>
            <th scope="col">Cours à l'achat</th>
            <th scope="col">Cours actuel</th>
            <th scope="col">Gain</th>
            <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            @if ($transaction->sold == 0)
            <tr>
                <th scope="row">{{ $transaction->id }}</th>
                <td><p>{{ $transaction->date_purchase }}</p></td>
                <td>
                    <p>
                        @foreach ($currenciesName as $currencyName)
                            @if ($currencyName->id == $transaction->currency_id)
                                {{ $currencyName->name }}
                                @php
                                    $initials = $currencyName->initials;
                                @endphp
                            @endif
                        @endforeach
                    </p>
                </td>
                <td><p>{{ number_format($transaction->amount_investment, 2, '.', ' ') }} €</p></td>
                <td><p>{{ number_format($transaction->quantity, 2, '.', ' ') }} {{ $initials }}</p></td>
                <td><p>{{ number_format($transaction->price_currency, 2, '.', ' ') }} €</p></td>
                <td><p>{{ $currenciesPriceNow[$transaction->id] }} €</p></td>
                <td>
                    @if ($gainInvestments[$transaction->id] < 0)
                        @php
                        $gainColor = 'red';
                        @endphp
                    @else
                        @php
                        $gainColor = 'green';
                        @endphp
                    @endif
                    <p class="color-{{ $gainColor }}">
                        {{ $gainInvestments[$transaction->id] }} €
                    </p>
                </td>
                <td>
                    @if ($transaction->sold == 0)
                    <a class="btn btn-primary" href="#">Vendre</a>
                    @else
                    <a class="btn btn-primary disabled" href="#">Vendu</a>
                    @endif

                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col-12">
            <h2>Terminés</h2>
        </div>
    </div>

    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Date d'achat</th>
            <th scope="col">Crypto-monnaie</th>
            <th scope="col">Montant investi</th>
            <th scope="col">Quantité</th>
            <th scope="col">Cours à l'achat</th>
            <th scope="col">Date de la vente</th>
            <th scope="col">Gain obtenu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            @if ($transaction->sold == 1)
            <tr>
                <th scope="row">{{ $transaction->id }}</th>
                <td><p>{{ $transaction->date_purchase }}</p></td>
                <td>
                    <p>
                        @foreach ($currenciesName as $currencyName)
                            @if ($currencyName->id == $transaction->currency_id)
                                {{ $currencyName->name }}
                                @php
                                    $initials = $currencyName->initials;
                                @endphp
                            @endif
                        @endforeach
                    </p>
                </td>
                <td><p>{{ number_format($transaction->amount_investment, 2, '.', ' ') }} €</p></td>
                <td><p>{{ number_format($transaction->quantity, 2, '.', ' ') }} {{ $initials }}</p></td>
                <td><p>{{ number_format($transaction->price_currency, 2, '.', ' ') }} €</p></td>
                <td><p>Date</p></td>
                <td>
                    @if ($gainInvestments[$transaction->id] < 0)
                        @php
                        $gainColor = 'red';
                        @endphp
                    @else
                        @php
                        $gainColor = 'green';
                        @endphp
                    @endif
                    <p class="color-{{ $gainColor }}">
                        {{ $gainInvestments[$transaction->id] }} €
                    </p>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

@endsection
