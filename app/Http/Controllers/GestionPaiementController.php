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

class GestionPaiementController extends Controller
{
    public function index()
    {
        Auth::user()->access("LISTE PAIEMENT ADMIN");

        $paiements = Paiement::with('customer','contrat')
        ->orderByRaw('CAST(status AS UNSIGNED) asc') 
        ->paginate(100);
        return view('gestion-paiement.index',compact('paiements'));
    }

    public function refuser_paiement($id)
    {
        Auth::user()->access("REFUSER PAIEMENT");

        $paiement = Paiement::find($id);

        // Modifier le statut en 2 (refusé)
        $paiement->status = 2;
        $paiement->save();

        return redirect()->back()->with('success', 'Paiement refusé avec succès.');
    }

    public function valider_paiement($id)
    {
        Auth::user()->access("VALIDER PAIEMENT");

        $paiement = Paiement::find($id);

        // Vérification si le paiement existe
        if (!$paiement) {
            return redirect()->back()->with('error', 'Paiement introuvable.');
        }

        // Récupérer le contrat associé au paiement
        $contrat = Contrat::find($paiement->contrat_id);

        if (!$contrat) {
            return redirect()->back()->with('error', 'Contrat associé introuvable.');
        }

        // Vérifier si le montant du paiement dépasse le montant dispo_retrait
        if ($paiement->amount <= $contrat->dispo_retrait) {
            // Décrémenter dispo_retrait dans le contrat
            $contrat->dispo_retrait -= $paiement->amount;
            $contrat->save();

            // Modifier le statut en 1 (validé)
            $paiement->status = 1;
            $paiement->save();

            return redirect()->back()->with('success', 'Paiement validé avec succès.');
        }

        else {
            return redirect()->back()->with('error', 'Le montant du paiement dépasse le montant disponible pour retrait.');
        }

        
        }

}
