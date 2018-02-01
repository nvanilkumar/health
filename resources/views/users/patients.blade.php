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
                        <h3 class="box-title">Patients Details</h3>


                        <!-- /.box-header -->
                        <div class="box-body" style="">
                            <div class="row">
                                {{ Form::open(array('action' => 'UserController@getPatientsView', "id"=>"patientform")) }}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        
                                        <select class="form-control select2 select2-hidden-accessible" 
                                                name="encselect"  id="encselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected">Choose ENC Type</option>
                                            @if(count($encType) > 0)
                                            @foreach ($encType as $enc)
                                            <option value="{{$enc->enc_type}}" > {{$enc->enc_type}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        
                                        <select class="form-control select2 select2-hidden-accessible" disabled
                                                name="phcselect"  id="phcselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected">Choose PHC</option>

                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                         
                                        <select class="form-control select2 select2-hidden-accessible" disabled 
                                                name="villageselect" id="villageselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected">Choose Village</option>

                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                       

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" 
                                                   id="datepicker" name="startdate" placeholder="From">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" 
                                                   id="datepicker2" name="enddate" placeholder="To">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        

                                        <div class="input-group date">
                                             
                                            <input type="text" class="form-control input-sm" 
                                                value="<?php echo @$postData["patient_id"] ?>"   id="patient_id" name="patient_id" placeholder="PateintId">
                                             
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        

                                        <div class="input-group date">
                                             
                                            <input type="text" class="form-control input-sm" 
                                                value="<?php echo @$postData["hh_id"] ?>"   
                                                id="hh_id" name="hh_id" placeholder="HouseholdId">
                                             
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>

                                <div class="col-md-2 pull-right" >

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
                        <div  > 
                            <span class="btn label-danger" id="exportButton"><i class="fa fa-download"></i> Export</span>
                            <span class="btn label-success" id="exportAllButton"><i class="fa fa-download"></i> Export All</span>
                            <span class="btn label-warning" id="exportSButton"><i class="fa fa-download"></i> Export Screening</span>

                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>PHC </th>
                                    <th>Village</th>
                                    <th>Patient Id</th>
                                    <th>Household Id</th>
                                    <th>Name </th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Encounter Type </th>						
                                    <th>Encounter Date </th>												
                                    <th>ASHA Assigned</th>
                                </tr>

                            </thead>
                            <tbody>

                                @if(count($details) > 0)
                                @foreach ($details as $detail)
                                <tr data-id="{{json_encode($detail)}}">
                                    <td>{{strtoupper($detail['phc_name'])}} </td>
                                    <td >{{$detail['vill_name']}} </td>

                                    <td>{{$detail['patient_id']}} </td>
                                    <td>{{$detail['hh_id']}} </td>
                                    <td> {{$detail['first_name'] ." ".$detail['sur_name']}}</td>
                                    <td>{{$detail['gender']}} </td>
                                    <td>{{$detail['age']}} </td>
                                    <td>{{$detail['enc_type']}} </td>
                                    <td>{{$detail['enc_date']}} </td>
                                    <td>{{$detail['asha_assigned']}} </td>
                                </tr>

                                @endforeach
                                @endif

                            </tbody>

                        </table>
                    </div>
                    <div id="dialog-form" title="Attributes">
                        <div class="col-xs-12">
                            <div class="box">

                                <!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover" id="patientdata">
                                        <thead>
                                            <tr> 
                                                <td>Name </td>
                                                <td>Value </td>
                                            </tr>    
                                        </thead>
                                        <tbody>


                                        </tbody></table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
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
<script type="text/javascript" src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/pluginjs/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/pluginjs/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/pluginjs/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/pluginjs/jquery-ui.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/plugincss/jquery-ui.css') }}" />

<script type="text/javascript" src="{{ asset('/js/common.js') }}"></script>
<style>
    .ui-dialog{
        z-index: 2000;
    }
    .ui-widget-header{
        border: 1px solid #7f4992;
        background: none;
        background-color: #7f4992;
        color: #fff;
    }
    #patientdata thead{
        background-color: #222d32;
        color: #eeeeee;
        font-size: 13px;
    }
