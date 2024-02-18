<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="css/app.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
      {{-- Favicon link --}}
      <link rel="apple-touch-icon" sizes="180x180" href="images/favicon_io/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="images/favicon_io//favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="images/favicon_io//favicon-16x16.png">
      <link rel="manifest" href="images/favicon_io//site.webmanifest">
  
  <title>Controle Pharmacie</title>
</head>

<body>

<div class="container-fluid text-center">
    <div class="row">
      <div class="col nopadding">
        <nav class="nav text-bg-success"> 
          <a class="nav-link active text-white" aria-current="page" href="num">CMSS/ONEE</a>
          <a class="nav-link active text-white position-absolute top-0 end-0" aria-current="page" href="@if(auth()->user()->mle == '84644') /dashboard @else # @endif ">{{auth()->user()->mle == '84644'? 'table de bord':auth()->user()->mle }} </a>
        </nav>
      </div>
    </div>
    <div class="row full-height">
      <div class="col-4 d-flex flex-column justify-content-center align-items-center p-3 logobarcode">
        <figure class="figure">
          <img src="images/barcode-scanner.png" width="200" class="figure-img img-fluid rounded" alt="...">
          <figcaption class="figure-caption text-center fw-bolder">scanner le barre code de médicament</figcaption>
        </figure>
      </div>
      <div class="col-8 p-3 h-100 overflow-auto">
        <div class="row pt-3 pb-3">
          <div class="col-5">
            <div class="input-group">
              <form method="post" id="barcodeForm">
              <div class="input-group mb-3">
                  <input type="text" id="barcode" class="form-control">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                  </div>
                </div>
                <!-- <input class="form-control border-end-0 border" type="text" id="barcode"> -->
                
              </form>
              <!-- <span class="input-group-append">
                <button class="btn btn-disabled bg-white border-start-0 border ms-n3">
                  <img src="images/code-barre.png" alt="" width="20">
                </button>
              </span> -->
            </div>
      
            </div>
            <div class="col-3">
              <p class="align-middle"> N° Enregistrement  : <b> {{$num}}</b></p>
             </div>
             <div class="col-2">
               <p class="align-middle"> MNR  : <b id="mnr"></b></p>
              </div>
              <div class="col-2">
               <p class="align-middle"> MR  : <b id="mr"></b></p>
              </div>
          
        </div>
        <table id="ordonnance" class="table table-bordered border-success p-3" style="width:100%">
          <thead>
            <tr>
              <th>CODE EAN13</th>
              <th>Nom Commercial</th>
              <th>Présentation</th>
              <th>PPV</th>
              <th>Classe thérapeutique</th>
              <th>Remboursement</th>
              <th>ANAM</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="bodytable">

          </tbody>
        </table>
      </div>
    </div>
    <div class="row align-items-end">
      <div class="col-2 bg-info p-3" id="counterdiv">
        00.00
      </div>
      <div class="col-2 bg-primary p-3" id="countermddiv">
        00.00
      </div>
      <div class="col-3 bg-success text-white p-3" id="ppvdiv">
        00.00
      </div>
      <div class="col-3 bg-danger text-white p-3" id="restornediv">
        00.00
      </div>
      <div class="col-2 bg-warning text-white p-0">
        <button class="nextbtn" onclick="newOrdannance()" id="newOrdonnance">Sauvegarder</button>
      </div>
    </div>
  </div>
  <script src="js/jquery-3.5.1.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  {{-- <script src="js/dataTables.bootstrap5.min.js"></script> --}}
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/5d199dd585.js" crossorigin="anonymous"></script>
  {{-- <script src="js/middleware.js" crossorigin="anonymous"></script> --}}
