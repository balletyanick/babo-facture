<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contrat;
use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
use App\Models\Role;
use App\Models\Paiement;
use Illuminate\Support\Facades\Storage;

class PaiementController extends Controller
{
    public function index()
{
    // Vérifier l'accès pour l'utilisateur connecté
    Auth::user()->access("LISTE CONTRAT PERSONNEL");

    // Récupérer le client lié à l'utilisateur actuellement connecté
    $customer = Auth::user()->customer;

    // Récupérer uniquement les paiements associés à ce client
        $paiements = Paiement::with('customer', 'contrat')
            ->where('customer_id', $customer->id) // Filtrer par le client lié à l'utilisateur connecté
            ->paginate(100);
    
    // Retourner la vue avec les paiements filtrés
    return view('paiement.index', compact('paiements'));
}


    public function add($id)
{
    // Vérifier que l'utilisateur connecté a accès à cette action
    Auth::user()->access('DEMANDE PAIEMENT PERSONNEL');
    
    // Récupérer le client lié à l'utilisateur actuellement connecté
    // Utilise la relation définie entre User et Customer
    $customer = Auth::user()->customer;
    
    // Vérifier si le paiement existe, sinon rediriger
    $paiement = Paiement::find($id);

    // Utilisation de collections pour éviter de charger trop de données
    $user = Auth::user(); // Utiliser l'utilisateur connecté uniquement (pas besoin de récupérer tous les utilisateurs)
    $contrat = Contrat::where('customer_id', $customer->id)->get(); // Récupérer les contrats associés au client

    // Définir le titre de la page
    $title = 'Demander un paiement';

    // Retourner la vue avec les variables nécessaires
    return view('paiement.save', compact('contrat', 'title', 'customer', 'user', 'paiement'));
}



public function save(Request $request)
{
    Auth::user()->access('DEMANDE PAIEMENT PERSONNEL');

    $validator = $request->validate([
        'customer_id' => 'required|string|exists:customers,id',
        'contrat_id' => 'required|string|exists:contrats,id',
        'amount' => 'required|integer',
        'date_demande' => 'required|date',
        'mode_paiement' => 'required|string',
    ]);

    $user = Auth::user();

    // Calcul de la somme de 'dispo_retrait' pour les contrats liés à l'utilisateur actuel
    $somme_dispo_retrait = Contrat::whereHas('customer', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->sum('dispo_retrait');

    // Vérifier si l'amount est inférieur ou égal à la somme de dispo_retrait
    if ($request->input('amount') <= $somme_dispo_retrait) {
        $data = $request->only(['amount', 'date_demande', 'mode_paiement']);
        $data['customer_id'] = $request->input('customer_id');
        $data['contrat_id'] = $request->input('contrat_id');
        $data['status'] = 0;

        Paiement::create($data);

        return response()->json(['message' => 'Demande de paiement enregistré avec succès', 'status' => 'success']);
    } else {
        // Retourner un message d'erreur si la condition n'est pas respectée
        return response()->json(['message' => 'Erreur : le montant demandé dépasse la disponibilité des retraits', 'status' => 'error'], 400);
    }
}

}
 