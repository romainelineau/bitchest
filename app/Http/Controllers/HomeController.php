<?php

namespace App\Http\Controllers;

use App\Currency;
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

    public function showCurrency($currencySymbol)
    {
        $request = 'https://min-api.cryptocompare.com/data/v2/histoday?fsym='.$currencySymbol.'&tsym=EUR&limit=30';

        $currencyPrice = $this->requestAPI($request);
        $currencyDays = [];
        $currencyPrices = [];

        foreach ($currencyPrice->Data->Data as $currency) {
            array_push($currencyDays, $currency->time);
            array_push($currencyPrices, $currency->close);
        }

        $currenciesName = Currency::all();

        foreach ($currenciesName as $currencyName) {
            if ($currencyName->initials == $currencySymbol) {
                $currency = $currencyName->name;
            }
        }

        return view('admin/currency',  [
            'currencyDays' => $currencyDays,
            'currencyPrices' => $currencyPrices,
            'currencyPrice' => $currencyPrice,
            'currencyName' => $currency,
            'id' => $currencySymbol
        ]);
    }

    public function showCurrencies()
    {
        $request = 'https://min-api.cryptocompare.com/data/pricemultifull?fsyms=BTC,ETH,XRP,BCH,ADA,LTC,XEM,XLM,MIOTA,DASH&tsyms=EUR';

        $currenciesPrice = $this->requestAPI($request);

        $currenciesName = Currency::all();

        return view('admin/currencies', ['currenciesPrice' => $currenciesPrice, 'currenciesName' => $currenciesName]);
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
