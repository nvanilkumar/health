<?php
require_once('main.inc.php');
$phcresult=db_query('select phc_name from cvd_basetable WHERE phc_name IS NOT NULL group BY phc_name');

$result = db_query('select phc_name,vill_name,asha_assigned,
 count(case when high_risk_calc = 1 then high_risk_calc end) as high_risk_calc_count,
 count(case when ref_doc = 1 then ref_doc end) as ref_doc_count,
 count(case when current_encounter = "SH_CVD_ASHA_SCREENING_1" then current_encounter end) as new_scrn_count,
 count(case when current_encounter like "SH_CVD_DOCTOR_FOLLOWUP%" then current_encounter end) as doctor_followup_count
from cvd_basetable where phc_name="'.$_GET["id"].'"
group by phc_name,vill_name,asha_assigned
');
if($_GET['from']!=''&&$_GET['todate']!=''){
    $result = db_query('select phc_name,vill_name,asha_assigned,STR_TO_DATE(enc_date, \'%d-%m-%Y\') as enc_date1,
 count(case when high_risk_calc = 1 then high_risk_calc end) as high_risk_calc_count,
 count(case when ref_doc = 1 then ref_doc end) as ref_doc_count,
 count(case when current_encounter = "SH_CVD_ASHA_SCREENING_1" then current_encounter end) as new_scrn_count,
 count(case when current_encounter like "SH_CVD_DOCTOR_FOLLOWUP%" then current_encounter end) as doctor_followup_count
from cvd_basetable where phc_name="'.$_GET["id"].'" and enc_date >="'.$_GET['from'].'" AND enc_date <="'.$_GET['todate'].'"
group by phc_name,vill_name,asha_assigned
');
}
?>
<p style="width: 100%">
<form class="form-inline">
    <select name="phcname" class="form-control" id="phcname" onchange="dcchange(this.value)">
        <option value="">Select Phc</option>
        <?php  if($phcresult && db_num_rows($phcresult))	{
            while (list($phc_name) = db_fetch_row($phcresult)) {
                ?>
                <option value="<?=$phc_name?>" <?php if($_GET["id"]==$phc_name)echo "selected"?>><?=$phc_name?></option>
            <?php } }?>
    </select>

    <input type="text" name="doctfrom" id="doctfrom" class="form-control" placeholder="Start date" value="<?=$_GET['from']?>">
    <input type="text" name="doctto" id="doctto" class="form-control" placeholder="End date" value="<?=$_GET['todate']?>">
    <input type="button" class="btn btn-default" name="filter" value="Filter" id="dccfilter" onclick="dcchange('filter')">
    <input type="button" id="exportDoctor" class="btn btn-default" name="exportDoctor" value="Export" onclick="exportDoctors()">

</form></p>
<?php if($_GET['id']!=''){?>
<table class="table table-hover  table-bordered">
    <tr>
        <th style="text-align:left;">
            S.No</th>
        <th>PHC name</th>
        <th>Village name</th>
        <th>ASHA Name</th>
        <th>No of New screenings</th>
        <th>No of REF DOC</th>
        <th>No of HIGH RISK CALC</th>
        <th>No of Doctor Follow up</th>
    </tr>
        <?php  $i=0;if($result && db_num_rows($result))	{
            while ($row = db_fetch_array($result)) { $i++;
                ?>
    <tr>
                <td><?=$i?></td>
                <td><?=$row['phc_name']?></td>
                <td><?=$row['vill_name']?></td>
                <td><?=$row['asha_assigned']?></td>
                <td><?=$row['new_scrn_count']?></td>
                <td><?=$row['ref_doc_count']?></td>
                <td><?=$row['high_risk_calc_count']?></td>
                <td><?=$row['doctor_followup_count']?></td>

    </tr>
            <?php } }else{?>

            <tr><td align="center" colspan="8">No Records Found</td></tr>
       <?php }?>


</table>
<?php }?>