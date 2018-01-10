@extends('layouts.newdashboard')

@section('content')
<div class="content-wrapper" style="padding: 15px 25px;">
    <div class="row">
        <div class="col-md-8">
            <div class="row">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        NCD Reports

                    </h1>


                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-6">
                             <!-- AREA CHART -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Total Households Registered</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="barChart" style="height:230px"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                            
                        </div>
                        <div class="col-md-6">
                             <!-- BAR CHART -->
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Total Individual Screened</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>

                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="barChart2" style="height:230px"></canvas>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-6">
                             <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Screening:  Gender Wise</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>

                                    </div>
                                </div>
                                <div class="box-body">
                                    
                                    <canvas id="gender"></canvas>


                                </div>

                                <!-- /.box-body -->
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Total NCD Burden</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>

                                    </div>
                                </div>
                                <div class="box-body">
                                    <!--                            <div id="pieChart" style="height: 300px;"></div>-->
                                    <canvas id="gender2"></canvas>


                                </div>

                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                          <!-- LINE CHART -->
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Total NCD Burden</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>

                                    </div>
                                </div>
                                <div class="box-body">
                                    <div id="pieChart2" style="height: 300px;"></div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                    </div>    
                   
                    <!-- /.row -->

                </section>
                <!-- /.content -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="pull-right">
              





            </div>
            <p class="bold-text">Total house holds registered</p>
            <p class="box-strip bold-text"> {{array_sum($details['phcdata'])}}</p>
            <p class="bold-text">Total individual records (IR) created</p>
            <p class="box-strip bold-text">{{array_sum($details['ashaphcdata'])}}</p>
            <p class="bold-text">Total IR with Diabetes</p>
            <p class="box-strip bold-text">{{$details['piechart'][0]->diag}}</p>
            <p class="bold-text">Total IR with High BP</p>
            <p class="box-strip bold-text">{{$details['piechart'][0]->hbp}}</p>
            <p class="bold-text">Total IR with Cancer</p>
            <p class="box-strip bold-text">{{$details['piechart'][0]->cancer}}</p>
            <p class="bold-text">Total IR with COPD</p>
            <p class="box-strip bold-text">{{$details['piechart'][0]->COPD}}</p>
            <p class="bold-text">Total IR with CVD</p>
            <p class="box-strip bold-text">{{$details['piechart'][0]->cvd}}</p>
             
            <p class="bold-text">Total IR with any of the above diseases</p>
            <p class="box-strip bold-text">
