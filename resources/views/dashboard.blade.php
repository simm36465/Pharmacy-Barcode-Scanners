@extends('layouts.dashboard')
@section('content')
    <!-- Info boxes -->
    <div class="row">
        <!-- Add your content here -->

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-pills"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Nombre de médicaments</span>
                    <span class="info-box-number">
                        {{ $nbrMed }}

                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hand-holding-heart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">médicaments ANAM</span>
                    <span class="info-box-number">{{ $medAnam }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding-medical"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">médicaments Hors ANAM</span>
                    <span class="info-box-number">{{ $medNonAnam }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hospital-user"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Nombre des ordonnances</span>
                    <span class="info-box-number">{{ $ordCount }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Les statistiques</h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <p class="text-center">
                                <strong>Les statistiques ANAM et HORS ANAM</strong>
                            </p>

                            <div class="progress-group">
                                Nombre d'ordonnances ANAM
                                <span class="float-right"><b>{{ $HRAordCount }}</b></span>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ number_format(($HRAordCount * 100) / $ordCount, 2) }}%">
                                        {{ number_format(($HRAordCount * 100) / $ordCount, 2) }}%</div>
                                </div>
                            </div>
                            <div class="progress-group">
                                Nombre d'ordonnances HORS ANAM
                                <span class="float-right"><b>{{ $ANAMordCount }}</b></span>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-danger"
                                        style="width: {{ number_format(($ANAMordCount * 100) / $ordCount, 2) }}%">
                                        {{ number_format(($ANAMordCount * 100) / $ordCount, 2) }}%</div>
                                </div>
                            </div>
                            <div class="progress-group">
                                Nombre d'ordonnances contenant ANAM et HORS ANAM
                                <span class="float-right"><b>{{ $ordCount - ($ANAMordCount + $HRAordCount) }}</b></span>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-warning"
                                        style="width: {{ number_format((($ordCount - ($ANAMordCount + $HRAordCount)) * 100) / $ordCount, 2) }}%">
                                        {{ number_format((($ordCount - ($ANAMordCount + $HRAordCount)) * 100) / $ordCount, 2) }}%
                                    </div>
                                </div>
                            </div>
                            <!-- /.progress-group -->



                            <!-- /.progress-group -->
                        </div>

                        <div class="col-md-4">
                            {{-- <div class="info-box mb-3 bg-warning">
                          <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                          <div class="info-box-content">
                          <span class="info-box-text">Nombre d'ordonnances ANAM</span>
                          <span class="info-box-number">{{$HRAordCount}}</span>
                          </div>
                          
                          </div> --}}
                            <div class="card-body">
                                <canvas id="pieChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>


                        <!-- /.col -->
                        <div class="col-md-4">
                            <p class="text-center">
                                <strong>Les statistiques des médicaments</strong>
                            </p>

                            <div class="progress-group">
                                Pourcentage médicaments Remboursables <strong>({{$medRemb}})</strong>
                                <span class="float-right"><b>{{ number_format(($medRemb * 100) / $nbrMed, 2) }}
                                        %</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary"
                                        style="width: {{ number_format(($medRemb * 100) / $nbrMed, 2) }}%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->

                            <div class="progress-group">
                                Pourcentage médicaments Non Remboursables <strong>({{$medNonRemb}})</strong>
                                <span class="float-right"><b>{{ number_format(($medNonRemb * 100) / $nbrMed, 2) }}
                                        %</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger"
                                        style="width: {{ number_format(($medNonRemb * 100) / $nbrMed, 2) }}%"></div>
                                </div>
                            </div>

                            <div class="progress-group">
                                Pourcentage médicaments ANAM <strong>({{$medAnam}})</strong>
                                <span class="float-right"><b>{{ number_format(($medAnam * 100) / $nbrMed, 2) }}
                                        %</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning"
                                        style="width: {{ number_format(($medAnam * 100) / $nbrMed, 2) }}%"></div>
                                </div>
                            </div>

                            <div class="progress-group">
                                Pourcentage médicaments Hors ANAM <strong>({{$medNonAnam}})</strong>
                                <span class="float-right"><b>{{ number_format(($medNonAnam * 100) / $nbrMed, 2) }}
                                        %</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ number_format(($medNonAnam * 100) / $nbrMed, 2) }}%"></div>
                                </div>
                            </div>


                            <!-- /.progress-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">

                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                {{-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span> --}}
                                <h5 class="description-header">MTT TOTAL ORDONNACES</h5>
                                <span class="description-text">{{ number_format($ordSum, 2) }} dh</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                {{-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span> --}}
                                <h5 class="description-header">MTT TOTAL MNR</h5>
                                <span class="description-text">{{ number_format($MNRTotal, 2) }} dh</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                {{-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i>TOTAL ANAM</span> --}}
                                <h5 class="description-header">MTT TOTAL ANAM</h5>
                                <span class="description-text">{{ number_format($AnamTotal, 2) }} dh</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block">
                                {{-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> TOTAL HORS ANAM</span> --}}
                                <h5 class="description-header">MTT TOTAL HORS ANAM</h5>
                                <span class="description-text">{{ number_format($HorsAnamTotal, 2) }} dh</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">


            <div class="card">
                <div class="card-header border-transparent bg-danger">
                    <h3 class="card-title"><b>Ordonnances comprenant un Nombre Élevé de Médicaments</b></h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0" id="table1">
                            <thead>
                                <tr>

                                    <th>Num Enregistrement</th>
                                    <th>Nombre medicaments</th>
                                    <th>Nombre de Boite</th>
                                    <th>Total ristourne (10%)</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ordonanceMediandBoiteCounts as $item)
                                    <tr>
                                        <td>{{ $item->num_eng }}</td>
                                        <td>{{ $item->medicament_count }}</td>
                                        <td>{{ $item->ordinance_count }}</td>
                                        <td>{{ number_format($item->total_r, 2) }} DH</td>


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
                <!-- /.card -->
            </div>


        </div>
        <div class="col-md-6">


            <div class="card">
                <div class="card-header border-transparent bg-danger">
                    <h3 class="card-title"><b>Ordonnances comprenant un Montant Élevé</b></h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 cell-border" id="table2">
                            <thead>
                                <tr>

                                    <th>Num Enregistrement</th>
                                    <th>Total</th>
                                    <th>Total ristourne (10%)</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ordonancesTopTotal as $item)
                                    <tr>
                                        <td>{{ $item->num_eng }}</td>
                                        <td>{{ number_format($item->total, 2) }} DH</td>
                                        <td>{{ number_format($item->total_r, 2) }} DH</td>


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
                <!-- /.card -->
            </div>


        </div>
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-12">
            <!-- MAP & BOX PANE -->

            <!-- /.card -->
            <div class="row">
                <div class="col-md-6">

                    <!--/.direct-chat -->
                </div>
                <!-- /.col -->

                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
                <div class="card-header border-transparent bg-warning">
                    <h3 class="card-title"><b>Les médicaments plus prescrits</b></h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0" id="table2">
                            <thead>
                                <tr>

                                    <th>Code</th>
                                    <th>Nom Commercial</th>
                                    <th>ANAM</th>
                                    <th>Remboursable</th>
                                    <th>Nombre</th>
                                    <th>PPV</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sortedbynbrCodeCounts as $item)
                                    <tr>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->Nom_Commercial }}</td>
                                        <td>
                                            @if ($item->is_anam == 1)
                                                <span class="badge badge-success">Anam</span>
                                            @else
                                                <span class="badge badge-danger">Hors Anam</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->remb == 1)
                                                <span class="badge badge-success">MR</span>
                                            @else
                                                <span class="badge badge-danger">MNR</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->code_count }}</td>
                                        <td>{{ $item->PPV }}</td>
                                        <td>{{ number_format($item->total,2) }} dh</td>

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
                <!-- /.card -->
            </div>
            <!-- /.col -->


        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Les statistiques des utilisateurs</h5>
                </div>
                <div class="card-body">

                    <p class="text-center">
                        <strong>Statistiques des utilisateurs jusq'au : @php echo Date("d-m-Y") @endphp</strong>

                    </p>

                    <table class="table m-2" id="table3">
                        <thead>
                            <tr>

                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Nombre d'ordonnances</th>
                                <th>Nombre d'Aujourd'hui</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userCounts as $row)
                                <tr>
                                    <td>{{ $row->Matricule }}</td>
                                    <td>{{ $row->Nom }}</td>
                                    <td>{{ $row->Nombre_d_ordonnances }}</td>
                                    {{-- Check if Nombre_d_Aujourd_hui is greater than 0 --}}
                                    @if ($row->Nombre_d_Aujourd_hui > 0)
                                        <td><span class="description-percentage text-success"><i
                                                    class="fas fa-caret-up"></i> {{ $row->Nombre_d_Aujourd_hui }}</span>
                                        </td>
                                    @else
                                        {{-- If Nombre_d_Aujourd_hui is 0 or less --}}
                                        <td><span class="description-percentage text-warning"><i
                                                    class="fas fa-caret-left"></i> {{ $row->Nombre_d_Aujourd_hui }}</span>
                                        </td>
                                    @endif


                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <!-- /.chart-responsive -->

                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection
