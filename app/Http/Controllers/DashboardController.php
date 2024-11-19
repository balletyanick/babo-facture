<?php 
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Contrat;
    use App\Models\Product;
    use App\Models\User;
    use App\Models\Customer;
    use App\Models\Role;
    use Illuminate\Support\Facades\Storage;

    class DashboardController extends Controller
    {
        public function index()
        {
             // Vérifier si l'utilisateur connecté a le rôle 'AGENT'
            if (Auth::user()->role->name === 'CLIENT') {
                return redirect()->route('compte');
            }


            $nbUsers = User::count();
            $nbContrat = Contrat::count();
            $nbProduct = Product::count();
            $nbCustomer = Customer::count();
            return view('dashboard.index', compact('nbUsers','nbContrat','nbProduct','nbCustomer'));
        }

    }
