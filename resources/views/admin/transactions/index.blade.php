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

    <div class="row mb-5">
        <div class="col-6">
            <h2 class="my-3">Solde de votre portefeuille</h2>
            <div class="row">
                <div class="col-8"><p>Montant investi : </p></div>
                <div class="col-4"><p>{{ number_format($totalInvestments, 2, '.', ' ') }} €</p></div>
            </div>
            <div class="row">
                <div class="col-8"><p>Vos gains : </p></div>
                <div class="col-4"><p>{{ number_format($totalPotentialGain, 2, '.', ' ') }} €</div>
            </div>
            <div class="row">
                <div class="col-8 font-weight-bold"><p>Solde : </p></div>
                <div class="col-4 font-weight-bold"><p>{{ number_format($balance, 2, '.', ' ') }} €</p></div>
            </div>
        </div>
        <div class="col-6">
            <h2 class="my-3">Total de vos ventes</h2>
            <div class="row">
                <div class="col-8"><p>Montant investi : </p></div>
                <div class="col-4"><p>{{ number_format($totalOldInvestments, 2, '.', ' ') }} €</p></div>
            </div>
            <div class="row">
                <div class="col-8"><p>Gains perçus : </p></div>
                <div class="col-4"><p>{{ number_format($totalGain, 2, '.', ' ') }} €</p></div>
            </div>
            <div class="row">
                <div class="col-8 font-weight-bold"><p>Montant perçu : </p></div>
                <div class="col-4 font-weight-bold"><p>{{ number_format($totalSale, 2, '.', ' ') }} €</p></div>
            </div>
        </div>
    </div>

    @include('admin.transactions.partials.flash')

    <div class="row">
        <div class="col-12">
            <h2>Vos actifs</h2>
        </div>
    </div>

    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">Date d'achat</th>
            <th scope="col">Crypto-monnaie</th>
            <th scope="col">Montant investi</th>
            <th scope="col">Cours à l'achat / Actuel</th>
            <th scope="col">Gain actuel</th>
            <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            @if ($transaction->sold == 0)
            <tr>
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
                <td><p>{{ number_format($transaction->amount_investment, 2, '.', ' ') }} € <span class="text-secondary">({{ number_format($transaction->quantity, 2, '.', ' ') }} {{ $initials }})</span></p></td>
                <td><p>{{ number_format($transaction->price_currency, 2, '.', ' ') }} € / {{ $currenciesPriceNow[$transaction->id] }} €</p></td>
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
                    <button class="btn btn-primary sell-transaction" data-toggle="modal" data-target="#modalTransaction" value="{{ $transaction->id }}">Vendre</button>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="modalTransaction" tabindex="-1" role="dialog" aria-labelledby="modalTransaction" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTransaction">Souhaitez-vous confirmer la vente ?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-footer">
              <a type="button" class="btn btn-secondary text-white" data-dismiss="modal">Non, pas tout de suite</a>
              <a type="button" class="btn btn-primary confirmation-transaction">Oui, je confirme</a>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2>Vos ventes</h2>
        </div>
    </div>

    <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col">Date de la vente</th>
            <th scope="col">Crypto-monnaie</th>
            <th scope="col">Montant investi</th>
            <th scope="col">Cours à l'achat / À la vente</th>
            <th scope="col">Montant de la vente</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            @if ($transaction->sold == 1)
            <tr>
                <td><p>{{ $transaction->date_sale }}</p></td>
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
                <td><p>{{ number_format($transaction->amount_investment, 2, '.', ' ') }} € <span class="text-secondary">({{ number_format($transaction->quantity, 2, '.', ' ') }} {{ $initials }})</span></p></td>
                <td><p>{{ number_format($transaction->price_currency, 2, '.', ' ') }} € / {{ number_format($currenciesPriceSales[$transaction->id], 2, '.', ' ') }} €</p></td>
                <td>
                    <p>{{ number_format($transaction->amount_sale, 2, '.', ' ') }} €
                        @if ($gainInvestments[$transaction->id] < 0)
                            @php
                            $gainColor = 'red';
                            @endphp
                        @else
                            @php
                            $gainColor = 'green';
                            @endphp
                        @endif
                        <span class="color-{{ $gainColor }}">({{ $gainInvestments[$transaction->id] }} €)</span>
                    </p>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $('.sell-transaction').on('click', function() {
                $idTransaction = $(this).attr('value');
                $('.confirmation-transaction').attr('href', 'wallet/sell/'+$idTransaction);
                console.log( $idTransaction );
            })
            console.log( "ready!" );
        });
    </script>

@endsection
