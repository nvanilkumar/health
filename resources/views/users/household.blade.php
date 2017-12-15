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
                        <h3 class="box-title">Household Report</h3>


                        <!-- /.box-header -->
                        <div class="box-body" style="">
                            <div class="row">
                                {{ Form::open(array('action' => 'UserController@householdView')) }}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>ASHA</label>
                                        <select class="form-control select2 select2-hidden-accessible" 
                                                name="ashaselect"  id="ashaselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected">Choose Asha</option>
                                            @if(count($householdasha) > 0)
                                            @foreach ($householdasha as $asha)
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
                                            @if(count($householdphc) > 0)
                                            @foreach ($householdphc as $phc)
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
                        <div> 
                            <span class="btn label-danger" id="exportButton"><i class="fa fa-download"></i> Export</span>
                            <span class="btn label-success" id="exportAllButton"><i class="fa fa-download"></i> Export All</span>
                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th>HH Id</th>
                                    <th>PHC name</th>
                                    <th>Village name</th>
                                    <th>Family Head Name </th>


                                </tr>
                            </thead>
                            <tbody>

                                @if(count($details) > 0)
                                @foreach ($details as $detail)
                                <tr>
                                    <td>{{$detail['hh_id']}} </td>
                                    <td>{{$detail['phc_name']}} </td>
                                    <td>{{$detail['village_name']}} </td>
                                    <td> {{$detail['hh_head_fname'] ." ".$detail['hh_head_lname']}}</td>
                                </tr>

                                @endforeach
                                @endif

                            </tbody>

                        </table>
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
<script>
$(function () {
    //Download Report 
    $("#exportButton").click(function () {
        path = '{{url('')."/downloadExcel"}}' + '?type=household'+queryString();
        window.location.href = path;
    });
    $("#exportAllButton").click(function () {
        path = '{{url('')."/downloadExcel"}}' + '?type=household';
        window.location.href = path;
    });
    
    var ashaselectvalue = "<?php echo @$postData["ashaselect"] ?>";
    var phcselectvalue = "<?php echo @$postData["phcselect"] ?>";
    var villageselectvalue = "<?php echo @$postData["villageselect"] ?>";
    var startdateValue = "<?php echo @$postData["startdate"] ?>";
    var enddateValue = "<?php echo @$postData["enddate"] ?>";
    $('.select2').select2()
//Date picker
    dateChanges();

    dataTableInit("example1");


    //filter values set
    if (ashaselectvalue.length > 0 && ashaselectvalue!="Choose Asha") {
        $('#ashaselect').val(ashaselectvalue).trigger('change');
    }
    if (phcselectvalue.length > 0) {
        $('#phcselect').val(phcselectvalue).trigger('change');
    }
    if (villageselectvalue.length > 0) {
        getPHCVillages(phcselectvalue, villageselectvalue);
    }else if (phcselectvalue.length > 0) {
        getPHCVillages(phcselectvalue, villageselectvalue);
    } 
    if (startdateValue.length > 0) {
        $('#datepicker').datepicker('setDate', new Date(startdateValue));

    }
    if (enddateValue.length > 0) {
        setEndDate(enddateValue);
    }


    $('#phcselect').on('change', function () {
        getPHCVillages($(this).val());
    });
    
        //reset form
    $("#resetbutton").click(function(){
        $("#ashaselect,#phcselect, #villageselect").val('').trigger('change');
    });

});


//House Hold table related phc
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

//House Hold table related phc related villages
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
            $('#villageselect').append(newOption);
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
