@extends('layouts.app')

@section('title')
    Transactions
@endsection

@section('content')
    <div class="row bg-light rounded-lg mb-5 px-2 py-3">
        <div class="col-12 d-flex flex-wrap align-items-center">
            <h1 class="text-primary font-weight-bold fs-18 mb-1 w-100">Acheter des {{ $currencyName }} ({{ $currencySymbol }})</h1>
            <p class="font-weight-bold fs-24 m-0">Investissez dans la crypto-monnaie</p>
        </div>
    </div>

    <div class="row mb-5 px-2 pt-2">
        <div class="col-12 text-center">
            <p class="font-weight-bold text-uppercase text-dark fs-14">Rappel du prix actuel</p>
            <div class="mt-3">
                <p class="font-weight-bold text-dark fs-24 m-0">{{ str_replace('.', ',', $currencyPrice) }} €</p>
                <p class="font-weight-bold text-info fs-18 m-0">
                    @if ($currencyPrice24h < 0)
                    <span class="font-weight-bold m-0 text-danger">
                        {{ number_format($currencyPrice24h, 2, ',', ' ') }} %
                    </span>
                    @else
                    <span class="font-weight-bold m-0 text-success">
                        + {{ number_format($currencyPrice24h, 2, ',', ' ') }} %
                    </span>
                    @endif
                    depuis 24h
                </p>
            </div>
        </div>
    </div>

    <form action="{{route('wallet.store')}}" method="POST" enctype="multipart/form-data" class="col-12 col-md-8 m-auto">
        {{ csrf_field() }}
        <div class="form-row bg-white rounded-lg shadow-sm p-4 mb-4">
            <div class="form-group col-12 text-center">
                <label for="amountInvestment" class="font-weight-bold fs-32">Indiquez le montant en euros (€) à investir :</label>
                <div class="input-group my-2">
                    <input type="text" class="form-control px-3 py-4" id="amountInvestment" name="amount_investment" value="{{ old('amount_investment') }}" placeholder="Ex : 100.00">
                    <div class="input-group-prepend">
                        <div class="input-group-text">€</div>
                    </div>
                </div>
                @if($errors->has('amount_investment'))
                <div class="alert alert-danger mt-2 w-100" role="alert">{{$errors->first('amount_investment')}}</div>
                @endif
            </div>
        </div>
        <input type="hidden" name="currency_id" value="{{ $currencyID }}">
        <div class="form-row d-flex justify-content-center">
            <button type="submit" class="btn btn-primary btn-add-admin font-weight-bold" role="button">Acheter</button>
        </div>
    </form>

@endsection
