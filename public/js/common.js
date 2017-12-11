

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