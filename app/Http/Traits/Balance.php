<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\Currency;
use App\Transaction;

trait Balance {
    public function getBalance() {

        // Récupération des data de l'API
        $request = 'https://min-api.cryptocompare.com/data/pricemultifull?fsyms=BTC,ETH,XRP,BCH,ADA,LTC,XEM,XLM,MIOTA,DASH&tsyms=EUR';
        $currenciesPrice = $this->requestAPI($request);

        // Récupération des données utilisateurs, transactions et monnaies enregistrées
        $userID = Auth::id();
        $transactions = Transaction::where('user_id', $userID)->orderBy('date_purchase', 'desc')->get();
        $currenciesName = Currency::all();

        // Initialisation des variables et arrays
        $totalInvestments = 0; // total des investissements en cours
        $totalPotentialGain = 0; // total des gains des investissements en cours

        // Push des données dans les deux arrays
        foreach ($transactions as $transaction) {
            if ($transaction->sold == 0) {
                $totalInvestments = $totalInvestments + $transaction->amount_investment;
            }
            foreach ($currenciesName as $currency) {
                // on vérifie si l'id de la currency dans la transaction correspond à l'id d'une currency
                if ($transaction->currency_id == $currency->id) {
                    // Array des prix actuels
                    // récupération des initiales pour faire correspondre ensuite avec les data de l'API
                    $currencyInitials = $currency->initials;
                    // on va chercher le cours actuel de la currency correspondante dans l'API
                    $currencyPriceNow = $currenciesPrice->RAW->$currencyInitials->EUR->PRICE;

                    // Array des Gains (transactions en cours / transactions terminées)
                    if ($transaction->sold == 0) {
                        // Calcul des gains pour les transactions en cours
                        $gain = ($currencyPriceNow * $transaction->amount_investment / $transaction->price_currency) - $transaction->amount_investment;
                        // on push dans la variable de total des gains en cours
                        $totalPotentialGain = $totalPotentialGain + $gain;
                    }

                }
            }
        }

        $balance = ($totalInvestments + $totalPotentialGain); // solde du compte

        return $balance;
    }

    // Fonction d'initialisation d'un appel d'API avec Guzzle
    public function requestAPI($request)
    {
        $client = new Client();
        $response = $client->request('GET', $request);
        $resultAPI = json_decode($response->getBody()->getContents());

        return $resultAPI;
    }
}
