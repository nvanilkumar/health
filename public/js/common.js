

//Data related Manipulation

function dateChanges()
{

    $('#datepicker2').attr("disabled", 'disabled');
    $('#datepicker').datepicker({
        autoclose: true,
        startDate: "2014-12-21",
        endDate: "taday",
        onSelect: function (e) {
            var date = $('#datepicker').val(); //alert(date);
            $('#datepicker2').removeAttr("disabled");
            $('#datepicker2').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                startDate: date,
                endDate: "taday"
            });
        }
    });
}

//After selecting the data
function setEndDate(enddateValue)
{
    $('#datepicker2').removeAttr("disabled");
//    console.log(enddateValue);
    $('#datepicker2').datepicker({
        autoclose: true
    })
    $('#datepicker2').datepicker('setDate', new Date(enddateValue));

}



//Data table Initialization 

function dataTableInit(_id)
{
    $('#' + _id).DataTable({
        'paging': true,
        'lengthChange': false,
        "dom": '<"top"i>rt<"bottom"flp><"clear">',
        "order": [],
        "searching": false,
        "bSort": true,
        'info': true,
        'autoWidth': false
    })
}

//To Prepare the Query String
function queryString() {
    var query = "";

    ashaVal = $("#ashaselect").val();
    if (ashaVal && ashaVal != "Choose Asha") {
        query += "&ashaselect=" + ashaVal;
    }
    encVal = $("#encselect").val();
    if (encVal && encVal != "Choose ENC Type") {
        query += "&encselect=" + encVal;
    }

    phcVal = $("#phcselect").val();
    if (phcVal && phcVal != "Choose PHC") {
        query += "&phcselect=" + phcVal;
    }

    villageVal = $("#villageselect").val();
    if (villageVal && villageVal != "Choose Village") {
        query += "&villageselect=" + villageVal;
    }

//    startdateVal=$("#startdate").datepicker('getDate');

    if ($("#datepicker").is('.hasDatepicker')) {
        startdateVal = $("#datepicker").val();
        if (startdateVal) {
            query += "&startdate=" + startdateVal;
        }
    }
    if ($("#datepicker2").is('.hasDatepicker')) {
        enddateVal = $("#datepicker2").val();
        if (enddateVal) {
            query += "&enddate=" + enddateVal;
        }
    }
    return query;
}
