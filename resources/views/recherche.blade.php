<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/app.css">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
          <div class="col nopadding">
            <nav class="nav text-bg-success">
              <a class="nav-link active text-white" aria-current="page" href="#">CMSS/ONEE</a>
    
            </nav>
          </div>
        </div>
        <div class="card position-absolute top-50 start-50 translate-middle">
            <div class="card-header">
            <div class="card-title">Saissi N° d'Enregistrement</div>
            </div>
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
            @endif
            <form action="" class="form-control" method="POST">
            <div class="card-body">
                <div class="form-control">
                    
                        <label for="num_enreg">N° d'Enregistrement : </label>
                        <input type="text" name="num" id="num_enreg">
                        @csrf
                   
                </div>
                
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success float-end">Sauvegarder</button>
            </div>
        </form>
        </div>
    </div>
</body>
</html>