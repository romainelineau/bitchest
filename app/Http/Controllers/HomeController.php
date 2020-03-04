<?php

namespace App\Http\Controllers;

use App\Currency;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Traits\Balance;

class HomeController extends Controller
{
    use Balance;

    /**
     * Nouvelle instance du controller
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Affichage de la page d'accueil /admin/currencies
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Si URL = /admin ou /home, redirection vers /admin/currencies
        return redirect('admin/currencies');
    }

    public function showCurrency($currencySymbol)
    {
        // Requête API
        $request = 'https://min-api.cryptocompare.com/data/v2/histoday?fsym='.$currencySymbol.'&tsym=EUR&limit=30';
        $currencyPrice = $this->requestAPI($request);

        // Initialisation des arrays
        $currencyDays = [];
        $currencyPrices = [];

        // Création des valeurs "Jours" et "Prix du jour" pour générer le graphique
        foreach ($currencyPrice->Data->Data as $currency) {
            array_push($currencyDays, date('d/m', $currency->time));
            array_push($currencyPrices, $currency->close);
        }

        // Récupération des noms des crypto-monnaies
        $currenciesName = Currency::all();

        foreach ($currenciesName as $currencyName) {
            if ($currencyName->initials == $currencySymbol) {
                $currency = $currencyName->name;
            }
        }

        // Données utilisateur
        $userID = Auth::id();
        $user = User::find($userID);

        // Récupération du solde
        $balance = $this->getBalance();

        return view('admin/currency',  [
            'currencyDays' => $currencyDays,
            'currencyPrices' => $currencyPrices,
            'currencyPrice' => $currencyPrice,
            'currencyName' => $currency,
            'id' => $currencySymbol,
            'user' => $user,
            'balance' => $balance
        ]);
    }

    public function showCurrencies()
    {
        // Requête API
        $request = 'https://min-api.cryptocompare.com/data/pricemultifull?fsyms=BTC,ETH,XRP,BCH,ADA,LTC,XEM,XLM,MIOTA,DASH&tsyms=EUR';
        $currenciesPrice = $this->requestAPI($request);

        // Récupération des noms des crypto-monnaies
        $currenciesName = Currency::all();

        // Données utilisateur
        $userID = Auth::id();
        $user = User::find($userID);

        // Récupération du solde
        $balance = $this->getBalance();

        return view('admin/currencies', [
            'currenciesPrice' => $currenciesPrice,
            'currenciesName' => $currenciesName,
            'user' => $user,
            'balance' => $balance
        ]);
    }

    // Fonction d'initialisation de requête API
    public function requestAPI($request)
    {
        $client = new Client();
        $response = $client->request('GET', $request);
        $resultAPI = json_decode($response->getBody()->getContents());

        return $resultAPI;
    }
}
