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
                        <h3 class="box-title">House Hold</h3>


                        <!-- /.box-header -->
                        <div class="box-body" style="">
                            <div class="row">
                                {{ Form::open(array('action' => 'UserController@householdView')) }}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PHC</label>
                                        <select class="form-control select2 select2-hidden-accessible" 
                                                id="phcselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Village</label>
                                        <select class="form-control select2 select2-hidden-accessible" disabled 
                                                id="villageselect" style="width: 100%;" tabindex="-1" aria-hidden="true">
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
                                            <input type="text" class="form-control pull-right" id="datepicker">
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
                                            <input type="text" class="form-control pull-right" id="datepicker2">
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
<script>
$(function () {
    $('.select2').select2()
//Date picker
    $('#datepicker,#datepicker1').datepicker({
        autoclose: true
    })

    $('#example1').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })

    $('#phcselect').on('change', function () {
        console.log(4444);
        $.ajax({
            type: "POST",
            url: "{{ action('UserController@householdVillage') }}",
            data: {phcname: $(this).val()},
            dataType: 'json',
            success: function (response) {
                
                $('#villageselect').val(null).trigger('change');
                $('#villageselect option').each(function () {

                    if ($(this).val() != "select option") {
                        $(this).remove();
                    }
                });
                 
                var enableslect=false
                $.each(response, function (i, item) {
                   
                    if(response[i].village_name.length > 0)
                    {
                        var newOption = new Option(response[i].village_name, response[i].village_name, false, false);
                        $('#villageselect').append(newOption).trigger('change');
                         enableslect=true;
                    }
                    
                });
                
                if(enableslect){
                    $('#villageselect').select2('enable');
                }
                
            },
            error: function (error) {
                console.log("server error");
//                        $("#errorMessage").html(error.response.message);
            }
        });
    });
})
</script>
@endsection
