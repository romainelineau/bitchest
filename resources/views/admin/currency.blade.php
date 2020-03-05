@extends('layouts.app')

@section('title')
    Crypto-monnaie {{ $id }}
@endsection

@section('content')

    <div class="row d-flex flex-wrap align-items-center bg-light rounded-lg mb-5 px-2 py-3">
        <div class="col d-flex flex-wrap align-items-center">
            <h1 class="text-primary font-weight-bold fs-18 mb-1 w-100">{{ $currencyName }}</h1>
            <p class="font-weight-bold fs-24 m-0">Historique du prix sur les 30 derniers jours</p>
        </div>
        <div class="col-12 col-sm text-center text-sm-right mt-3 mt-sm-0">
            <a class="btn btn-outline-secondary mr-2" href="{{ route('currencies') }}" role="button">Retour</a>
            @if ($user->role == 'client')
            <a class="btn btn-primary" href="{{ route('buy', $id) }}" role="button">Acheter</a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <canvas id="canvasCurrency" aria-label="Historique du prix pour des {{ $currencyName }}" role="img">
                <p>Historique du prix pour des {{ $currencyName }}</p>
            </canvas>
        </div>
    </div>

@endsection

@section('scripts')

<script>
    $( document ).ready(function() {
        var ctx = document.getElementById('canvasCurrency').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($currencyDays),
                datasets: [{
                    label: 'Prix (€)',
                    data: @json($currencyPrices),
                    backgroundColor: 'rgba(159, 180, 199, 0.2)',
                    borderColor: 'rgba(159, 180, 199, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }],

                }
            }
        });
    });
</script>

@endsection
