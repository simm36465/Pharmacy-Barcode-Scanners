@extends('layouts.dashboard')

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <!-- Add your content here -->
        <div class="col-md-12">

            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Modifier médicament</h3>
                </div>


                <form method="POST" id="updatemedicament">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2">

                                <div class="form-group">
                                    <label>ID</label>
                                    <input type="number" id="id" name="id" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">

                                <div class="form-group">
                                    <label>Code EAN13</label>
                                    <input type="number" id="codeEan" name="codeEan" class="form-control"
                                        placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nom Commercial</label>
                                    <input type="text" id="nomcomer" name="nomcomer" class="form-control"
                                        placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Dénomination commune internationale</label>
                                    <input type="text" id="dmc" name="dmc" class="form-control"
                                        placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Dosage</label>
                                    <input type="text" id="dosage" name="dosage" class="form-control"
                                        placeholder="Enter ...">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Presentation</label>
                            <input type="text" id="presentation" name="presentation" class="form-control"
                                placeholder="Enter ...">
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Prix Public de Vente (PPV)</label>
                                    <input type="number" id="ppv" name="ppv" step="0.01" class="form-control"
                                        placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Prix Base de Remboursement (PBR)</label>
                                    <input type="number" id="pbr" name="pbr" step="0.01" class="form-control"
                                        placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Prix Hospitalier (PH)</label>
                                    <input type="number" id="ph" name="ph" step="0.01" class="form-control"
                                        placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Prix Base deRemboursement (PBRH)</label>
                                    <input type="number" id="pbrh" name="pbrh" step="0.01" class="form-control"
                                        placeholder="Enter ...">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Classe</label>
                                    <input type="text" id="classe" name="classe" class="form-control"
                                        placeholder="Enter ...">
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
                        <button type="submit" class="btn btn-success float-right">Modifier</button>
                    </div>
                </form>
            </div>



        </div>
    </div>
    <!-- /.row -->
@endsection
@section('editmed_script')
    <script>
        $(document).ready(async function() {
            var csrfToken = "{{ csrf_token() }}";
            const {
                value: codeEan
            } = await Swal.fire({
                input: 'text',
                inputLabel: 'Veuillez fournir le code Ean13 du medicament',
                inputPlaceholder: '1234568798665...',
                inputAttributes: {
                    'aria-label': '1234568798665...',
                    'name': "codeA"

                },

                showCancelButton: true,
                cancelButtonText: "Annuler",
                confirmButtonText: 'Editer',
            })

            if (codeEan) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: 'updatemedicament',
                    type: 'POST',
                    data: {
                        "codeEan": codeEan
                    },
                    success: function(response) {

                        //console.log(response);
                        $('#id').val(response.id);
                        $('#codeEan').val(response.CODE_EAN13);
                        $('#nomcomer').val(response.Nom_Commercial);
                        $('#dmc').val(response.DCI);
                        $('#dosage').val(response.Dosage);
                        $('#presentation').val(response.Presentation);
                        $('#ppv').val(response.PPV);
                        $('#pbr').val(response.PBR);
                        $('#ph').val(response.PH);
                        $('#pbrh').val(response.PBRH);
                        $('#classe').val(response.Classe);
                        $('#isremb').val(response.remb);
                        $('#isanam').val(response.is_anam);

                    },
                    error: function(xhr, status, error) {

                        console.error(error);
                    }
                });
            }



            //UPDATE MEDI
            $("#updatemedicament").on("submit", function(e) {
                e.preventDefault(); // Prevent the default form submission behavior
                var formData = $("#updatemedicament").serialize();
                // Automatically serialize the form data
                //console.log(typeof(formData));
                console.log(formData);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: 'medicamentUpdate',
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

                        }

                        setTimeout(function() {
                            // Refresh the page
                            location.reload();
                        }, 3000);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Handle error if needed
                    }
                });
            });
        })
    </script>
@endsection
