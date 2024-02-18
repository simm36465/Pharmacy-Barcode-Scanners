@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <h2 class="text-center display-4">Recherche médicaments</h2>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="row">

                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <input type="search" id="search" name="search" class="form-control form-control-lg"
                                    placeholder="Typer votre mot clé ici (Nom commercial , code medicament)">
                                <!--<div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </-div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row mt-3">
                <div class="col-md-10 offset-md-1">
                    <div class="list-group">
                        <div class="list-group-item bg-dark">
                            <div class="row ">
                                <div class="col px-4">
                                    <div>

                                        <h3>Résultats de Recherche</h3>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item overflow-auto" style="max-height: 514px;">
                            <div class="row d-block" id="search-results">

                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('search_script')
    <script>
        $(function() {
            $('.select2').select2()
        });
    </script>
    <script>
        $(document).ready(function() {
            $('input[type="search"]').on('keyup', function() {
                var query = $(this).val();
        // Clear the results if the query is empty
        if (query.length === 0) {
            $('#search-results').html('');
            return;
        }
                if (query.length >= 1) { // Adjust the minimum length for triggering the search

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('searchmedi') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'query': query
                        },
                        success: function(data) {
                            // Handle the received data and update the UI
                            console.log(data);
                            // Example: Update a div with search results
                            // Assuming data is an array of search results
                            var resultsHtml = '';

                            // Iterate through the results and build the HTML
                            $.each(data, function(index, result) {

                        var ANAM;
                        var REMB;
                        // Check if isanam is 1 or 0
                        if (result.is_anam == 1) {
                            ANAM = '<small><span class="badge badge-success">ANAM</span></small>';
                        } else {
                            ANAM = '<small><span class="badge badge-danger">Hors ANAM</span></small>';
                        }

                        // Check if remb is 1 or 0
                        if (result.remb == 1) {
                            REMB = '<small><span class="badge badge-success">MR</span></small>';
                        } else {
                            REMB = '<small><span class="badge badge-danger">MNR</span></small>';
                        }

                                resultsHtml += '<div class="col px-4 mb-4">';
                                resultsHtml += '<div>';

                                resultsHtml += '<div class="float-right"><strong>' + result.CODE_EAN13 + '</strong></div>';
                                
                                resultsHtml += '<h3>' + result.Nom_Commercial +" " + ANAM +" " + REMB + '</h3>' ;
                                resultsHtml += '<p class="mb-0">';
                                resultsHtml += '<span><strong>PPV : </strong>' + result.PPV.toFixed(2) + '</span>     |    ';
                                resultsHtml += '<span><strong>PH : </strong>' + result.PH.toFixed(2) + '</span>     |    ';
                                resultsHtml += '<span><strong>Presentation :</strong>' + result.Presentation + '</span>     |    ';
                                resultsHtml += '<span><strong>Dosage :</strong>' + result.Dosage + '</span>     |    ';
                                resultsHtml += '<span><strong>Classe :</strong>' + result.Classe + '</span>     |    ';
                                resultsHtml += '<span><strong>DCI :</strong>' + result.DCI + '</span>';
                                resultsHtml += '</p>';
                                resultsHtml += '</div>';
                                resultsHtml += '</div><hr class="my-4">';
                            });

                            // Update the search results container with the generated HTML
                            $('#search-results').html(resultsHtml);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
