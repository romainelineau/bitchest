<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\Currency;
use App\Transaction;

class TransactionsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $totalGain = 0; // total des gains obtenus après la vente des transactions
        $currenciesPriceNow = []; // tous les cours actuels
        $gainInvestments = []; // gains obtenus par transaction

        // Push des données dans les deux arrays
        foreach ($transactions as $transaction) {
            if ($transaction->sold == 0) {
                $totalInvestments = $totalInvestments + $transaction->amount_investment;
            } else {
                $totalGain = $totalGain + ($transaction->amount_sale - $transaction->amount_investment);
            }
            foreach ($currenciesName as $currency) {
                // on vérifie si l'id de la currency dans la transaction correspond à l'id d'une currency
                if ($transaction->currency_id == $currency->id) {
                    // Array des prix actuels
                    // récupération des initiales pour faire correspondre ensuite avec les data de l'API
                    $currencyInitials = $currency->initials;
                    // on va chercher le cours actuel de la currency correspondante dans l'API
                    $currencyPriceNow = $currenciesPrice->RAW->$currencyInitials->EUR->PRICE;
                    $currencyPriceNowFormat = number_format($currencyPriceNow, 2, '.', ' ');
                    // on push dans un array la valeur du cours associé à l'id de la transaction
                    $currenciesPriceNow += [$transaction->id => $currencyPriceNowFormat];

                    // Array des Gains
                    // calcul du gain obtenu
                    $gain = ($currencyPriceNow * $transaction->amount_investment / $transaction->price_currency) - $transaction->amount_investment;
                    // on push dans la variable de total des gains en cours
                    $totalPotentialGain = $totalPotentialGain + $gain;
                    // on push dans un array la valeur du gain associé à l'id de la transaction
                    $gainInvestments += [$transaction->id => number_format($gain, 2, '.', ' ')];
                }
            }
        }

        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'currenciesName' => $currenciesName,
            'currenciesPrice' => $currenciesPrice,
            'currenciesPriceNow' => $currenciesPriceNow,
            'gainInvestments' => $gainInvestments,
            'totalInvestments' => $totalInvestments,
            'totalPotentialGain' => $totalPotentialGain,
            'totalGain' => $totalGain
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($symbol)
    {
        $symbolCurrency = $symbol;
        return view('admin.transactions.buy', ['symbol' => $symbolCurrency]);
    }

    public function buy($currencySymbol)
    {
        // Récupération des données de la crypto-monnaie
        $request = 'https://min-api.cryptocompare.com/data/pricemultifull?fsyms='.$currencySymbol.'&tsyms=EUR';
        $currencyResult = $this->requestAPI($request);

        // Cours de la crypto-monnaie
        $currencyPrice = $currencyResult->RAW->$currencySymbol->EUR->PRICE;

        // Nom de la crypto-monnaie (comparaison avec la table currencies)
        $currencies = Currency::all();
        foreach ($currencies as $currency) {
            if ($currency->initials == $currencySymbol) {
                $currencyID = $currency->id;
                $currencyName = $currency->name;
            }
        }

        return view('admin.transactions.buy', [
            'currencyID' => $currencyID,
            'currencyName' => $currencyName,
            'currencySymbol' => $currencySymbol,
            'currencyPrice' => $currencyPrice
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données saisies
        // Si incorrectes, redirection vers la page de création de formulaire
        $this->validate($request, [
            'amount_investment' =>  'required|regex:/^([0-9]+)(\.[0-9]{2}){0,1}$/',
            'currency_id' => 'integer'
        ]);

        $userID = Auth::id();
        $currencyID = $request->currency_id;

        // Récupération du cours de la crypto-monnaie
        $currency = Currency::find($currencyID);
        $currencySymbol = $currency->initials;
        $requestAPI = 'https://min-api.cryptocompare.com/data/pricemultifull?fsyms='.$currencySymbol.'&tsyms=EUR';
        $currencyResult = $this->requestAPI($requestAPI);

        $currencyPrice = $currencyResult->RAW->$currencySymbol->EUR->PRICE;
        $currencyPriceFormat = number_format($currencyPrice, 2, '.', '');
        $amountFormat = number_format($request->amount_investment, 2, '.', '');

        // Calcul de la quantité de crypto-monnaie achetée par rapport au montant investi
        $quantity = $amountFormat / $currencyPrice;
        $quantityFormat = number_format($quantity, 2, '.', '');

        // Insertion dans la table transaction
        Transaction::create(array_merge($request->all(), [
            'date_purchase' => date('Y-m-d H:i:s'),
            'quantity' => $quantityFormat,
            'price_currency' => $currencyPriceFormat,
            'sold' => 0,
            'user_id' => $userID,
            'currency_id' => $currencyID
        ]));

        return redirect()->route('wallet.index')->with('message', 'Produit mis à jour !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function requestAPI($request)
    {
        $client = new Client();
        $response = $client->request('GET', $request);
        $resultAPI = json_decode($response->getBody()->getContents());

        return $resultAPI;
    }

}
