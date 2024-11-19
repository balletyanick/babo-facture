<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{asset('images/babo.png')}}" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{asset('images/babo.png')}}" alt="" width="120">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{asset('assets/images/babo.png')}}" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{asset('assets/images/babo.png')}}" alt="" width="80">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                
                @if(Auth::user()->permission('DASHBOARD'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route("dashboard")}}">
                            <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                        </a>
                    </li>
                @endif
                

                @if(Auth::user()->permission('COMPTE'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route("compte")}}">
                            <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Compte</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->permission('LISTE CONTRAT PERSONNEL') || Auth::user()->permission('DEMANDE PAIEMENT PERSONNEL') || Auth::user()->permission('HISTORIQUE PAIEMENT PERSONNEL'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarCompte" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth"> 
                            <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Paiement</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarCompte">
                            <ul class="nav nav-sm flex-column" >
                                @if(Auth::user()->permission('LISTE CONTRAT PERSONNEL'))
                                    <li class="nav-item">
                                        <a href="{{route("liste_contrat")}}" class="nav-link" data-key="t-calendar"> Liste des contrats </a>
                                    </li>
                                @endif
                            </ul>
                            <ul class="nav nav-sm flex-column" >
                                @if(Auth::user()->permission('DEMANDE PAIEMENT PERSONNEL'))
                                    <li class="nav-item">
                                        <a href="{{route("paiement.add",['ajouter'])}}" class="nav-link" data-key="t-calendar"> Demander un paiement </a>
                                    </li>
                                @endif
                            </ul>
                            <ul class="nav nav-sm flex-column" >
                                @if(Auth::user()->permission('HISTORIQUE PAIEMENT PERSONNEL'))
                                    <li class="nav-item">
                                        <a href="{{route("paiement.index")}}" class="nav-link" data-key="t-calendar"> Historique des paiements </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                
                

                @if(Auth::user()->permission("LISTE CLIENT") || Auth::user()->permission("AJOUTER CLIENT"))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarCustomer" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCustomer">
                            <i class="ri-user-line"></i> <span data-key="t-authentication">Clients</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarCustomer">
                            <ul class="nav nav-sm flex-column" >
                                @if(Auth::user()->permission("AJOUT CLIENT"))
                                    <li class="nav-item">
                                        <a href="{{route("customer.add",['ajouter'])}}" class="nav-link" data-key="t-calendar"> Ajouter un client </a>
                                    </li>
                                @endif
                                @if(Auth::user()->permission("LISTE CLIENT"))
                                    <li class="nav-item">
                                        <a href="{{route("customer.index")}}" class="nav-link" data-key="t-calendar"> Liste des clients  </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if(Auth::user()->permission("LISTE PRODUIT") || Auth::user()->permission("AJOUTER PRODUIT"))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarProduct" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProduct">
                        <i class="ri-car-line"></i> <span data-key="t-authentication">Produits </span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarProduct">
                        <ul class="nav nav-sm flex-column" >
                            @if(Auth::user()->permission("AJOUT PRODUIT"))
                                <li class="nav-item">
                                    <a href="{{route("product.add",['ajouter'])}}" class="nav-link" data-key="t-calendar"> Ajouter un produits </a>
                                </li>
                            @endif
                            @if(Auth::user()->permission("LISTE PRODUIT"))
                                <li class="nav-item">
                                    <a href="{{route("product.index")}}" class="nav-link" data-key="t-calendar"> Liste des produits  </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                @if(Auth::user()->permission("LISTE CONTRAT") || Auth::user()->permission("AJOUTER CONTRAT"))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarContrat" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarContrat">
                            <i class="ri-file-list-line"></i> <span data-key="t-authentication">Contrat</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarContrat">
                            <ul class="nav nav-sm flex-column" >
                                @if(Auth::user()->permission("LISTE CONTRAT"))
                                    <li class="nav-item">
                                        <a href="{{route("contrat.index")}}" class="nav-link" data-key="t-calendar"> Liste des contrats </a>
                                    </li>
                                @endif
                                @if(Auth::user()->permission("AJOUT CONTRAT"))
                                    <li class="nav-item">
                                        <a href="{{route("contrat.add",['ajouter'])}}" class="nav-link" data-key="t-calendar">Créer un contrat  </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if(Auth::user()->permission("LISTE PAIEMENT ADMIN"))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarPaiementAdmin" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCustomer">
                            <i class="ri-user-line"></i> <span data-key="t-authentication">Gestion des Paiements </span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarPaiementAdmin">
                            <ul class="nav nav-sm flex-column" >
                                @if(Auth::user()->permission("LISTE PAIEMENT ADMIN"))
                                    <li class="nav-item">
                                        <a href="{{route("gestion-paiement.index")}}"  class="nav-link" data-key="t-calendar"> Paiements en cours </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if(Auth::user()->permission('AJOUT UTILISATEUR') || Auth::user()->permission('LISTE UTILISATEUR') || Auth::user()->permission('LISTE ROLE') || Auth::user()->permission('LISTE PERMISSION'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                            <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Utilisateurs</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarAuth">
                            <ul class="nav nav-sm flex-column" >
                                @if(Auth::user()->permission('AJOUT UTILISATEUR'))
                                    <li class="nav-item">
                                        <a href="{{route("user.add",['ajouter'])}}" class="nav-link" data-key="t-calendar"> Ajouter </a>
                                    </li>
                                @endif
                                @if(Auth::user()->permission('LISTE UTILISATEUR'))
                                    <li class="nav-item">
                                        <a href="{{route("user.index")}}" class="nav-link" data-key="t-calendar"> Liste </a>
                                    </li>
                                @endif
                                @if(Auth::user()->permission('LISTE ROLE'))
                                    <li class="nav-item">
                                        <a href="{{route("role.index")}}" class="nav-link" data-key="t-calendar"> Rôles </a>
                                    </li>
                                @endif
                                @if(Auth::user()->permission('LISTE PERMISSION'))
                                    <li class="nav-item">
                                        <a href="{{route("permission.index")}}" class="nav-link" data-key="t-calendar"> Permissions </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Informations</span>
                    </a>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>