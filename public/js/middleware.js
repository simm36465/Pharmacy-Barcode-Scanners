$(document).ready(function() {

  var table = $('#example').DataTable({
    "paging":   false,
    "info":     false,
    "bFilter": false,
    "columnDefs": [{
      "targets": -1,
      "data": null,
      "defaultContent": "<button class='delete-row'><i class='fa fa-trash'></i></button>"
    }],
    "language": {
      "emptyTable": "Scanner le barre code de médicament"
    }
  });
  var NbrBoit = 0;
  var ppv = 0;
  var restourne = 0;
  var distinctCodes = [];

  
  $('#barcodeForm').on('submit', function(e) {
    e.preventDefault(); // prevent form from reloading page
    console.log('form submited');
    const input = document.getElementById("barcode").value;
    const counterdiv = document.getElementById("counterdiv");
    const ppvdiv = document.getElementById("ppvdiv");
    const restornediv = document.getElementById("restornediv");
    const countermddiv = document.getElementById("countermddiv");

    //console.log(input);
    $.ajax({
      url: 'inc/server.php',
      type: 'POST',
      data: {
        "CODE_EAN": input,
      },
      success: function(response) {
        var data = JSON.parse(response);
        
        console.log(data);
        // do something if submission is successful
        // if (data.status !== '404') {

        //   ppv += parseFloat(data.PPV);
        //   restourne = (ppv - parseFloat(ppv * 0.1));
        //   if (!distinctCodes.includes(data.CODE_EAN13)) {
        //     distinctCodes.push(data.CODE_EAN13);
        //   }
        //  //distinctCodes.push(data.CODE_EAN13);
        //   ++NbrBoit;  

        // table.row.add([

        //   data.CODE_EAN13,
        //   data.Nom_Commercial,
        //   data.Presentation,
        //   data.PPV,
        //   data.Classe
        // ]).draw(false);

        // ppvdiv.innerHTML = "Montant total : " + "<strong>" + ppv.toFixed(2) + " DH" + "</strong>";
        // restornediv.innerHTML = "Montant total ristourne : " + "<strong>" + restourne.toFixed(2) + " DH" + "</strong>";
        // counterdiv.innerHTML = "Nombre médicaments: "+"<strong>"+distinctCodes.length+"</strong>";
        // countermddiv.innerHTML = "Nombre Boîtier: " + "<strong>" + NbrBoit+"</strong>";
        // }else{
        //   ++NbrBoit;
        //   var newRow = table.row.add([
        //     input,
        //     "",
        //     "",
        //     "",
        //     "",
        //   ]).draw(false).node();
        //   $(newRow).addClass('bg-danger text-white');
        //   if (!distinctCodes.includes(input)) {
        //     distinctCodes.push(input);
        //   }
        //   countermddiv.innerHTML = "Nombre Boîtier: " + "<strong>" + NbrBoit+"</strong>";
        //   counterdiv.innerHTML = "Nombre médicaments: "+"<strong>"+distinctCodes.length+"</strong>";
        // }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error(errorThrown);
      }
    });

    // reset form after submission
    $('#barcodeid')[0].reset();
  });


$(document).on('click', '.delete-row', function() {
  const rowId = $(this).data('id');
  const row = $(this).closest('tr');
  const rowData = table.row(row).data();

  // remove the row from the table
  table.row(row).remove().draw(false);

  // update PPV and returned amount
  if (rowData[3] !== "") {
    ppv -= parseFloat(rowData[3]);
    restourne = (ppv - parseFloat(ppv * 0.1));
  }

  // update counters
  NbrBoit--;
  ppvdiv.innerHTML = "Montant total : " + "<strong>" + ppv.toFixed(2) + " DH" + "</strong>";
  restornediv.innerHTML = "Montant total ristourne : " + "<strong>" + restourne.toFixed(2) + " DH" + "</strong>";

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


});