</style>
<script>
$(function () {

    //Download Report 
    $("#exportButton").click(function () {
        path = '{{url('')."/downloadExcel"}}' + '?type=patients'+queryString();
        window.location.href = path;
    });
    $("#exportAllButton").click(function () {
        path = '{{url('')."/downloadExcel"}}' + '?type=patients';
        window.location.href = path;
    });
    $("#exportSButton").click(function () {
        path = '{{url('')."/downloadExcel"}}' + '?type=patientScreening';
        window.location.href = path;
    });
    
    $("#dialog-form").hide();
    //Show Dialog box
    $("#example1 tr").click(function () {
         
        var data = $(this).data("id");
        prepareData(data);
        var dialog;
        dialog = $("#dialog-form").dialog({
            autoOpen: false,
            height: 600,
            width: 600,
            modal: true
        });
        dialog.dialog("open");
    });

    var encselectvalue = "<?php echo @$postData["encselect"] ?>";
    var phcselectvalue = "<?php echo @$postData["phcselect"] ?>";
    var villageselectvalue = "<?php echo @$postData["villageselect"] ?>";
    var startdateValue = "<?php echo @$postData["startdate"] ?>";
    var enddateValue = "<?php echo @$postData["enddate"] ?>";
    $('.select2').select2();
    //Date picker
    dateChanges();

    dataTableInit("example1");


    //filter values set
    if (encselectvalue.length > 0) {
        $('#encselect').val(encselectvalue).trigger('change');
    }
    if ((phcselectvalue.length > 0) ||(encselectvalue.length > 0)){
        getPHC(encselectvalue, phcselectvalue);
    }
    if (villageselectvalue.length > 0) {
         
        getPHCVillages(phcselectvalue, villageselectvalue);
    } 
    if (startdateValue.length > 0) {
        $('#datepicker').datepicker('setDate', new Date(startdateValue));

    } else if(encselectvalue.length == 0){
        $('#datepicker').attr("disabled", 'disabled');
    }
    if (enddateValue.length > 0) {
        setEndDate(enddateValue);
    }

    ////

    $('#encselect').on('change', function () {
        $('#datepicker').removeAttr("disabled");
        getPHC($(this).val());
    });
    $('#phcselect').on('change', function () {
        getPHCVillages($(this).val(),villageselectvalue);
    });
    
    //reset form
    $("#resetbutton").click(function(){
        $("#phcselect, #encselect, #villageselect, #hh_id, #patient_id").val('').trigger('change');
    });

});

function getPHC(encValue, phcselectvalue)
{
    $.ajax({
        type: "POST",
        url: "{{ action('UserController@patientPHC') }}",
        data: {encselect: encValue},
        dataType: 'json',
        success: function (response) {
            phcSelectBox(response, phcselectvalue);
        },
        error: function (error) {
            console.log("server error");
        }
    });
}

function getPHCVillages(phcValue, villageSelectValue)
{
    if (phcValue && phcValue.length > 0) {
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

}


function phcSelectBox(response, phcselectvalue)
{
    $('#phcselect').val(null);
    $('#phcselect option').each(function () {

        if ($(this).val() != "Choose PHC") {
            $(this).remove();
        }
    });

    var enableslect = false
    $.each(response, function (i, item) {

        if (response[i].phc_name.length > 0)
        {
            var newOption = new Option(response[i].phc_name, response[i].phc_name, false, false);
            $('#phcselect').append(newOption);
            enableslect = true;
        }

    });
 
    $('#phcselect').val(phcselectvalue).trigger('change');
    if (enableslect) { 
        $('#phcselect').select2('enable');
    }
}

function villageSelectBox(response, selectOption)
{
    $('#villageselect').val(null);
    $('#villageselect option').each(function () {

        if ($(this).val() != "Choose Village") {
            $(this).remove();
        }
    });

    var enableslect = false
    $.each(response, function (i, item) {

        if (response[i].village_name.length > 0)
        {
            var newOption = new Option(response[i].village_name, response[i].village_name, false, false);
//            $('#villageselect').append(newOption).trigger('change');
            $('#villageselect').append(newOption);
            enableslect = true;
        }

    });

    $('#villageselect').val(selectOption).trigger('change');
    if (enableslect) 
    {
        $('#villageselect').select2('enable');
    }
}

//For dialog box preparation
function prepareData(data) {
    $("#patientdata > tbody").empty();
    $.each(data, function (i, item) {
        $('#patientdata > tbody').append('<tr><td>' + i + '</td> <td>' + item + ' </td></tr>');


    });
}

</script>
@endsection
