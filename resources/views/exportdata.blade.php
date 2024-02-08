@extends('layouts.dashboard')

@section('content')
<!-- Info boxes -->
<div class="row">
    <!-- Add your content here -->
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header bg-primary">
                <h3 class="card-title">Exporte les données</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table border="0" cellspacing="5" cellpadding="5">
                    <tbody>
                        <tr>
                            <td>date début :</td>
                            <td><input type="text" id="min" name="min"></td>
                            <td>date fin :</td>
                            <td><input type="text" id="max" name="max"></td>
                        </tr>
                        <!-- <tr>
                            <td>date fin:</td>
                            <td><input type="text" id="max" name="max"></td>
                        </tr> -->
                    </tbody>
                </table>

                <table id="example1" class="display nowrap table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Numéro enregistrement</th>
                            <th>Code EAN13</th>
                            <th>Nom Commercial</th>
                            <th>Prix</th>
                            <th>Total d'ordonance</th>
                            <th>Total d'ordonance restoune</th>
                            <th>Agent</th>
                            <th>Date création</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exportdata as $item)
                        <tr>
                            {{-- <td>{{ $item["ord"]->id }}</td> --}}
                            {{-- <td>
                                @foreach (json_decode($item->code, true) as $codeItem)
                                    @php
                                        $name = reset($codeItem);
                                        $decodedName = html_entity_decode($name, ENT_QUOTES | ENT_HTML5);
                                    @endphp
                                    <ul>
                                        <li> {{ $decodedName }} </li>
                                    </ul>
                           
                              
                                @endforeach
                            </td> --}}
                            {{-- <td>{{ $item->code}}</td> --}}
                            <td>{{ $item["ord"]->num_eng }}</td>
                            <td>{{ $item["ord"]->code }}</td>
                            <td>{{ isset($item["gmr"]->Nom_Commercial) ? $item["gmr"]->Nom_Commercial : "" }}</td>
                            <td>{{ isset($item["gmr"]->PPV) ? number_format( $item["gmr"]->PPV,2) : "" }}</td>
                            {{-- <td>{{number_format( $item["gmr"]->PPV,2) }}</td> --}}
                            <td>{{number_format( $item["ord"]->total,2) }}</td>
                            <td>{{number_format($item["ord"]->total_r, 2)  }}</td>
                            <td>{{ $item["ord"]->user->mle }}</td>
                            <td> {{ date('Y-m-d', strtotime($item["ord"]->created_at)) }}
                            </td>
                            <!-- Add more columns as per your 'ordanances' table structure -->
                        </tr>
                    @endforeach
                       
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Numéro enregistrement</th>
                            <th>Code EAN13</th>
                            <th>Nom Commercial</th>
                            <th>Prix</th>
                            <th>Total d'ordonance</th>
                            <th>Total d'ordonance restoune</th>
                            <th>Agent</th>
                            <th>Date création</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<!-- /.row -->
@endsection
@section('exportmed_script')
<script>
    $(function() {
        // let minDate, maxDate;

        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


        // Custom filtering function which will search data in column four between two values
        let minDate, maxDate;
        DataTable.ext.search.push(function(settings, data, dataIndex) {

            let min = minDate.val();
            let max = maxDate.val();
            let date = new Date(data[6]);
            console.log(data[6]);

            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        });

        // Create date inputs
        minDate = new DateTime('#min', {
            format: 'MMMM Do YYYY'
        });
        maxDate = new DateTime('#max', {
            format: 'MMMM Do YYYY'
        });

        // DataTables initialisation
        let table = new DataTable('#example1');

        // Refilter the table
        document.querySelectorAll('#min, #max').forEach((el) => {
            el.addEventListener('change', () => table.draw());
        });



    });
</script>
@endsection