<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\Currency;
use App\Transaction;
use App\Http\Traits\Balance;

class TransactionsController extends Controller
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
     * Affichage de la liste des transactions de l'utilisateur
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
        $transactionsSold = Transaction::where('user_id', $userID)->where('sold', true)->orderBy('date_sale', 'desc')->get();
        $currenciesName = Currency::all();

        // Initialisation des variables et arrays
        $totalInvestments = 0; // total des investissements en cours
        $totalSale = 0; // total des montants perçus sur les anciens investissements (après vente)
        $totalPotentialGain = 0; // total des gains des investissements en cours
        $totalGain = 0; // total des gains obtenus après la vente des transactions
        $currenciesPriceNow = []; // tous les cours actuels
        $currenciesPriceSales = []; // tous les cours des ventes effectuées
        $gainInvestments = []; // gains obtenus par transaction

        // Push des données dans les deux arrays
        foreach ($transactions as $transaction) {
            if ($transaction->sold == 0) {
                $totalInvestments = $totalInvestments + $transaction->amount_investment;
            } else {
                $totalSale = $totalSale + $transaction->amount_sale;
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
                    // on push dans un array la valeur du cours associé à l'id de la transaction
                    $currenciesPriceNow += [$transaction->id => $currencyPriceNow];

                    // Array des Gains (transactions en cours / transactions terminées)
                    if ($transaction->sold == 0) {
                        // Calcul des gains pour les transactions en cours
                        $gain = ($currencyPriceNow * $transaction->amount_investment / $transaction->price_currency) - $transaction->amount_investment;
                        // on push dans la variable de total des gains en cours
                        $totalPotentialGain = $totalPotentialGain + $gain;
                        // on push dans un array la valeur du gain associé à l'id de la transaction
                        $gainInvestments += [$transaction->id => number_format($gain, 2, '.', ' ')];
                    } else {
                        // on push dans un array la valeur du cours associé à l'id de la vente
                        $currencyPriceSale = $transaction->amount_sale * $transaction->price_currency / $transaction->amount_investment;
                        $currenciesPriceSales += [$transaction->id => $currencyPriceSale];
                        // Calcul des gains pour les transactions terminées
                        $gain = $transaction->amount_sale - $transaction->amount_investment;
                        $gainInvestments += [$transaction->id => number_format($gain, 2, '.', ' ')];
                    }

                }
            }
        }

        $totalOldInvestments = $totalSale - $totalGain;
        $balance = $totalInvestments + $totalPotentialGain; // solde du compte

        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'transactionsSold' => $transactionsSold,
            'currenciesName' => $currenciesName,
            'currenciesPrice' => $currenciesPrice,
            'currenciesPriceNow' => $currenciesPriceNow,
            'currenciesPriceSales' => $currenciesPriceSales,
            'gainInvestments' => $gainInvestments,
            'totalInvestments' => $totalInvestments,
            'totalOldInvestments' => $totalOldInvestments,
            'totalSale' => $totalSale,
            'totalPotentialGain' => $totalPotentialGain,
            'totalGain' => $totalGain,
            'balance' => $balance
        ]);
    }

    /**
     * Affichage de la page pour effectuer l'achat d'une crypto-monnaie
     *
     * @return \Illuminate\Http\Response
     */
    public function buy($currencySymbol)
    {
        // Récupération des données de la crypto-monnaie
        $request = 'https://min-api.cryptocompare.com/data/pricemultifull?fsyms='.$currencySymbol.'&tsyms=EUR';
        $currencyResult = $this->requestAPI($request);

        // Cours de la crypto-monnaie
        $currencyPrice = $currencyResult->RAW->$currencySymbol->EUR->PRICE;

        // Changement du prix depuis 24h
        $currencyPrice24h = $currencyResult->RAW->$currencySymbol->EUR->CHANGEPCT24HOUR;

        // Nom de la crypto-monnaie (comparaison avec la table currencies)
        $currencies = Currency::all();
        foreach ($currencies as $currency) {
            if ($currency->initials == $currencySymbol) {
                $currencyID = $currency->id;
                $currencyName = $currency->name;
            }
        }

        // Récupération du solde
        $balance = $this->getBalance();

        return view('admin.transactions.buy', [
            'currencyID' => $currencyID,
            'currencyName' => $currencyName,
            'currencySymbol' => $currencySymbol,
            'currencyPrice' => $currencyPrice,
            'currencyPrice24h' => $currencyPrice24h,
            'balance' => $balance
        ]);
    }

    /**
     * Enregistrement d'une transaction en base de données
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
        $amountFormat = $request->amount_investment;

        // Calcul de la quantité de crypto-monnaie achetée par rapport au montant investi
        $quantity = $amountFormat / $currencyPrice;
        $quantityFormat = number_format($quantity, 2, '.', '');

        // Insertion dans la table transaction
        Transaction::create(array_merge($request->all(), [
            'date_purchase' => date('Y-m-d H:i:s'),
            'quantity' => $quantityFormat,
            'price_currency' => $currencyPrice,
            'user_id' => $userID,
            'currency_id' => $currencyID
        ]));

        return redirect()->route('wallet.index')->with('message', 'Transaction effectuée avec succès ! Retrouvez votre investissement dans l\'onglet "Vos actifs".');
    }

    /**
     * Vente de la transaction et enregistrement en BDD
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sell($id)
    {

        // Récupération des données utilisateurs, transaction à vendre et monnaie associée
        $userID = Auth::id();
        $transaction = Transaction::find($id);
        $transactionUserID = $transaction->user_id;

        // Vérification qu'il s'agit bien de l'utilisateur en cours qui fait la vente
        if ($userID == $transactionUserID) {

            // Récupération des initiales de la crypto-monnaie
            $currencyID = $transaction->currency_id;
            $currencyData = Currency::find($currencyID);
            $currencyName = $currencyData->initials; // à utiliser pour l'appel de l'API

            // Récupération du prix actuel de la crypto-monnaie
            $request = 'https://min-api.cryptocompare.com/data/price?fsym='.$currencyName.'&tsyms=EUR';
            $currencyRequest = $this->requestAPI($request);
            $currencyPrice = $currencyRequest->EUR;

            // Calcul du montant de la vente
            $sale = $currencyPrice * $transaction->amount_investment / $transaction->price_currency;

            $transaction->update([
                'date_sale' => date('Y-m-d H:i:s'),
                'amount_sale' => $sale,
                'sold' => true
            ]);

            return redirect()->route('wallet.index')->with('message', 'Vente effectuée ! Retrouvez vos gains dans l\'onglet "Vos ventes".');
        }
        else {

            return redirect()->route('wallet.index')->with('message', 'Vente annulée ! Vous n\'avez pas les droits pour effectuer cette transaction.');
        }

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
