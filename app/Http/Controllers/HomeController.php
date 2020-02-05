<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function showWallet()
    {
        return view('wallet');
    }

    public function showCurrency($n)
    {
        $request = 'https://min-api.cryptocompare.com/data/v2/histoday?fsym='.$n.'&tsym=EUR&limit=30';

        $currencyPrice = $this->requestAPI($request);
        $currencyDays = [];
        $currencyPrices = [];

        foreach ($currencyPrice->Data->Data as $currency) {
            array_push($currencyDays, $currency->time);
            array_push($currencyPrices, $currency->close);
        }

        return view('currency',  [
            'currencyDays' => $currencyDays,
            'currencyPrices' => $currencyPrices,
            'currencyPrice' => $currencyPrice,
            'id' => $n
        ]);
    }

    public function showCurrencies()
    {
        $request = 'https://min-api.cryptocompare.com/data/pricemultifull?fsyms=BTC,ETH&tsyms=EUR';

        $currenciesPrice = $this->requestAPI($request);

        return view('currencies', ['currenciesPrice' => $currenciesPrice]);
    }

    public function requestAPI($request)
    {
        $client = new Client();
        $response = $client->request('GET', $request);
        $resultAPI = json_decode($response->getBody()->getContents());

        return $resultAPI;
    }
}
