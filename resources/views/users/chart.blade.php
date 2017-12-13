@extends('layouts.newdashboard')

@section('content')
<div class="content-wrapper">
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
                        <h3 class="box-title">PHC Household </h3>

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

                <!-- DONUT CHART -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gender Chart</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="pieChart" style="height: 300px;"></div>
                    </div>
                     
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            <!-- /.col (LEFT) -->
            <div class="col-md-6">
                <!-- BAR CHART -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">PHC Individual Health Records</h3>

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
                
                <!-- LINE CHART -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">NCD Burden</h3>

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
            <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<script type="text/javascript" src="{{ asset('/js/pluginjs/float/jquery.flot.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/pluginjs/float/jquery.flot.pie.js') }}"></script>

<script>
$(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

  
 

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
//    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
//    var pieChart = new Chart(pieChartCanvas)
    var PieData = [
        {
            data: '<?php echo $details['piechart'][0]->hbp;?>',
            color: '#f56954',
            highlight: '#f56954',
            label: 'HBP',
            labelColor : 'white',
            labelFontSize : '5'
        },
        {
            data: '<?php echo $details['piechart'][0]->diag;?>',
            color: '#00a65a',
            highlight: '#00a65a',
            label: 'Diabetes',
            labelColor : 'white',
            labelFontSize : '10'
        },
        {
            data: '<?php echo $details['piechart'][0]->cancer;?>',
            color: '#f39c12',
            highlight: '#f39c12',
            label: 'Cancer',
             
            labelColor : 'white',
            labelFontSize : '10'
        },
        {
            data: '<?php echo $details['piechart'][0]->COPD;?>',
            color: '#00c0ef',
            highlight: '#00c0ef',
            label: 'COPD'
        },
        {
            data:'<?php echo $details['piechart'][0]->cvd;?>',
            color: '#3c8dbc',
            highlight: '#3c8dbc',
            label: 'CVD',
            labelColor : 'white',
            labelFontSize : '10'
        }
    ]
    
    
    var genderData = [
        {
            data: '<?php echo $details['malecount'];?>',
            color: '#f56954',
             labelAlign : 'left',
            label: 'MALE',
            labelColor : 'white',
            labelFontSize : '12'
        },
        {
            data: '<?php echo $details['femalecount'];?>',
            color: '#00a65a',
            labelAlign : 'left',
            label: 'FEMALE',
            labelColor : 'white',
            labelFontSize : '12'
        },
        
    ]
 
    var pieOptions =  {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
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
    //Gender pie chart 
    $.plot('#pieChart', genderData,pieOptions)
 
    //cancer pie chart
    $.plot('#pieChart2', PieData,pieOptions)
 

    //-------------
    //- BAR CHART -
    //-------------
     var barChartCanvas2 = $('#barChart2').get(0).getContext('2d');
    var barChart2 = new Chart(barChartCanvas2);
    
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChart = new Chart(barChartCanvas)
 
    var barChartOptions = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - If there is a stroke on each bar
        barShowStroke: true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth: 1,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,
        //String - A legend template
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        //Boolean - whether to make the chart responsive
        responsive: true,
        maintainAspectRatio: true
    }

    barChartOptions.datasetFill = false
    
    var phcdata = {
        labels: [<?php echo '"'.implode('","', $details['phclabel']).'"' ?>],
        datasets: [
            {
                label: 'Electronics',
                fillColor: 'rgba(245,105,84, 0.7)',
                strokeColor: 'rgba(210, 214, 222, 1)',
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [<?php echo '"'.implode('","', $details['phcdata']).'"' ?>],
                  
            }
        ]
    }
    barChart.Bar(phcdata, barChartOptions)
    
    
       var ashaphcdata = {
        labels: [<?php echo '"'.implode('","', $details['ashaphclabel']).'"' ?>],
        datasets: [
            {
                label: 'Electronics',
                fillColor: 'rgba(243, 156, 18,0.8)',
                strokeColor: 'rgba(210, 214, 222, 1)',
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [<?php echo '"'.implode('","', $details['ashaphcdata']).'"' ?>]
            }
        ]
    }
    barChart2.Bar(ashaphcdata, barChartOptions)
})
        </script>
@endsection

