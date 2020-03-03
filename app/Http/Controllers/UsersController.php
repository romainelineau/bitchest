<?php

namespace App\Http\Controllers;

use App\User;
use App\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\Balance;

class UsersController extends Controller
{
    use Balance;

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
        $users = User::all();

        $balance = $this->getBalance();

        return view('admin.users.index', ['users' => $users, 'balance' => $balance]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $balance = $this->getBalance();

        return view('admin.users.create', ['balance' => $balance]);
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
        // Si incorrectes, redirection vers la page de création d'un utilisateur
        $this->validate($request, [
            'first_name'  =>  'required|string|between:2,100',
            'last_name'   =>  'required|string|between:2,100',
            'email' =>  'required|regex:/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',
            'password' =>  'required|confirmed|min:8'
        ]);

        // Hash du password avant insertion dans la table
        $request->merge(['password' => Hash::make($request->password)]);
        // Insertion dans la table user
        User::create($request->all());

        // Si tout est ok, redirection vers la page admin users avec message de succès
        return redirect('admin/users')->with('message', 'Utilisateur ajouté !');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $userID = Auth::id();
        $user = User::find($userID);

        $balance = $this->getBalance();

        return view('admin.account', ['user' => $user, 'balance' => $balance]);
    }

    /**
     * Affichage du formulaire d'édition / Accès depuis la page Mon Compte
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAccount()
    {
        $userID = Auth::id();
        $user = User::find($userID);
        $accountEdit = true;

        $balance = $this->getBalance();

        return view('admin.users.edit', ['user' =>  $user, 'balance' => $balance, 'accountEdit' => $accountEdit]);

    }

    /**
     * Mise à jour du compte utilisateur en cours (!! récupération de l'identifiant depuis l'Auth)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAccount(Request $request)
    {
        // Validation des données saisies
        // Si incorrectes, redirection vers la page de mise à jour du user
        $this->validate($request, [
            'first_name'  =>  'required|string|between:2,100',
            'last_name'   =>  'required|string|between:2,100',
            'email' =>  'required|regex:/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',
            'status' =>  'in:client,admin'
        ]);

        // Récupération du user en cours
        // et mise à jour des données dans la table
        $userID = Auth::id();
        $user = User::find($userID);
        $user->update($request->all());

        return redirect('admin/account')->with('message', 'Vos données ont été mises à jour !');
    }

    /**
     * Affichage du formulaire d'édition du mot de passe / Accès depuis la page Mon Compte
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetPassword()
    {
        $userID = Auth::id();
        $user = User::find($userID);

        $balance = $this->getBalance();

        return view('admin.users.resetPassword', ['user' =>  $user, 'balance' => $balance]);

    }

    /**
     * Mise à jour du mot de passe utilisateur en cours (!! récupération de l'identifiant depuis l'Auth)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        // Validation des données saisies
        // Si incorrectes, redirection vers la page de mise à jour du user
        $this->validate($request, [
            'password'  =>  'required|confirmed|min:8'
        ]);

        // Récupération du user en cours
        // hash du mot de passe et mise à jour dans la table
        $userID = Auth::id();
        $user = User::find($userID);
        $user->update(['password' => Hash::make($request->password)]);

        return redirect('admin/account')->with('message', 'Votre mot de passe a été mis à jour !');
    }

    /**
     * Affichage du formulaire d'édition / Accès depuis la page Utilisateurs
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Récupération des données User
        $user = User::find($id);

        $balance = $this->getBalance();

        return view('admin.users.edit', ['user' =>  $user, 'balance' => $balance]);
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
        // Validation des données saisies
        // Si incorrectes, redirection vers la page de mise à jour du user
        $this->validate($request, [
            'first_name'  =>  'required|string|between:2,100',
            'last_name'   =>  'required|string|between:2,100',
            'email' =>  'required|regex:/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',
            'status' =>  'in:client,admin'
        ]);

        // Récupération du user en fonction de son id
        // et mise à jour des données dans la table
        $user = User::find($id);
        $user->update($request->all());

        return redirect('admin/users')->with('message', 'Informations mises à jour !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // On récupère le produit en fonction de son id
        $user = User::find($id);
        $userID = $user->id;

        // On regarde si l'utilisateur a des transactions en cours
        $transactions = Transaction::where('user_id', $userID)->get();

        if (count($transactions) > 0) {

            // Si l'utilisateur a des transactions en cours, on empêche sa suppression
            return redirect('admin/users')->with('alerte', 'Attention ! Vous ne pouvez pas supprimer cet utilisateur car il a des transactions en cours !');
        }
        else {
            // Sinon on le supprimer de la database
            $user->delete();

            return redirect('admin/users')->with('message', 'Utilisateur supprimé !');
        }

    }
}
