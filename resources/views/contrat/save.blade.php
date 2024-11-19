@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="main-content"> 

        <div class="page-content">
            <div class="container-fluid">
 
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">{{$title}}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contrats</a></li>
                                    <li class="breadcrumb-item active">{{$title}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <form action="{{route('contrat.save')}}" class="add_contrat">
                    @csrf
                    <input type="hidden" name="contrat_id" value="{{$contrat->contrat_id}}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4><small> Client & Produit</small></h4>
                                            <hr>
                                            <div class="row g-3">
                                                <div class="col-lg-12">
                                                    <label class="form-label"> Client </label>
                                                    <select name="customer_id" id="customer_id" class="form-control select2">
                                                            @foreach($customer as $customers)
                                                                <option value="{{$customers->id}}" {{$customers->id==$contrat->customers ? 'selected' : ''}}>{{$customers->user->first_name}} {{$customers->user->last_name}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-12 mb-3">
                                                    <label class="form-label"> Produit </label>
                                                    <select name="product_id" id="product_id" class="form-control select2">
                                                            @foreach($product as $products)
                                                                <option value="{{$products->id}}" {{$products->id==$contrat->user_id ? 'selected' : ''}}>{{$products->libelle}} - {{$products->duration_contrat}} Mois </option>
                                                            @endforeach
                                                    </select>
                                                </div>

                                                <h4><small>Contrat </small></h4>
                                                <hr>
                                                <div class="col-lg-6">
                                                    <div>
                                                        <label class="form-label">Date de début </label>
                                                        <input type="date" name="date_start" class="form-control rounded-end" required/>
                                                    </div>

                                                    <div class="mt-3">
                                                        <label class="form-label">Date de fin </label>
                                                        <input type="date" name="date_end" class="form-control rounded-end" required/>
                                                    </div>                                                    
                                                </div> 
                                                
                                                <div class="col-lg-6">
                                                    <div>
                                                        <label class="form-label"> Numéro du contrat </label>
                                                        <input type="text" name="num_contrat" class="form-control rounded-end" required/>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="form-label"> Montant global du contrat <small>  (FCFA)  </small>  </label>
                                                        <input type="number" name="amount_global" class="form-control rounded-end" required/>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12"> 
                                                    <div>
                                                        <label class="form-label"> Type de contrat </label>
                                                        <select name="type_contrat" id="type_contrat" class="form-control select2">
                                                                <option> Achat & Gestion</option>
                                                                <option> Gestion Simple  </option>
                                                        </select>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="form-label"> Nombre  </label>
                                                        <input type="number" name="quantite"  class="form-control rounded-end" required/>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="form-label"> Note  </label>
                                                        <input type="text" name="note"  class="form-control rounded-end"/>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12"> 
                                                    <button id="add_contrat" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                </form>
            </div>
            <!-- container-fluid -->
        </div>

@endsection

@section('css-link')
    
@endsection



@section('script')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>

        var data;

        function popup(self){
            data = $(self);
            var input_data =  data.parent().find('.data');
            $('#summernote').summernote('code',input_data.val());
        }

        function save_data(){
            var input_data =  data.parent().find('.data');
            $('.bs-example-modal-center').modal('hide');
            input_data.val($("#summernote").val());
        }

        $(document).ready(function() {
            $('.summernote').summernote({height: 600});
        });

        $('.add_contrat').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#add_contrat').text();
            var button = $('#add_contrat');

            button.attr('disabled',true);
            button.text('Veuillez patienter ...');

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: form,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (result){

                    button.attr('disabled',false);
                    button.text(buttonDefault);

                    if(result.status=="success"){

                        Toastify({
                            text: result.message,
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "#4CAF50", // green
                        }).showToast();

                        window.location='{{route("contrat.index")}}'
                    }else{
                        Toastify({
                            text: result.message,
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "red", // red
                        }).showToast();
                    }
                    
                },
                error: function(result){

                    button.attr('disabled',false);
                    button.text(buttonDefault);

                    if(result.responseJSON.message){
                        Toastify({
                            text: result.responseJSON.message,
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "red", // red
                        }).showToast();
                    }else{
                        Toastify({
                            text: "Une erreur c'est produite",
                            duration: 3000, // 3 seconds
                            gravity: "top", // "top" or "bottom"
                            position: 'right', // "left", "center", "right"
                            backgroundColor: "red", // red
                        }).showToast();
                    }

                }
            });
        });

    </script>
   
@endsection