<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contrat;
use App\Models\Product;
use App\Models\User;
use App\Models\Role;
use App\Models\Paiement;
use Illuminate\Support\Facades\Storage;


class CompteController extends Controller
{
    public function index()
    {
        Auth::user()->access("COMPTE");
        $user = Auth::user();

        // Calcul de la somme de 'amount_global' pour les contrats liés à l'utilisateur actuel
        $solde_total = Contrat::whereHas('customer', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('amount_global'); 

        // Calcul du nombre de contrats liés à l'utilisateur actuel
        $nombre_contrats = Contrat::whereHas('customer', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        // Calcul de la somme des paiements ayant le status = 1 liés à l'utilisateur
        $somme_retire = Paiement::where('status', 1)
        ->whereHas('customer', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('amount');

        // Calcul de la somme de 'dispo_retrait' pour les contrats liés à l'utilisateur actuel
        $somme_dispo_retrait = Contrat::whereHas('customer', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('dispo_retrait');

        $solde_actuel = $solde_total - $somme_retire;

        return view('compte.index', compact('solde_total', 'nombre_contrats', 'somme_retire', 'solde_actuel', 'somme_dispo_retrait'));
    }


    public function liste_contrat()
    {
        Auth::user()->access("COMPTE");
        $user = Auth::user();

        // Récupération des contrats liés à l'utilisateur actuel
        $contrats = Contrat::whereHas('customer', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->paginate(100);

        return view('compte.liste_contrat', compact('contrats'));
    }
}
