@extends('layouts.dashboard')

@section('content')
<!-- Info boxes -->
<div class="row">
    <!-- Add your content here -->
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header bg-primary">
                <h3 class="card-title">Exporte la liste des médicaments</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table border="0" cellspacing="5" cellpadding="5">
                    <tbody>
                        <div class="row">

                            <form id="MediDataForm" action="" method="post">
                                @csrf
                                <div class="col-4">
                                <div class="form-group">
                                    <label>Médicament ANAM</label>
                                    <div class="select2-green">
                                        <select id="medicamentAnam" name="medicamentAnam[]" class="select2" multiple="multiple" data-placeholder="Select le type médicament" data-dropdown-css-class="select2-green" style="width: 100%;">
                                            <option value="1">ANAM</option>
                                            <option value="0">HORS ANAM</option>
                                        </select>
                                      </div>
                                  </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Médicament remboursement</label>
                                        <div class="select2-green">
                                            <select id="remboursement" name="remboursement[]" class="select2" multiple="multiple" data-placeholder="Select le status médicament" data-dropdown-css-class="select2-green" style="width: 100%;">
                                                <option value="1">MR</option>
                                                <option value="0">MNR</option>
                                            </select>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="col-3">
                                        <label>Nom médicament Contient</label>
                                        <div class="input-group mb-3 ">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">Commencer par</span>
                                            </div>
                                            <input  id="nomMedicament" name="nomMedicament" type="text" class="form-control" placeholder="Nom commercial du médicament recherché">
                                          </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="input-group mb-3 mt-4 pt-2">
                                            <button type="submit" class="btn btn-block btn-info" id="submitBtn">
                                                <span id="btnText">Chargé &nbsp; <i class="fas fa-sync"></i></span>
                                                <div class="spinner-border spinner-border-sm d-none" role="status" id="loadingSpinner">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                
                                            </button>
                                          </div>
                                    </div>
                            </form>
                        
                        </div>
                        {{-- <tr>
                            <td>date début :</td>
                            <td><input type="text" id="min" name="min"></td>
                            <td>date fin :</td>
                            <td><input type="text" id="max" name="max"></td>
                        </tr> --}}
                        <!-- <tr>
                            <td>date fin:</td>
                            <td><input type="text" id="max" name="max"></td>
                        </tr> -->
                    </tbody>
                </table>

                <table id="example1" class="display nowrap table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            
                            <th>Code EAN13</th>
                            <th>Nom Commercial</th>
                            <th>DCI</th>
                            <th>Dossage</th>
                            <th>Presentation</th>
                            <th>PPV</th>
                            <th>Remb</th>
                            <th>ANAM</th>
                        </tr>
                    </thead>
                    <tbody>  

                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<!-- /.row -->
@endsection
@section('exportmedi_script')
<script>
       $('.select2').select2()
    $(function() {
        // let minDate, maxDate;

        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "language": {
                "emptyTable": "Pas de données disponibles.",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
                "infoFiltered": "(filtré de _MAX_ entrées au total)",
                "search": "Rechercher :",
                "paginate": {
                "next": "Suivant",
                "previous": "Précédent"
            }
            },
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



    });





</script>
<script>
   $(document).ready(function() {
    $('#MediDataForm').on('submit', function(event) {
      // Prevent the default form submission behavior
      event.preventDefault();
         // Get selected values from Select2 dropdowns
    var medicamentAnamValues = $('#medicamentAnam').val();
    var remboursementValues = $('#remboursement').val();
    var nomMedicamentValue = $('#nomMedicament').val();


      $.ajax({
        headers: {
        'X-CSRF-TOKEN': '{{csrf_token()}}'
        },
        url: '/exportmedidata',
        type: 'POST',
        data: {
            'mediAnamValues':medicamentAnamValues,
            'medirembValues':remboursementValues,
            'nomMediValue':nomMedicamentValue
        },
        beforeSend: function() {
          // This function will be called before the request is sent
        $('#loadingSpinner').removeClass('d-none');
        $('#btnText').addClass('d-none');
        },
        success: function(data) {
            var table = $('#example1').DataTable();
    table.clear().draw();

    var table = $('#example1').DataTable();
  
    // Add new rows based on the data received
    $.each(data, function (index, item) {
        var rembBadge = (item.remb == 1) ? '<span class="badge badge-success">MR</span>' : '<span class="badge badge-danger">MNR</span>';
        var anamBadge = (item.is_anam == 1) ? '<span class="badge badge-success">ANAM</span>' : '<span class="badge badge-danger">HORS ANAM</span>';
        table.row.add([
            item.CODE_EAN13,
            item.Nom_Commercial,
            item.DCI,
            item.Dosage,
            item.Presentation,
            item.PPV,
            rembBadge,
            anamBadge
        ]).draw();
    });

            
          // This function will be called if the request is successful 
        $('#loadingSpinner').addClass('d-none');
        $('#btnText').removeClass('d-none');
        },
        error: function(xhr, status, error) {
          // This function will be called if the request encounters an error
          alert('Error: ', status, error);
        }
      });
    });
  });
</script>
@endsection