@section('dash_script')
    <script>




        var donutData = {
            labels: [
                'ANAM',
                'HORS ANAM',
                'MNR'

            ],
            datasets: [{


                data: [{{ $AnamTotal }}, {{ $HorsAnamTotal }}, {{ $MNRTotal }}],
                backgroundColor: ['#00c0ef', '#3c8dbc', '#d2d6de'],
            }]
        }
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData = donutData;
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                            return previousValue + currentValue;
                        });
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = ((currentValue / total) * 100).toFixed(2);

                        // Adjusted label to include category and calculated percentage
                        var category = data.labels[tooltipItem.index];
                        var calculatedPercentage = '(' + (currentValue / {{ $ordSum }} * 100).toFixed(2) +
                            '%)';

                        return category + ': ' + calculatedPercentage;
                    },
                },
            },
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })


        // //-------------
        // //- BAR CHART -
        // //-------------

        // Format data for JavaScript
        var labels = [];
        var totals = [];
        var mnr = [];
        var mr = [];
        @foreach ($totalsByMonthYear as $data)


            var dateObject = new Date({{ $data->ord_year }}, {{ $data->ord_month }} - 1, 1);
            var formattedDate = dateObject.toLocaleString('fr-FR', {
                month: 'short',
                year: 'numeric'
            });
            labels.push(formattedDate);
            totals.push({{ $data->TOTAL }});
            mnr.push({{ $data->MNR }})
            mr.push({{ $data->MR }})
        @endforeach
        // console.log(totals);
        // console.log(mnr);
        // console.log(mr);
        var areaChartData = {
            labels: labels,
            datasets: [{
                    label: 'Total',
                    backgroundColor: 'rgba(40, 167, 69, 1)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    pointRadius: false,
                    pointColor: '#28a745',
                    pointStrokeColor: 'rgba(40, 167, 69, 1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(40, 167, 69, 1)',
                    data: totals
                },
                {
                    label: 'MNR',
                    backgroundColor: 'rgba(220, 53, 69, 1)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(220, 53, 69, 1)',
                    pointStrokeColor: '#dc3545',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220, 53, 69, 1)',
                    data: mnr
                }, {
                    label: 'MR',
                    backgroundColor: 'rgba(253, 126, 20, 1)',
                    borderColor: 'rgba(253, 126, 20, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(253, 126, 20, 1)',
                    pointStrokeColor: '#fd7e14',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(253, 126, 20, 1)',
                    data: mr
                },
            ]
        }
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false,

        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })



        $('#table1').dataTable({
            "searching": false,
            "paging": false,
            "ordering": true,
            "bInfo": false,
            "pageLength": 20
        });
        $('#table2').dataTable({
            "searching": false,
            "paging": false,
            "ordering": true,
            "bInfo": false,
            "pageLength": 20
        });
        $('#table3').dataTable({
            "searching": false,
            "paging": false,
            "ordering": true,
            "bInfo": false,
            "pageLength": 20
        });

    </script>
@endsection
