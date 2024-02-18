@extends('layouts.dashboard')

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <!-- Add your content here -->
        <div class="col-md-12">

            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Listes des utilisateurs</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0" id="table1">
                            <thead>
                                <tr>

                                    <th>Nom</th>
                                    <th>Matricule</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->mle }}</td>
                                        <td>{{ $user->email }}</td>

                                        <td>
                                            @if ($user->acc_type == 0)
                                                <span class="badge badge-success">Standard</span>
                                            @elseif ($user->acc_type == 1)
                                                <span class="badge badge-primary">Superviseur</span>
                                            @elseif ($user->acc_type == 2)
                                                <span class="badge badge-danger">Administrateur</span>
                                            @endif
                                        </td>
                                        <td>
                                            
                                                <button type="button" data-uid="{{ $user->id }}" class="btn btn-danger btn-sm deleteBtn">supprimer compte</button>
                                                <button type="button" data-uid="{{ $user->id }}" class="btn btn-warning btn-sm resetBtn">Réinitialiser le mot de passe</button>
                                           
                                        </td>



                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a> --}}
                    </div>
                    <!-- /.card-footer -->
                </div>


            </div>



        </div>
    </div>
    <!-- /.row -->
@endsection
@section('utilisateur_script')
<!-- Add this inside the <script> tag in your Blade file -->
    <script>
        $(document).ready(function () {

            
            $(".deleteBtn").on("click", function () {

                var userId = $(this).data("uid");
    
                // Make an AJAX request to delete the user
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: '/delete-user/' + userId,
                    type: 'DELETE',
                    success: function (data) {
                        location.reload();
                        console.log(data.success);
                        if (data.success) {
                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                icon: 'success',
                                title: "User with ID " + userId + " deleted successfully."
                            })

                        }
                        // You can update the UI or take other actions as needed
                        	
                       
                    },
                    error: function (xhr, status, error) {
                        console.error("Error deleting user with ID " + userId + ": " + error);
                    }
                });
            });
    
            // Add other scripts if needed
        });
    </script>
    <!-- Add this inside the <script> tag in your Blade file -->
<script>
    $(document).ready(function () {
        // Your existing code...

        $(".resetBtn").on("click", function () {
            var userId = $(this).data("uid");

            // Make an AJAX request to reset the password
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: '/reset-password/' + userId,
                type: 'POST',
                success: function (data) {
                    console.log(data);
                    if (data.success) {
                        // var Toast = Swal.mixin({
                        //     toast: true,
                        //     position: 'top-end',
                        //     showConfirmButton: false,

                        // });

                        // Toast.fire({
                        //     icon: 'success',
                        //     title: "Password reset for user with ID " + userId + " successful. New password: " + data.newPassword
                        // });
                        $(document).Toasts('create', {
                            body: "Le mot de passe réinitialisé avec succès <br>Nouveau mot de passe:  " + "<strong>" +  data.newPassword + "</strong>",
                            title: 'Mot de passe réinitialisé',
                            subtitle: 'ID'+ userId ,
                            icon: 'fas fa-user-lock fa-md',
                        })
                    } else {
                        var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        Toast.fire({
                            icon: 'error',
                            title: "Failed to reset password for user with ID " + userId + ". " + data.message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error resetting password for user with ID " + userId + ": " + error);
                }
            });
        });
    });
</script>


@endsection
