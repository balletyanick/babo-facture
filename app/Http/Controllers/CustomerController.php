<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Customer;
    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;

    class CustomerController extends Controller
    {
        public function index()
        {
            Auth::user()->access("LISTE CLIENT");
            $customers = Customer::paginate(100);
            return view('customer.index',compact('customers'));
        }
 
        public function add($id)
        {
            $customer = Customer::find($id);

            if(!is_null($customer)){
                $title = "Modifier $customer->first_name $customer->last_name";

                Auth::user()->access('EDITION CLIENT');
            }else{
                $customer = new Customer;
                $title = 'Ajouter un client';

                Auth::user()->access('AJOUT CLIENT');
            } 
            
            return view('customer.save',compact('customer','title'));
        }

        public function save(Request $request)
        {
            Auth::user()->access('AJOUT CLIENT');

            $validator = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'date_of_birth' => 'required|date',
                'numero_cni' => 'required|string',
                'genre' => 'required|string',
                'phone' => 'required|string',
                'note' => 'nullable|string',
            ]);

            $customer = Customer::where('numero_cni', $request->numero_cni)
                                ->where('id', '!=', $request->id)
                                ->first();

            $utilisateur = Customer::where('phone', $request->phone)
                                ->where('phone', '!=', $request->phone)
                                ->first();

            if ($customer) {
                return response()->json(['message' => 'Ce client existe déjà.', "status" => "error"]);

            } 
            
            else if ($utilisateur) {
                return response()->json(['message' => 'Le numero de téléphone est déja lié à un client.', "status" => "error"]);

            }
            else {
                $customer = Customer::updateOrCreate(
                    ['id' => $request->id],
                    $request->all()
                );
            }

            return response()->json(['message' => 'Client enregistré avec succès', 'status' => 'success']);
        }
 

        public function delete(Request $request){

            Auth::user()->access('SUPPRESSION CLIENT');

            $customer = Customer::find($request->id);

            if($customer->delete()){
                return response()->json(['message' => 'Client supprimé avec succès',"status"=>"success"]);
            }else{
                return response()->json(['message' => 'Echec de la suppression veuillez réessayer',"status"=>"error"]);
            }
        }

        public function edit($id)
        { 
            Auth::user()->access('EDITION CLIENT');
            $title = 'Modifier les informations du client';
    
            $customer = Customer::find($id);
            return view('customer.edit', compact('title', 'customer'));
        }
    
    
        public function save_edit(Request $request)
        {   
    
        Auth::user()->access('EDITION CLIENT');
    
        $validator = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'date_of_birth' => 'required|date',
            'numero_cni' => 'required|string',
            'genre' => 'required|string',
            'phone' => 'required|string',
            'note' => 'nullable|string',
        ]);
    
        $customer = Customer::findOrFail($request->id);
    
        $data = $request->only(['first_name','last_name','date_of_birth','numero_cni','genre','phone','note']);
        
        $contrat->update($data);
    
        return response()->json(['message' => 'Informations modifiées avec succès', 'status' => 'success']);
        }
    }