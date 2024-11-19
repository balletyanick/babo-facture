@extends('layouts.app')

@section('title', "Liste des contrats")

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Liste des contrats</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contrat</a></li>
                                    <li class="breadcrumb-item active">Liste des contrats</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <table id="table" class="table table-bordered dt-responsive table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>N° Contrat</th>
                                            <th>Nom et prenoms</th>
                                            <th> Nombre Produit & Durée</th>
                                            <th> Date de début </th>
                                            <th> Date de fin </th>
                                            <th> Montant global </th>
                                            <th> Disponible retrait </th>
                                            <th> Type de contrat </th>
                                            <th> Note </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contrats as $contrat)
                                            <tr>
                                                <td>{{$contrat->num_contrat}}</td>
                                                <td>{{$contrat->customer->user->first_name}} {{$contrat->customer->user->last_name}}</td>
                                                <td>{{$contrat->quantite}} {{$contrat->product->libelle}} - {{$contrat->product->duration_contrat}} Mois </td>
                                                <td>{{date('d/m/Y',strtotime($contrat->date_start))}}</td>
                                                <td>{{date('d/m/Y',strtotime($contrat->date_end))}}</td>
                                                <td>{{$contrat->amount_global}} FCFA </td>
                                                <td>{{$contrat->dispo_retrait}} FCFA</td>
                                                <td>{{$contrat->type_contrat}}</td>
                                                <td>{{$contrat->note}}</td>
                                                <td>
                                                    @if(Auth::user()->permission('EDITION CONTRAT') || Auth::user()->permission('SUPPRESSION CONTRAT') || Auth::user()->permission('AJOUTER DISPONIBILITE RETRAIT'))
                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @if(Auth::user()->permission('EDITION CONTRAT'))
                                                                <li>
                                                                    <a class="dropdown-item edit-item-btn" href="{{route('contrat.edit',[$contrat->id])}}"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Modifier</a>
                                                                </li>
                                                            @endif

                                                            @if(Auth::user()->permission('AJOUTER DISPONIBILITE RETRAIT'))
                                                                <li>
                                                                    <a class="dropdown-item edit-item-btn" href="{{route('contrat.add_montant',[$contrat->id])}}"><i class="ri-add-fill align-bottom me-2 text-muted"></i> Ajouter montant</a>
                                                                </li>
                                                            @endif

                                                            @if(Auth::user()->permission('SUPPRESSION CONTRAT'))
                                                                <li>
                                                                    <a href="javascript:void(0);" onclick="deleted('{{$contrat->id}}','{{route('contrat.delete')}}')" class="dropdown-item remove-item-btn">
                                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted" ></i> Supprimer
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <ul class="pagination pagination-separated justify-content-center mb-0">
                                    @if ($contrats->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="mdi mdi-chevron-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a href="{{ $contrats->previousPageUrl() }}" class="page-link" rel="prev"><i class="mdi mdi-chevron-left"></i></a>
                                        </li>
                                    @endif
                        
                                    @foreach ($contrats->getUrlRange(1, $contrats->lastPage()) as $page => $url)
                                        @if ($page == $contrats->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                        
                                    @if ($contrats->hasMorePages())
                                        <li class="page-item">
                                            <a href="{{ $contrats->nextPageUrl() }}" class="page-link" rel="next"><i class="mdi mdi-chevron-right"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="mdi mdi-chevron-right"></i></span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <br>
                        </div>
                    </div><!--end col--> 
                    
                </div><!--end row-->

            </div>
            <!-- container-fluid -->
            
        </div>
        <!-- End Page-content -->
    </div>

@endsection

@section('script')
    <script>
        new DataTable("#table", {
            dom: "Bfrtip",
            paging:false,
            buttons: ["excel"],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            }
        });

        new DataTable("#table-insurance", {
            dom: "Bfrtip",
            paging:false,
            buttons: ["excel"],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            }
        });

    </script>
@endsection 