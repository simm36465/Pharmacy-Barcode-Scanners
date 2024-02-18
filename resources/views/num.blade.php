<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/app.css">
        {{-- Favicon link --}}
        <link rel="apple-touch-icon" sizes="180x180" href="images/favicon_io/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon_io//favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon_io//favicon-16x16.png">
        <link rel="manifest" href="images/favicon_io//site.webmanifest">
    <title>Controle Pharmacie</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
          <div class="col nopadding">
            <nav class="nav text-bg-success">
              <a class="nav-link active text-white" aria-current="page" href="/num">CMSS/ONEE</a>
              {{-- <a class="nav-link active text-white position-absolute top-0 end-0" aria-current="page" href="@if(auth()->user()->mle == '84644') dashboard @else # @endif ">{{auth()->user()->mle == '84644'? 'dashboard':auth()->user()->mle }} </a> --}}
              <a class="nav-link active text-white position-absolute top-0 end-0" aria-current="page"
               href="@if(auth()->user()->acc_type == 0)
                {{ route('searchmedi') }}
            @elseif(auth()->user()->acc_type == 1)
                {{ route('dashboard') }}
            @elseif(auth()->user()->acc_type == 2)
                {{ route('dashboard') }}
            @else
                {{ route('dashboard') }}
            @endif
            ">Table de board</a>

            </nav>
          </div>
        </div>
        <div class="card text-white bg-success position-absolute top-50 start-50 translate-middle">
            <div class="card-header">
            <div class="card-title">Veuillez fournir le numéro d'enregistrement</div>
            </div>

            <form action="" class="form-control" method="POST" id="numform">
            <div class="card-body">
            @if ($errors->any())
    <div class="alert alert-danger p-0">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
            @endif
                <div class="form-control">
                    
                        <label for="num_enreg">N° d'enregistrement : </label>
                        <input type="text" name="num" id="num_enreg">
                        @csrf
                   
                </div>
                
            </div>
            <div class="card-footer bg-transparent">
                <button type="submit" class="btn btn-success float-end">Suivant</button>
            </div>
        </form>
        </div>
    </div>
    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    {{-- <script src="js/dataTables.bootstrap5.min.js"></script> --}}
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/5d199dd585.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
        $("form").submit(async function(e) {
            e.preventDefault(); // Prevent the default form submission

            //const response = await fetch('http://127.0.0.1/api/ve/' + $("#num_enreg").val());
            //http://pharmacie.cmss/num
            const response = await fetch('http://10.12.90.91/api/ve/' + $("#num_enreg").val());
            if (!response.ok) {

            alert("le numéro d'enregistrement est déja exist");
            $("#num_enreg").focus();

            } else {
            // Allow the form to be submitted
            $(this).off("submit").submit();
            }
        });
        });
    </script>
</body>
</html>