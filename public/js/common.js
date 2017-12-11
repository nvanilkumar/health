

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
        'searching': true,
        "order": [],
        "bSort": true,
        'info': true,
        'autoWidth': false
    })
}
