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
     * Nouvelle instance du controller
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Affichage de la liste des utilisateurs
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupération des utilisateurs
        $users = User::all();

        // Récupération du solde
        $balance = $this->getBalance();

        return view('admin.users.index', ['users' => $users, 'balance' => $balance]);
    }

    /**
     * Affichage du formulaire de création d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Récupération du solde
        $balance = $this->getBalance();

        return view('admin.users.create', ['balance' => $balance]);
    }

    /**
     * Enregistrement du nouvel utilisateur en BDD
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
     * Affichage des données personnelles sur la page Mon Compte
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
     * Affichage du formulaire d'édition des données personnelles / Accès depuis la page Mon Compte
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAccount()
    {
        // Récupération des données utilisateurs
        $userID = Auth::id();
        $user = User::find($userID);

        // Création d'une variable pour identifier l'origine de l'utilisateur (Page Mon compte / Page Utilisateurs) sur la vue
        $accountEdit = true;

        // Récupération du solde
        $balance = $this->getBalance();

        return view('admin.users.edit', ['user' =>  $user, 'balance' => $balance, 'accountEdit' => $accountEdit]);

    }

    /**
     * Mise à jour des données personnelles
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
        $userID = Auth::id(); // !! récupération de l'identifiant depuis l'Auth par mesure de sécurité
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
        // Récupération des données utilisateurs
        $userID = Auth::id();
        $user = User::find($userID);

        // Récupération du solde
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

        // Récupération du solde
        $balance = $this->getBalance();

        return view('admin.users.edit', ['user' =>  $user, 'balance' => $balance]);
    }

    /**
     * Mise à jour des données utilisateurs en BDD
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
     * Suppression de l'utilisateur
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
            // Sinon on le supprime de la database
            $user->delete();

            return redirect('admin/users')->with('message', 'Utilisateur supprimé !');
        }

    }
}