<!--               {$details['cvdgroup']["count_details"][0]->diseases_count-->
    10
            </p>
            <p class="bold-text">Refer to Doctor</p>
            <p class="box-strip bold-text">10</p>
            <p class="bold-text">ANM Follow Ups count</p>
            <p class="box-strip bold-text">{{$details['cvdgroup']["count_details"][0]->followup_count}}</p>
            <p class="bold-text">Doctor Follow ups count</p>
            <p class="box-strip bold-text">{{$details['cvdgroup']["count_details"][0]->docotor_count}}</p>
        </div>
    </div>
</div>
<style>
    .box-strip{
        background: #7f4992;
        text-align: center;
        border-radius: 5px;
        color: #fff;
        font-size: 25px;
        padding: 12px;
    }
    .bold-text{
        font-weight: 600;
         
    }
</style>
<script type="text/javascript" src="{{ asset('/js/pluginjs/float/jquery.flot.js') }}"></script>

<script type="text/javascript" src="{{ asset('/js/pluginjs/Chartv2.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/pluginjs/utils.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/pluginjs/float/jquery.flot.pie.js') }}"></script>
<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
</style>
<script>
$(function () {
 




    //-------------
    //- PIE CHART -
    //-------------
 
    var PieData = [
        {
            data: '<?php echo $details['piechart'][0]->hbp; ?>',
            color: '#f56954',
            highlight: '#f56954',
            label: 'HBP- '+'<?php echo $details['piechart'][0]->hbp; ?>',
            labelColor: 'white',
            labelFontSize: '5'
        },
        {
            data: '<?php echo $details['piechart'][0]->diag; ?>',
            color: '#00a65a',
            highlight: '#00a65a',
            label: 'DM - '+'<?php echo $details['piechart'][0]->diag; ?>',
            labelColor: 'white',
            labelFontSize: '10'
        },
        {
            data: '<?php echo $details['piechart'][0]->cancer; ?>',
            color: '#f39c12',
            highlight: '#f39c12',
            label: 'Cancer - '+'<?php echo $details['piechart'][0]->cancer; ?>',

            labelColor: 'white',
            labelFontSize: '10'
        },
        {
            data: '<?php echo $details['piechart'][0]->COPD; ?>',
            color: '#00c0ef',
            highlight: '#00c0ef',
            label: 'COPD - '+'<?php echo $details['piechart'][0]->COPD; ?>',
        },
        {
            data: '<?php echo $details['piechart'][0]->cvd; ?>',
            color: '#3c8dbc',
            highlight: '#3c8dbc',
            label: 'CVD - ' + '<?php echo $details['piechart'][0]->cvd; ?>',
            labelColor: 'white',
            labelFontSize: '10'
        }
    ]


 

    var pieOptions = {
        series: {
            pie: {
                show: true,
                radius: 1,
                innerRadius: 0.5,
                label: {
                    show: true,
                    radius: 2 / 3,
                    formatter: labelFormatter,
                    threshold: 0.1
                }

            }
        },
        legend: {
            show: false
        }
    };
    /*
     * Custom Label formatter
     * ----------------------
     */
    function labelFormatter(label, series) { 
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
                + label
                + '<br>'
                + '</div>'
    }
 

    //cancer pie chart
    $.plot('#pieChart2', PieData, pieOptions)
 

})
</script>
<script>
    var genderChartData = {
        labels: [<?php echo '"' . implode('","', $details['genderphc']) . '"' ?>],
        datasets: [{
                label: 'MALE',
                backgroundColor: window.chartColors.red,
                data: [<?php echo '"' . implode('","', $details['malecount']) . '"' ?>]
            }, {
                label: 'FEMALE',
                backgroundColor: window.chartColors.blue,
                data: [<?php echo '"' . implode('","', $details['femalecount']) . '"' ?>]
            }, ]

    };
    window.onload = function () {
        var ctx = document.getElementById("gender").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: genderChartData,
            options: {

                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                responsive: true,
                scales: {
                    xAxes: [{
                            stacked: true,
                        }],
                    yAxes: [{
                            stacked: true
                        }]
                }
            }
        });


        //House hold related graph
        var phcdata = {
            labels: [<?php echo '"' . implode('","', $details['phclabel']) . '"' ?>],
            datasets: [
                {label: 'HouseHold count',
                    backgroundColor: window.chartColors.orange,
                    data: [<?php echo '"' . implode('","', $details['phcdata']) . '"' ?>],

                }
            ]
        }
        var householdgraph = document.getElementById("barChart").getContext("2d");
        window.myBar = new Chart(householdgraph, {
            type: 'bar',
            data: phcdata,
            options: {

                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                responsive: true,
                barThickness:2
            }
        });

        //cfbc table related screening count
        var ashaphcdata = {
            labels: [<?php echo '"' . implode('","', $details['ashaphclabel']) . '"' ?>],
            datasets: [
                {
                    label: 'Asha Screening Count',
                    backgroundColor: window.chartColors.purple,
                    data: [<?php echo '"' . implode('","', $details['ashaphcdata']) . '"' ?>]
                }
            ]
        }
        var ashagraph = document.getElementById("barChart2").getContext("2d");
        window.myBar = new Chart(ashagraph, {
            type: 'bar',
            data: ashaphcdata,
            options: {

                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                responsive: true,

            }
        });
        
        var barChartData = {
            labels: [<?php echo '"' . implode('","', $details['cvdgroup']['phc_name']) . '"' ?>],
            datasets: [{
                label: 'CVD',
                backgroundColor: window.chartColors.red,
                data: [<?php echo '"' . implode('","', $details['cvdgroup']['cvd']) . '"' ?>]
            },
            {
                label: 'HBP',
                backgroundColor: window.chartColors.orange,
                data: [<?php echo '"' . implode('","', $details['cvdgroup']['hbp']) . '"' ?>]
            },
            {
                label: 'DM',
                backgroundColor: window.chartColors.yellow,
                data: [<?php echo '"' . implode('","', $details['cvdgroup']['diag']) . '"' ?>]
            },
            {
                label: 'Cancer',
                backgroundColor: window.chartColors.green,
                data: [<?php echo '"' . implode('","', $details['cvdgroup']['cancer']) . '"' ?>]
            },
            {
                label: 'COPD',
                backgroundColor: window.chartColors.blue,
                data: [<?php echo '"' . implode('","', $details['cvdgroup']['copd']) . '"' ?>]
            }        
            ]  

        };
         var ctx2 = document.getElementById("gender2").getContext("2d");
            window.myBar = new Chart(ctx2, {
                type: 'bar',
                data: barChartData,
                options: {
                   
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
    };


</script>
@endsection

