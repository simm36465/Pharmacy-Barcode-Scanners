@extends('layouts.dashboard')

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <!-- Add your content here -->
        <div class="col-md-12">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Ajouter médicament</h3>
                </div>


                <form method="POST"  id="addmedicament">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Code EAN13</label>
                                    <input type="number" id="codeEan" name="codeEan"  class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nom Commercial</label>
                                    <input type="text" id="nomcomer" name="nomcomer" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Dénomination commune internationale</label>
                                    <input type="text" id="dmc" name="dmc" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Dosage</label>
                                    <input type="text" id="dosage" name="dosage" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Presentation</label>
                            <input type="text" id="presentation" name="presentation" class="form-control"  placeholder="Enter ...">
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Prix Public de Vente (PPV)</label>
                                    <input type="number" id="ppv" name="ppv" step="0.01" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Prix Base de Remboursement (PBR)</label>
                                    <input type="number" id="pbr" name="pbr" step="0.01" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Prix Hospitalier (PH)</label>
                                    <input type="number" id="ph" name="ph" step="0.01" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Prix Base deRemboursement (PBRH)</label>
                                    <input type="number" id="pbrh" name="pbrh" step="0.01" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Classe</label>
                                    <input type="text" id="classe" name="classe" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Remborsable</label>
                                    <select class="form-control" id="isremb" name="isremb">
                                    <option value="1">OUI</option>
                                    <option value="0">NON</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>anam</label>
                                    <select class="form-control" id="isanam" name="isanam">
                                    <option value="1">OUI</option>
                                    <option value="0">NON</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Ajouter</button>
                    </div>

                </form>
            </div>



        </div>
    </div>
    <!-- /.row -->
@endsection

@section('addmed_script')
<script>
    $(document).ready(function() {
        $("#addmedicament").on("submit", function(e) {
            e.preventDefault(); // Prevent the default form submission behavior
            var formData = $("#addmedicament").serialize();
            // Automatically serialize the form data
            //console.log(typeof(formData));
            // console.log(   $("#addmedicament").serializeArray());

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: 'newmedicament',
                type: 'POST',
                data: formData, // Use the FormData object
                cache: false,
                processData: false,
                success: function(response) {
                    //console.log(response.status);
                    if (response.status === "success") {
                        var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        })
                        $("#addmedicament")[0].reset();
                    }


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle error if needed
                }
            });
        });
    });
</script>
@endsection
