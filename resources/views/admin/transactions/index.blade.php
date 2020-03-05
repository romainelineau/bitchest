@extends('layouts.app')

@section('title')
    Portefeuille
@endsection

@section('content')
    <div class="row bg-light rounded-lg mb-5 px-2 py-3">
        <div class="col-12 d-flex flex-wrap align-items-center">
            <h1 class="text-primary font-weight-bold fs-18 mb-1 w-100">Mon portefeuille</h1>
            <p class="font-weight-bold fs-24 m-0">Toutes vos transactions (achats et ventes)</p>
        </div>
    </div>

    @include('admin.transactions.partials.flash')

    <div id="transactions">

        <div class="row d-flex justify-content-center mb-5">
            <div class="btn-group" role="group" aria-label="Affichage des actifs et des ventes">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#actifs" aria-expanded="true" aria-controls="actifs">Vos actifs</button>
                <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#ventes" aria-expanded="false" aria-controls="ventes">Vos ventes</button>
            </div>
        </div>

        <div id="actifs" class="collapse show" data-parent="#transactions">

            @php
            if($totalPotentialGain >= 0) {
                $gain = 'success';
            }
            else {
                $gain = 'danger';
            }
            @endphp

            <div class="row rounded-lg bg-white shadow-sm font-weight-bold d-flex justify-content-between align-items-center my-4 px-4 py-3">
                <p class="text-info m-0">Montant investi : <span class="text-dark">{{ number_format($totalInvestments, 2, '.', ' ') }} €</span></p>
                <p class="text-info m-0">Vos gains potentiels : <span class="text-{{ $gain }}">{{ number_format($totalPotentialGain, 2, '.', ' ') }} €</span></p>
                <p class="text-info m-0">
                    Solde : <span class="text-primary">{{ number_format($balance, 2, '.', ' ') }} €</span>
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Montant total de vos actifs incluant vos gains potentiels">
                        <button class="border-0 bg-white text-info p-0 ml-1" style="pointer-events: none;" type="button" disabled><i class="fas fa-question-circle"></i></button>
                    </span>
                </p>
            </div>

        @if(count($transactions) > 0)
            @foreach ($transactions as $transaction)
            @if ($transaction->sold == false)
                <div class="row rounded-lg bg-white shadow-sm my-4 px-2 py-3">
                    <div class="col-12 col-sm-6 col-md-2 d-flex flex-wrap align-items-center font-weight-bold">
                        <p class="text-info text-center text-md-left m-0 w-100">
                            <i class="fas fa-calendar-alt"></i> {{ date('d/m/Y', strtotime($transaction->date_purchase)) }}
                        </p>
                        <p class="text-info text-center text-md-left m-0 w-100">
                            <i class="fas fa-clock"></i> {{ date('h\hi', strtotime($transaction->date_purchase)) }}
                        </p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 d-flex flex-wrap align-items-center mt-4 mt-sm-0">
                        @foreach ($currenciesName as $currencyName)
                            @if ($currencyName->id == $transaction->currency_id)
                                @php
                                    $name = $currencyName->name;
                                    $initials = $currencyName->initials;
                                @endphp
                            @endif
                        @endforeach
                        <p class="text-primary text-center text-md-left font-weight-bold fs-18 m-0 w-100">{{ number_format($transaction->amount_investment, 2, '.', ' ') }} € <span class="text-dark font-weight-normal fs-14">({{ number_format($transaction->quantity, 2, '.', ' ') }} {{ $initials }})</span></p>
                        <p class="text-info text-center text-md-left m-0 w-100">investis en {{ $name }}</p>
                    </div>
                    <div class="col-12 col-sm-4 col-md-2 d-flex flex-wrap align-items-center mt-4 mt-md-0">
                        <p class="text-dark text-center text-md-left font-weight-bold fs-18 m-0 w-100">{{ number_format($transaction->price_currency, 4, '.', ' ') }} €</p>
                        <p class="text-info text-center text-md-left m-0 w-100">prix d'achat</p>
                    </div>
                    <div class="col-12 col-sm-4 col-md-2 d-flex flex-wrap align-items-center mt-4 mt-md-0">
                        <p class="text-dark text-center text-md-left font-weight-bold fs-18 m-0 w-100">{{ number_format($currenciesPriceNow[$transaction->id], 4, '.', ' ') }} €</p>
                        <p class="text-info text-center text-md-left m-0 w-100">prix actuel</p>
                    </div>
                    <div class="col-12 col-sm-4 col-md-2 d-flex flex-wrap align-items-center mt-4 mt-md-0">
                        @if ($gainInvestments[$transaction->id] < 0)
                            @php
                            $gainColor = 'danger';
                            @endphp
                        @else
                            @php
                            $gainColor = 'success';
                            @endphp
                        @endif
                        <p class="text-{{ $gainColor }} text-center text-md-left font-weight-bold fs-18 m-0 w-100">
                            {{ $gainInvestments[$transaction->id] }} €
                        </p>
                        <p class="text-info text-center text-md-left m-0 w-100">vos gains</p>
                    </div>
                    <div class="col-12 col-md-1 d-flex align-items-center justify-content-center justify-content-md-end mt-3 mt-md-0">
                        <button class="btn btn-primary sell-transaction" data-toggle="modal" data-target="#modalTransaction" value="{{ $transaction->id }}">Vendre</button>
                    </div>
                </div>
            @endif
            @endforeach
            @else
                <p>Aucune transaction n'a été effectuée à ce jour. Faîtes votre premier achat !</p>
                <a class="btn btn-primary" href="{{ route('currencies') }}">Acheter</a>
        @endif
        </div>



        <div id="ventes" class="collapse" data-parent="#transactions">

            @php
            if($totalGain >= 0) {
                $gain = 'success';
            }
            else {
                $gain = 'danger';
            }
            @endphp

            <div class="row rounded-lg bg-white shadow-sm font-weight-bold d-flex justify-content-between align-items-center my-4 px-4 py-3">
                <p class="text-info m-0">Montant investi : <span class="text-dark">{{ number_format($totalOldInvestments, 2, '.', ' ') }} €</span></p>
                <p class="text-info m-0">Vos gains : <span class="text-{{ $gain }}">{{ number_format($totalGain, 2, '.', ' ') }} €</span></p>
                <p class="text-info m-0">
                    Montant perçu : <span class="text-primary">{{ number_format($totalSale, 2, '.', ' ') }} €</span>
                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Montant total de vos ventes depuis la création de votre compte">
                        <button class="border-0 bg-white text-info p-0 ml-1" style="pointer-events: none;" type="button" disabled><i class="fas fa-question-circle"></i></button>
                    </span>
                </p>
            </div>

        @if(count($transactions) > 0)
            @foreach ($transactions as $transaction)
            @if ($transaction->sold)
                <div class="row rounded-lg bg-white shadow-sm my-4 px-2 py-3">
                    <div class="col-12 col-sm-6 col-md-2 d-flex flex-wrap align-items-center font-weight-bold">
                        <p class="text-info text-center text-md-left m-0 w-100">
                            <i class="fas fa-calendar-alt"></i> {{ date('d/m/Y', strtotime($transaction->date_sale)) }}
                        </p>
                        <p class="text-info text-center text-md-left m-0 w-100">
                            <i class="fas fa-clock"></i> {{ date('h\hi', strtotime($transaction->date_sale)) }}
                        </p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 d-flex flex-wrap align-items-center mt-4 mt-sm-0">
                        @foreach ($currenciesName as $currencyName)
                            @if ($currencyName->id == $transaction->currency_id)
                                @php
                                    $name = $currencyName->name;
                                    $initials = $currencyName->initials;
                                @endphp
                            @endif
                        @endforeach
                        <p class="text-primary text-center text-md-left font-weight-bold fs-18 m-0 w-100">{{ number_format($transaction->amount_investment, 2, '.', ' ') }} € <span class="text-dark font-weight-normal fs-14">({{ number_format($transaction->quantity, 2, '.', ' ') }} {{ $initials }})</span></p>
                        <p class="text-info text-center text-md-left m-0 w-100">investis en {{ $name }}</p>
                    </div>
                    <div class="col-12 col-sm-4 col-md-2 d-flex flex-wrap align-items-center mt-4 mt-md-0">
                        <p class="text-dark text-center text-md-left font-weight-bold fs-18 m-0 w-100">{{ number_format($transaction->price_currency, 4, '.', ' ') }} €</p>
                        <p class="text-info text-center text-md-left m-0 w-100">prix d'achat</p>
                    </div>
                    <div class="col-12 col-sm-4 col-md-2 d-flex flex-wrap align-items-center mt-4 mt-md-0">
                        <p class="text-dark text-center text-md-left font-weight-bold fs-18 m-0 w-100">{{ number_format($currenciesPriceSales[$transaction->id], 4, '.', ' ') }} €</p>
                        <p class="text-info text-center text-md-left m-0 w-100">prix de vente</p>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 d-flex flex-wrap align-items-center mt-4 mt-md-0">
                        <p class="text-dark text-center text-md-left font-weight-bold fs-18 m-0 w-100">
                            {{ number_format($transaction->amount_sale, 2, '.', ' ') }} €
                            @if ($gainInvestments[$transaction->id] < 0)
                                <span class="text-danger fs-14">({{ $gainInvestments[$transaction->id] }} €)</span>
                            @else
                                <span class="text-success fs-14">(+{{ $gainInvestments[$transaction->id] }} €)</span>
                            @endif
                        </p>
                        <p class="text-info text-center text-md-left m-0 w-100">montant de la vente</p>
                    </div>
                    <div class="col-12 col-md-1 d-flex align-items-center justify-content-center justify-content-md-end mt-3 mt-md-0">
                        <a class="btn btn-outline-primary" href="{{ route('buy', $initials) }}">Racheter</a>
                    </div>
                </div>
            @endif
            @endforeach
            @else
                <p>Aucune vente n'a été effectuée à ce jour. Faîtes votre première vente pour la voir apparaître ici !</p>
                <a class="btn btn-primary" href="{{ route('currencies') }}">Acheter</a>
        @endif

        </div>

    </div>

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

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $('.sell-transaction').on('click', function() {
                $idTransaction = $(this).attr('value');
                $('.confirmation-transaction').attr('href', 'wallet/sell/'+$idTransaction);
            });
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
        });
    </script>

@endsection
