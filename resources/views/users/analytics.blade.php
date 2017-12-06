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
                                
                                {{ Form::open(array('url' => url('/')."/analytics/".request()->route('type'))) }}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PHC</label>
                                        <select class="form-control select2 select2-hidden-accessible" 
                                                name="phcselect"  id="phcselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected">select option</option>
                                            @if(count($analyticsphc) > 0)
                                            @foreach ($analyticsphc as $phc)
                                                <option value="{{$phc->phc_name}}" > {{$phc->phc_name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Village</label>
                                        <select class="form-control select2 select2-hidden-accessible" disabled 
                                                name="villageselect" id="villageselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option selected="selected">select option</option>

                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>

                                <div class="col-md-6">
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

                                <div class="col-md-6">
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
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      testoooooooooooo
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
<script>
$(function () {
    var phcselectvalue = "<?php echo @$postData["phcselect"] ?>";
    var villageselectvalue = "<?php echo @$postData["villageselect"] ?>";
    var startdateValue = "<?php echo @$postData["startdate"] ?>";
    var enddateValue = "<?php echo @$postData["enddate"] ?>";
    $('.select2').select2()
//Date picker
    $('#datepicker,#datepicker2').datepicker({
        autoclose: true
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
