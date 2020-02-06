<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect('admin/currencies');
    }

    public function showWallet()
    {
        return view('admin/wallet');
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

        return view('admin/currency',  [
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

        return view('admin/currencies', ['currenciesPrice' => $currenciesPrice]);
    }

    public function showAccount()
    {
        return view('admin/account');
    }

    public function requestAPI($request)
    {
        $client = new Client();
        $response = $client->request('GET', $request);
        $resultAPI = json_decode($response->getBody()->getContents());

        return $resultAPI;
    }
}