<script>
  var table = $('#ordonnance').DataTable({
    "paging":   false,
    "info":     false,
    "bFilter": false,
    "columnDefs": [{
      "targets": -1,
      "data": null,
      "defaultContent": "<button class='btn btn-danger delete-row'><img src='images/supprimer.png'/></button>"
    }],
    "language": {
      "emptyTable": "Scanner le barre code de médicament"
    }
  });
    var ppv = 0;
    var restourne = 0;
    const counterdiv = document.getElementById("counterdiv");
    const ppvdiv = document.getElementById("ppvdiv");
    const restornediv = document.getElementById("restornediv");
    const countermddiv = document.getElementById("countermddiv");
    const mr = document.getElementById("mr");
    const mnr = document.getElementById("mnr");
    var NbrBoit = 0;
    var MR = 0;
    var MNR = 0;
    
    var distinctCodes = [];
  $(document).ready(function() {
   
    $("#barcode").focus();
    


  $(document).on('click', '.delete-row', function() {
  const rowId = $(this).data('id');
  const row = $(this).closest('tr');
  const rowData = table.row(row).data();

  // remove the row from the table
  table.row(row).remove().draw(false);
  const htmlString = rowData[5];
  // Create a temporary element to parse the HTML string
  const tempElement = document.createElement('div');
  tempElement.innerHTML = htmlString;
  // Access the 'data-id' attribute value
  const dataId = tempElement.firstChild.getAttribute('data-id');
  // console.log( MR - parseFloat(rowData[3]));
  if (dataId === '1') {
    MR -= parseFloat(rowData[3]);
  }else if(dataId === '0'){
    MNR -= parseFloat(rowData[3]);
  }


  // update PPV and returned amount
  if (rowData[3] !== "") {
    ppv -= parseFloat(rowData[3]);
    restourne = (ppv - parseFloat(ppv * 0.1));
  }

  // update counters
  NbrBoit--;
  ppvdiv.innerHTML = "Montant total : " + "<strong>" + ppv.toFixed(2) + " DH" + "</strong>";
  restornediv.innerHTML = "Montant total ristourne : " + "<strong>" + restourne.toFixed(2) + " DH" + "</strong>";
  mr.innerHTML = MR.toFixed(2);
  mnr.innerHTML = MNR.toFixed(2);

  // remove the EAN13 code from the distinctCodes array
  const index = distinctCodes.indexOf(rowData[0]);
  if (index > -1) {
    distinctCodes.splice(index, 1);
  }

  // update the "Nombre médicaments" counter
  const countermddiv = document.getElementById("countermddiv");
  let count = 0;
  for (let i = 0; i < table.rows().count(); i++) {
    const data = table.row(i).data();
    if (data[0] === rowData[0]) {
      count++;
    }
  }
  if (count === 0) {
    const index = distinctCodes.indexOf(rowData[0]);
    if (index > -1) {
      distinctCodes.splice(index, 1);
    }
    countermddiv.innerHTML = "Nombre Boîtier: " + "<strong>" + NbrBoit + "</strong>";
    counterdiv.innerHTML = "Nombre médicaments: " + "<strong>" + distinctCodes.length + "</strong>";
  } else {
    countermddiv.innerHTML = "Nombre Boîtier: " + "<strong>" + NbrBoit + "</strong>";
  }
});


$("#barcodeForm").on("submit", function(e){
  let barcode = $("#barcode").val();
    e.preventDefault();
    if($('#barcode').val() != ""){

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': '{{csrf_token()}}'
    },

      url: '/',
      type: 'POST',
      data: {
        "barcode": barcode,
      },
      success: function(response) {
        var data = JSON.parse(response); 


          ppv += parseFloat(data.PPV);
          restourne = (ppv - parseFloat(ppv * 0.1));
          if (!distinctCodes.includes(data.CODE_EAN13)) {
            distinctCodes.push(data.CODE_EAN13);
          }
          ++NbrBoit;  

       // console.log(data.remb ,data.is_anam);
        var is_anam,is_remb;
        if (data.remb === 1) {
          is_remb = "<span class='badge bg-success' data-id='1'>MR</span>";
          MR += parseFloat(data.PPV.toFixed(2))*0.90;
          

        }else{
          is_remb = "<span class='badge bg-danger' data-id='0'>MNR</span>";
          MNR += parseFloat(data.PPV.toFixed(2))*0.90;
          
       
        }
        //console.log("MR = " + MR +"\n"+ "MNR = " + MNR);

        if (data.is_anam === 1) {
          is_anam = "<span class='badge bg-success'>ANAM</span>";
        }else{
          is_anam = "<span class='badge bg-danger'>HORS ANAM</span>";
        }
        table.row.add([

          data.CODE_EAN13,
          data.Nom_Commercial,
          data.Presentation,
          data.PPV,
          data.Classe,
          is_remb,
          is_anam,
        ]).draw(false);
        $("#barcode").val("");
        
        ppvdiv.innerHTML = "Montant total : " + "<strong>" + ppv.toFixed(2) + " DH" + "</strong>";
        restornediv.innerHTML = "Montant total ristourne : " + "<strong>" + restourne.toFixed(2) + " DH" + "</strong>";
        counterdiv.innerHTML = "Nombre médicaments: "+"<strong>"+distinctCodes.length+"</strong>";
        countermddiv.innerHTML = "Nombre Boîtier: " + "<strong>" + NbrBoit+"</strong>";
        mr.innerHTML = MR + " DH";
        mnr.innerHTML = MNR + " DH";
      },
      error: function(jqXHR, textStatus, errorThrown) {
        if(jqXHR.status === 404 )
        var newRow = table.row.add([
          barcode,
            "",
            "",
            "",
            "",
            "",
            "",
          ],
          
          ).draw(false).node();
          $(newRow).addClass('bg-danger text-white');
          $("#barcode").val("");
          ++NbrBoit;
          if (!distinctCodes.includes(barcode)) {
            distinctCodes.push(barcode);
          }
          countermddiv.innerHTML = "Nombre Boîtier: " + "<strong>" + NbrBoit+"</strong>";
          counterdiv.innerHTML = "Nombre médicaments: "+"<strong>"+distinctCodes.length+"</strong>";
        }

        
      });
    };
  });
  
});

  

    function newOrdannance(){
      var ord = table.column( 0 ).data().toArray();
      //var ord = table.column( 1 ).data().toArray();

      

      $.ajax({
      headers: {
        'X-CSRF-TOKEN': '{{csrf_token()}}'
    },

      url: 'ordonnance/new',
      type: 'POST',
      data: {
        "ord":ord,
        "num_eng": '{{$num}}',
        "total_ppv": ppv,
        "total_res": restourne  

      },
      success: function(response) {
       // var data = JSON.parse(response);
        window.location = "num"

      },
      error: function(jqXHR, textStatus, errorThrown) {
 
        }

        
      });
    

    }


 
 
</script>
</body>


</html>