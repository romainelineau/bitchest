@extends('layouts.app')

@section('title')
    Transactions
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Achetez dans la crypto-monnaie : {{ $currencyName }} ({{ $currencySymbol }})</h1>
        </div>
    </div>

    <form action="{{route('wallet.store')}}" method="POST" enctype="multipart/form-data" class="col-12">
        {{ csrf_field() }}
        <div class="form-row py-3">
            <div class="form-group col-12 col-md-2">
                <label for="amountInvestment" class="font-weight-bold">Indiquez le montant en euros (€) à investir :</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control w-75" id="amountInvestment" name="amount_investment" value="{{ old('amount_investment') }}" placeholder="Ex : 100.00">
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
        <div class="form-row py-3 d-flex justify-content-center">
            <button type="submit" class="btn btn-primary btn-add-admin font-weight-bold" role="button">Acheter</button>
        </div>
    </form>

@endsection
