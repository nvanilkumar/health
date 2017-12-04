<?php
require_once('main.inc.php');
function Export2CSV() {
 $result = db_query('select phc_name,vill_name,asha_assigned,
count(case when current_encounter = "SH_CVD_ASHA_SCREENING_1" then current_encounter end) as new_scrn_count,
 count(case when ref_doc = 1 then ref_doc end) as ref_doc_count,
 count(case when high_risk_calc = 1 then high_risk_calc end) as high_risk_calc_count,
 count(case when current_encounter like "SH_CVD_DOCTOR_FOLLOWUP%" then current_encounter end) as doctor_followup_count
from cvd_basetable where phc_name="'.$_GET['id'].'"
group by phc_name,vill_name,asha_assigned
');

if($_GET['from']!=''&&$_GET['todate']!=''){
        $result = db_query('select phc_name,vill_name,asha_assigned,
count(case when current_encounter = "SH_CVD_ASHA_SCREENING_1" then current_encounter end) as new_scrn_count,
 count(case when ref_doc = 1 then ref_doc end) as ref_doc_count,
 count(case when high_risk_calc = 1 then high_risk_calc end) as high_risk_calc_count,
 count(case when current_encounter like "SH_CVD_DOCTOR_FOLLOWUP%" then current_encounter end) as doctor_followup_count
from cvd_basetable where phc_name="'.$_GET["id"].'" and enc_date >="'.$_GET['from'].'" AND enc_date <="'.$_GET['todate'].'"
group by phc_name,vill_name,asha_assigned
');
    }

$filename = 'doctors'.date('Y-M-d');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename='.$filename.'.csv');
header('Pragma: no-cache');
// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

//$col_array = array('Village Name','Locality Name','Identifier','First Name', 'Last Name','Gender','Age','Encounter Type','Encounter Date','ASHA Assigned');

$col_array = array();

    $col_array=array('PHC nam','Village name','ASHA Name','Number of New screenings','Number of REF DOC','Number of HIGH RISK CALC','Number of Doctor Follow up');


// output the column headings
fputcsv($output, $col_array);


// fetch the data
// loop over the rows, outputting them
while ($row = mysql_fetch_assoc($result))
{
//$row_array = $row;
//array_shift($row_array);
fputcsv($output, $row);

}

fpassthru($output);
}
if(isset($_GET['id'])) {
    Export2CSV();
}
?>