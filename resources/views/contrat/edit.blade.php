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

                <form action="{{route('contrat.save_edit')}}" class="edit_contrat">
                    @csrf
                    <input type="hidden" name="id" value="{{$contrat->id}}">
                    <input type="hidden" name="customer_id" value="{{$contrat->customer_id}}">
                    <input type="hidden" name="product_id" value="{{$contrat->product_id}}">
                    <input type="number" name="quantite" value="{{$contrat->quantite}}" class="form-control rounded-end"/>
                    <input type="number" name="amount_global" value="{{$contrat->amount_global}}" class="form-control rounded-end"/>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row g-3">

                                                <div class="col-lg-12">
                                                    <label class="form-label"> Client </label>
                                                    <input type="text" class="form-control bg-light" value="{{$contrat->customer->user->first_name }} {{ $contrat->customer->user->last_name }}" readonly>
                                                </div>

                                                <div class="col-lg-12 mb-3">
                                                    <label class="form-label"> Produit </label>
                                                    <input type="text" class="form-control bg-light" value="{{$contrat->product->libelle }} {{ $contrat->product->duration_contrat}}" readonly>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div>
                                                        <label class="form-label">Date de début </label>
                                                        <input type="date" name="date_start" value="{{$contrat->date_start}}" class="form-control rounded-end" required/>
                                                    </div>

                                                    <div class="mt-3">
                                                        <label class="form-label">Date de fin </label>
                                                        <input type="date" name="date_end" value="{{$contrat->date_end}}"  class="form-control rounded-end" required/>
                                                    </div>                                                    
                                                </div> 
                                                
                                                <div class="col-lg-6">
                                                    <div>
                                                        <label class="form-label"> Numéro du contrat </label>
                                                        <input type="text" name="num_contrat" value="{{$contrat->num_contrat}}"  class="form-control rounded-end" required/>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="form-label"> Montant global du contrat <small>  (FCFA)  </small>  </label>
                                                        <input type="number" name="amount_global" value="{{$contrat->amount_global}}" class="form-control bg-light rounded-end" readonly/>
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
                                                        <input type="number" name="quantite" value="{{$contrat->quantite}}" class="form-control bg-light rounded-end" readonly/>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="form-label"> Note  </label>
                                                        <input type="text" name="note" value="{{$contrat->note}}" class="form-control rounded-end"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12"> 
                                                    <button id="edit_contrat" class="btn btn-primary btn-block" style="width:100%">Enregistrer</button> 
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

        $('.edit_contrat').submit(function(e){

            e.preventDefault();

            var form = new FormData($(this)[0]);

            var buttonDefault = $('#edit_contrat').text();
            var button = $('#edit_contrat');

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