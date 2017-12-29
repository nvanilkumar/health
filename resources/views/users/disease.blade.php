@extends('layouts.newdashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">


                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Analytic Details</h3>


                        <!-- /.box-header -->
                        <div class="box-body" style="">
                            <div class="row">
                                
                                {{ Form::open(array('url' => url('/')."/disease")) }}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>ASHA</label>
                                        <select class="form-control select2 select2-hidden-accessible" 
                                                name="ashaselect"  id="ashaselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected">Choose Asha</option>
                                            @if(count($csdbasha) > 0)
                                           
                                            @foreach ($csdbasha as $asha)
                                                <option value="{{$asha->asha_assigned}}" > {{$asha->asha_assigned}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>PHC</label>
                                        <select class="form-control select2 select2-hidden-accessible" 
                                                name="phcselect"  id="phcselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected">Choose PHC</option>
                                            @if(count($analyticsphc) > 0)
                                            @foreach ($analyticsphc as $phc)
                                                <option value="{{$phc->phc_name}}" > {{$phc->phc_name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Village</label>
                                        <select class="form-control select2 select2-hidden-accessible" disabled 
                                                name="villageselect" id="villageselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected">Choose Village</option>

                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Date:</label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" 
                                                   id="datepicker" name="startdate">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Date:</label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" 
                                                   id="datepicker2" name="enddate">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>

                                <div class="col-md-2 pull-right" style=" margin: 24px 0px 0px;">

                                   
                                     <button type="submit" class="btn btn-info ">Set Filter</button>
                                    <button type="button" id="resetbutton" class="btn btn-default ">Reset</button>

                                </div>
                                {{ Form::close() }}
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                         
                            <div id="chartdiv"></div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->		
<script type="text/javascript" src="{{ asset('/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/pluginjs/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/pluginjs/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/js/pluginjs/amcharts/amcharts.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/pluginjs/amcharts/serial.js') }}" type="text/javascript"></script>

<script type="text/javascript" src="{{ asset('/js/pluginjs/jquery-ui.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/plugincss/jquery-ui.css') }}" />

<script type="text/javascript" src="{{ asset('/js/common.js') }}"></script>

<script>
    
    var data= '<?php echo json_encode($details['data']); ?>';
    var chartData=JSON.parse(data);
var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "patterns",
    "legend": {
        "useGraphSettings": true
    },
    "dataProvider": chartData ,
    "valueAxes": [{
        "integersOnly": true,
        "maximum": 20,
        "minimum": 1,
       
        "axisAlpha": 0,
        "dashLength": 5,
        "gridCount": 10,
        "position": "left",
        "title": "Count"
    }],
    "startDuration": 0.5,
    "graphs": [{
        "balloonText": "cvd in [[category]]: [[value]]",
        "bullet": "round",
        "title": "cvd",
        "valueField": "cvd",
        "fillAlphas": 0
    },{
        "balloonText": "hbp in [[category]]: [[value]]",
        "bullet": "round",
        "title": "hbp",
        "valueField": "hbp",
        "fillAlphas": 0
    },{
        "balloonText": "disease in [[category]]: [[value]]",
        "bullet": "round",
        "title": "disease",
        "valueField": "diag",
        "fillAlphas": 0
    },{
        "balloonText": "cancer in [[category]]: [[value]]",
        "bullet": "round",
        "title": "cancer",
        "valueField": "cancer",
        "fillAlphas": 0
    },{
        "balloonText": "copd in [[category]]: [[value]]",
        "bullet": "round",
        "title": "copd",
        "valueField": "copd",
        "fillAlphas": 0
    }],
    "chartCursor": {
        "cursorAlpha": 0,
        "zoomable": false
    },
    "categoryField": "label",
    "categoryAxis": {
        "gridPosition": "start",
        "axisAlpha": 0,
        "fillAlpha": 0.05,
        "fillColor": "#000000",
        "gridAlpha": 0,
        "position": "top"
    },
 
});
//chart.addListener("rendered", zoomChart);
//
//zoomChart();

function zoomChart() {
    if(chartData){
        chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
    }
    
}
</script>
    
<script>
$(function () {
    var ashaselectvalue = "<?php echo @$postData["ashaselect"] ?>";
    var phcselectvalue = "<?php echo @$postData["phcselect"] ?>";
    var villageselectvalue = "<?php echo @$postData["villageselect"] ?>";
    var startdateValue = "<?php echo @$postData["startdate"] ?>";
    var enddateValue = "<?php echo @$postData["enddate"] ?>";
    $('.select2').select2()
//Date picker
 dateChanges();


    //filter values set
    if (ashaselectvalue.length > 0 && ashaselectvalue!="Choose Asha") {
        $('#ashaselect').val(ashaselectvalue).trigger('change');
    }
    if (phcselectvalue.length > 0 && phcselectvalue!="Choose PHC") {
        $('#phcselect').val(phcselectvalue).trigger('change');
         
    }
    if (villageselectvalue.length > 0 && phcselectvalue.length > 0) {
        getPHCVillages(phcselectvalue, villageselectvalue);
    }else if (phcselectvalue.length > 0) {
        getPHCVillages(phcselectvalue, villageselectvalue);
    }    
    if (startdateValue.length > 0) {
        $('#datepicker').datepicker('setDate', new Date(startdateValue));

    }
    if (enddateValue.length > 0) {
//        $('#datepicker2').datepicker('setDate', new Date(enddateValue));
        setEndDate(enddateValue);
    }

    ////

    $('#phcselect').on('change', function () {
        getPHCVillages($(this).val());
    });
    
    //reset form
    $("#resetbutton").click(function(){
        $("#ashaselect,#phcselect, #villageselect").val('').trigger('change');
    });

});

function getPHCVillages(phcValue, villageSelectValue)
{
    $.ajax({
        type: "POST",
        url: "{{ action('UserController@analyticsVillage') }}",
        data: {phcname: phcValue},
        dataType: 'json',
        success: function (response) {
            villageSelectBox(response, villageSelectValue);
        },
        error: function (error) {
            console.log("server error");
        }
    });
}

function villageSelectBox(response, selectOption)
{
    $('#villageselect').val(null).trigger('change');
    $('#villageselect option').each(function () {

        if ($(this).val() != "select option") {
            $(this).remove();
        }
    });

    var enableslect = false
    $.each(response, function (i, item) {

        if (response[i].village_name.length > 0)
        {
            var newOption = new Option(response[i].village_name, response[i].village_name, false, false);
            $('#villageselect').append(newOption).trigger('change');
            enableslect = true;
        }

    });

    if (selectOption !== 'undefined') {
        $('#villageselect').val(selectOption).trigger('change');
    }
    if (enableslect) {
        $('#villageselect').select2('enable');
    }
}
</script>
@endsection
