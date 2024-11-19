<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\GestionPaiementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
 
Route::get('/connexion', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

Route::middleware(['auth'])->group(function () {

    Route::get('/deconnexion', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    #compte
    Route::get('/compte', [CompteController::class, 'index'])->name('compte');
    Route::get('/liste_contrat', [CompteController::class, 'liste_contrat'])->name('liste_contrat');


    #paiement
    Route::get('/historique-des-paiements', [PaiementController::class, 'index'])->name('paiement.index');
    Route::get('/paiement/{id}', [PaiementController::class, 'add'])->name('paiement.add');
    Route::post('/save-paiement', [PaiementController::class, 'save'])->name('paiement.save');

    #gestion-paiement (admin)
    Route::get('/liste-des-paiements', [GestionPaiementController::class, 'index'])->name('gestion-paiement.index');
    Route::get('/paiement-refuser/{id}', [GestionPaiementController::class, 'refuser_paiement'])->name('paiement.refuser');
    Route::get('/paiement-valider/{id}', [GestionPaiementController::class, 'valider_paiement'])->name('paiement.valider');


    #utilisateur
    Route::get('/liste-des-utilisateurs', [UserController::class, 'index'])->name('user.index');
    Route::get('/utilisateur/{id}', [UserController::class, 'add'])->name('user.add');
    Route::post('/save-user', [UserController::class, 'save'])->name('user.save');
    Route::get('/delete-user', [UserController::class, 'delete'])->name('user.delete'); 

    #client
    Route::get('/liste-clients', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/client/{id}', [CustomerController::class, 'add'])->name('customer.add');
    Route::post('/save-customer', [CustomerController::class, 'save'])->name('customer.save');
    Route::get('/delete-customer', [CustomerController::class, 'delete'])->name('customer.delete');

    Route::get('/edit-customer/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    
    #produit
    Route::get('/liste-produits', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/{id}', [ProductController::class, 'add'])->name('product.add');
    Route::post('/save-product', [ProductController::class, 'save'])->name('product.save');
    Route::get('/delete-product', [ProductController::class, 'delete'])->name('product.delete');

    #contrat
    Route::get('/liste-contrat', [ContratController::class, 'index'])->name('contrat.index');
    Route::get('/contrat/{id}', [ContratController::class, 'add'])->name('contrat.add');
    Route::post('/save-contrat', [ContratController::class, 'save'])->name('contrat.save');
    Route::get('/delete-contrat', [ContratController::class, 'delete'])->name('contrat.delete');

    Route::get('/edit-contrat/{id}', [ContratController::class, 'edit'])->name('contrat.edit');
    Route::post('/save-edit-contrat', [ContratController::class, 'save_edit'])->name('contrat.save_edit');
    Route::get('/ajouter-montant/{id}', [ContratController::class, 'add_montant'])->name('contrat.add_montant');
    Route::post('/save-ajouter-montant', [ContratController::class, 'save_add_montant'])->name('contrat.save_add_montant');

  
    #role
    Route::get('/liste-des-roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/{id}', [RoleController::class, 'add'])->name('role.add');
    Route::get('/role/permissions/{id}', [RoleController::class, 'permissions'])->name('role.permissions');
    Route::post('/save-role', [RoleController::class, 'save'])->name('role.save');
    Route::get('/delete-role', [RoleController::class, 'delete'])->name('role.delete');


    #permission
    Route::get('/liste-des-permissions', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/{id}', [PermissionController::class, 'add'])->name('permission.add');
    Route::post('/save-permission', [PermissionController::class, 'save'])->name('permission.save');
    Route::post('/set-permission', [PermissionController::class, 'set_permission'])->name('set-permission.save');
    Route::get('/delete-permission', [PermissionController::class, 'delete'])->name('permission.delete');
    
});