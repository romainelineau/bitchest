<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('admin.transactions.index');
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
        $userID = Auth::id();
        $currencies = Currency::all();

        foreach ($currencies as $currency) {
            if ($currency->initials == $currencySymbol) {
                $currencyID = $currency->id;
                $currencyName = $currency->name;
            }
        }
        return view('admin.transactions.buy', ['currencyID' => $currencyID, 'currencyName' => $currencyName, 'currencySymbol' => $currencySymbol, 'user' => $userID]);
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
            'price' =>  'required|regex:/^([0-9]+)(\.[0-9]{2}){0,1}$/'
        ]);

        // Insertion dans la table transaction
        $transaction = Transaction::create($request->all());
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
}
