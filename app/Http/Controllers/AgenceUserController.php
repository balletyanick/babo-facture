<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Contrat;
use App\Models\Agence;
use App\Models\AgenceUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgenceUserController extends Controller
{
    public function index()
    {
        Auth::user()->access("LISTE UTILISATEUR AGENCE");
        $agenceUser = AgenceUser::with('user','agence')
        ->paginate(100);
        return view('utilisateur_agence.index',compact('agenceUser'));
    }

    public function add($id)
        {
            $agenceUser = AgenceUser::find($id);
           
            $agenceUser = new AgenceUser;
            $title = "Affectation d'un utilisateur";

            Auth::user()->access('AJOUTER UTILISATEUR AGENCE');
            
            $user = User::orderBy('first_name', 'asc')->get();
            $agence = Agence::orderBy('libelle', 'asc')->get();
            return view('utilisateur_agence.save',compact('agenceUser','title','user','agence'));
        }


    public function save(Request $request)
    {
        Auth::user()->access('AJOUTER UTILISATEUR AGENCE');

        $validator = $request->validate([
            'user_id' => 'required|string|exists:users,id',
            'agence_id' => 'required|string|exists:agences,id',
        ]);

        $utilisateur = AgenceUser::where('user_id', $request->user_id)
                                ->where('id', '!=', $request->id)
                                ->first();

        if ($utilisateur) {
            return response()->json([
                'message' => 'Cet utilisateur est déjà affecté à une agence.',
                'status' => 'error'
            ]);
        } 
        
        else {
            // Création ou mise à jour de l'utilisateur d'agence
            $data = $request->all(); // Récupérer toutes les données du formulaire
            $data['id'] = $request->id; // Ajouter ou remplacer l'ID

            $agenceUser = AgenceUser::updateOrCreate(
                ['id' => $request->id], // Clé unique pour mise à jour
                $data // Données pour la mise à jour ou création
            );

            return response()->json([
                'message' => 'Utilisateur enregistré avec succès',
                'status' => 'success'
            ]);
        }
    }

    public function delete(Request $request)
        {

            Auth::user()->access('SUPPRESSION UTILISATEUR AGENCE');

            $agenceUser = AgenceUser::find($request->id);

            if($agenceUser->delete()){
                return response()->json(['message' => 'Agence supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }

}
 