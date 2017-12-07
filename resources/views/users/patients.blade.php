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
                                {{ Form::open(array('action' => 'UserController@householdView')) }}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>PHC</label>
                                        <select class="form-control select2 select2-hidden-accessible" 
                                                name="phcselect"  id="phcselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected">select option</option>
                                            @if(count($householdphc) > 0)
                                            @foreach ($householdphc as $phc)
                                            <option value="{{$phc->phc_name}}" > {{$phc->phc_name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Village</label>
                                        <select class="form-control select2 select2-hidden-accessible" disabled 
                                                name="villageselect" id="villageselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected">select option</option>

                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>

                                <div class="col-md-3">
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

                                <div class="col-md-3">
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

                                <div class="box-footer">

                                    <button type="submit" class="btn btn-info pull-right">Set Filter</button>

                                </div>
                                {{ Form::close() }}
                            </div>
                            <button type="button" id="exportButton" class="btn btn-info pull-right">Export</button>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Village</th>
                                    <th>Locality </th>
                                    <th> Identifier</th>
                                    <th> Name </th>
                                    <th> Gender</th>
                                    <th> Age</th>
                                    <th> Encounter Type </th>						
                                    <th> Encounter Date </th>												
                                    <th>ASHA Assigned</th>
                                </tr>

                            </thead>
                            <tbody>

                                @if(count($details) > 0)
                                @foreach ($details as $detail)
                                <tr data-id="{{json_encode($detail)}}">
                                    <td >{{$detail['vill_name']}} </td>
                                    <td>{{$detail['locality']}} </td>
                                    <td>{{$detail['patient_id']}} </td>
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
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
<style>
    .ui-dialog{
        z-index: 2000;
    }
    .ui-widget-header{
    border: 1px solid #3c8dbc;
    background: none;
    background-color: #3c8dbc;
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
    //export button changes
//    window.location.href
    $("#exportButton").click(function(){
        path='{{url('/')."/downloadExcel"}}'+'?type=test';
        window.location.href=path;
    });
    $("#dialog-form").hide();
    $("#example1 tr").click(function () {
console.log($(this).data("id"));
var data=$(this).data("id");
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
    var phcselectvalue = "<?php echo @$postData["phcselect"] ?>";
    var villageselectvalue = "<?php echo @$postData["villageselect"] ?>";
    var startdateValue = "<?php echo @$postData["startdate"] ?>";
    var enddateValue = "<?php echo @$postData["enddate"] ?>";
    $('.select2').select2()
//Date picker
    $('#datepicker,#datepicker2').datepicker({
        autoclose: true
    })

    $('#example1').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })

    //filter values set
    if (phcselectvalue.length > 0) {
        $('#phcselect').val(phcselectvalue).trigger('change');
    }
    if (villageselectvalue.length > 0) {
        getPHCVillages(phcselectvalue, villageselectvalue);
    }
    if (startdateValue.length > 0) {
        $('#datepicker').datepicker('setDate', new Date(startdateValue));

    }
    if (enddateValue.length > 0) {
        $('#datepicker2').datepicker('setDate', new Date(enddateValue));
    }

    ////

    $('#phcselect').on('change', function () {
        getPHCVillages($(this).val());
    });

});

function getPHCVillages(phcValue, villageSelectValue)
{
    $.ajax({
        type: "POST",
        url: "{{ action('UserController@householdVillage') }}",
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

function prepareData(data){
    $("#patientdata > tbody").empty();
        $.each(data, function (i, item) {
            $('#patientdata > tbody').append('<tr><td>'+i+'</td> <td>'+item+' </td></tr>');


    });
}
</script>
@endsection
