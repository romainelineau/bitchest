@extends('layouts.app')

@section('title')
    Crypto-monnaie {{ $id }}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <h1>{{ $id }} : Cours sur les 30 derniers jours</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($currencyDays),
                datasets: [{
                    label: 'Cours sur les 30 derniers jours',
                    data: @json($currencyPrices),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

@endsection
