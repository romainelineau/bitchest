@extends('layouts.app')

@section('title')
    Crypto-monnaie {{ $id }}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="text-center">{{ $currencyName }} : Historique du prix (30 derniers jours)</h1>
        </div>
    </div>
    <div class="row mt-4 mb-5">
        <div class="col text-center">
            <a class="btn btn-outline-secondary" href="{{ route('currencies') }}" role="button">Retour</a>
            @if ($user->role == 'client')
            <a class="btn btn-success" href="{{ route('buy', $id) }}" role="button">Acheter</a>
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
    var ctx = document.getElementById('canvasCurrency').getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($currencyDays),
            datasets: [{
                label: 'Prix (€)',
                data: @json($currencyPrices),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        }
    });
</script>

@endsection
