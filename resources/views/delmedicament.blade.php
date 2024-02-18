@extends('layouts.dashboard')

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <!-- Add your content here -->
        <div class="col-md-12">

            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Supprimer médicament</h3>
                </div>


                <form>
                    <div class="card-body">


                        <div class="form-group">
                            <label>Code EAN13</label>
                            <input type="number" max="13" min="13" id="codeA13" name="codeA13"
                                class="form-control" placeholder="Enter ...">
                        </div>


                    </div>

                    <div class="card-footer">
                        <button type="submit" id="deleteBtn" onclick="event.preventDefault();" data-toggle="modal"
                            data-target="#modal-confirmation" class="btn btn-danger float-right">Suprrimer</button>
                    </div>
                </form>
            </div>



        </div>
        <div class="modal fade" id="modal-confirmation" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title">Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body ">
                        <p>Êtes-vous sûr de vouloir supprimer ce médicament ?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        <button type="submit" id="btnconfirm" class="btn btn-danger" data-dismiss="modal">Confirmer</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <!-- /.row -->
@endsection
@section('deltmed_script')
    <script>
        $(document).ready(async function() {
          
          $("#deleteBtn").on("click", function() {
            var csrfToken = "{{ csrf_token() }}";
          //   const swalWithBootstrapButtons = Swal.mixin({
          //     // customClass: {
          //     //   confirmButton: 'btn btn-success ',
          //     //   cancelButton: 'btn btn-danger'
          //     // },
          //     buttonsStyling: false
          //   })

          //   swalWithBootstrapButtons.fire({
          //     title: 'Are you sure?',
          //     text: "You won't be able to revert this!",
          //     icon: 'warning',
          //     showCancelButton: true,
          //     confirmButtonText: 'Yes, delete it!',
          //     cancelButtonText: 'No, cancel!',
          //     reverseButtons: false
          //   }).then((result) => {
          //     if (result.isConfirmed) {
          //       swalWithBootstrapButtons.fire(
          //         'Deleted!',
          //         'Your file has been deleted.',
          //         'success'
          //       )
          //     } else if (
          //       /* Read more about handling dismissals below */
          //       result.dismiss === Swal.DismissReason.cancel
          //     ) {
          //       swalWithBootstrapButtons.fire(
          //         'Cancelled',
          //         'Your imaginary file is safe :)',
          //         'error'
          //       )
          //     }
          //   })
          // })
            

            $("#btnconfirm").on("click", function() {
       
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: 'deletemedicament',
                    type: 'POST',
                    data: {
                        "codeEan": $("#codeA13").val()
                    },
                    success: function(response) {

                        console.log(response);
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
                      

                    },
                    error: function(xhr, status, error) {

                        console.error(error);
                    }
                });

            })





        })
      })
    </script>
@endsection
