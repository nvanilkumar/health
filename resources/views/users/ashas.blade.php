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
                        <h3 class="box-title">Ashas Details</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:left;">
                                        ASHA Name</th>
                                    <th style="text-align:center;">
                                        Last Encounter Date</th>
                                    <th style="text-align:center;">
                                        Time Since Last Encounter</th>
                                </tr>


                            </thead>
                            <tbody>

                                @if(count($details) > 0)
                                @foreach ($details as $detail)
                                <?php
                                $time_since = "";
                                if ($detail->days > 1) {
                                    $time_since .= $detail->days . ' days';
                                } else if ($detail->days === 1) {
                                    $time_since .= $detail->days . ' day';
                                }

                                if ($detail->hours > 0) {
                                    if ($detail->hours == 1)
                                        $time_since .= $detail->hours . ' hour ';
                                    else
                                        $time_since .= $detail->hours . ' hours ';
                                }

                                if ($detail->minutes > 0) {
                                    if ($detail->minutes == 1)
                                        $time_since .= $detail->minutes . ' minute';
                                    else
                                        $time_since .= $detail->minutes . ' minutes';
                                }
                                ?>

                                <tr>
                                    <td >{{$detail->given_name}} </td>
                                    <td >{{$detail->encounter_datetime}} </td>
                                    <td> {{$time_since }} </td>

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
path = '{{url('')."/downloadExcel"}}' + '?type=reports' + queryString();
window.location.href = path;
});
$("#exportAllButton").click(function () {
path = '{{url('')."/downloadExcel"}}' + '?type=reports';
window.location.href = path;
});
var phcselectvalue = "<?php echo @$postData["phcselect"] ?>";
var villageselectvalue = "<?php echo @$postData["villageselect"] ?>";
var startdateValue = "<?php echo @$postData["startdate"] ?>";
var enddateValue = "<?php echo @$postData["enddate"] ?>";
$('.select2').select2()
//Date picker
        dateChanges();
dataTableInit("example1");
//filter values set
if (phcselectvalue.length > 0) {
$('#phcselect').val(phcselectvalue).trigger('change');
}
if (villageselectvalue.length > 0) {
getPHCVillages(phcselectvalue, villageselectvalue);
} else if (phcselectvalue.length > 0) {
getPHCVillages(phcselectvalue, villageselectvalue);
}
if (startdateValue.length > 0) {
$('#datepicker').datepicker('setDate', new Date(startdateValue));
}
if (enddateValue.length > 0) {
setEndDate(enddateValue);
}
////

$('#phcselect').on('change', function () {
getPHCVillages($(this).val());
});
$("#resetbutton").click(function(){
$("#phcselect, #villageselect").val('').trigger('change');
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
                $('#villageselect').append(newOption);
                enableslect = true;
                }

                });
        $('#villageselect').val(selectOption).trigger('change');
        if (enableslect) {
        $('#villageselect').select2('enable');
        }
        }


</script>
@endsection
