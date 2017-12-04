<?php
require_once('main.inc.php');

function getTabData($q)
{
	$days_limit = intval(DAYS_LIMIT);
	$result;
	if (empty($q)) {
    	$result = db_query("select  count(*), date(enc_date) as enc_date1 from cvd_basetable where enc_date is not null and patient_id is not null group by enc_date1 order by enc_date1 asc");
        }else{
	//$result = db_query('select count(*),enc_date from cvd_basetable where asha_assigned='.$q.' group by enc_date order by enc_date asc');
        //$result = db_query("select  distinct(STR_TO_DATE(enc_date, \"%d-%m-%Y\")) enc_date,count(*) from cvd_basetable where enc_date<>'null' and asha_assigned=".$q." group by enc_date order by enc_date asc");
    	$result = db_query("select  count(*), date(enc_date) as enc_date1 from cvd_basetable where enc_date is not null and patient_id is not null and asha_assigned=\"".$q."\" group by enc_date1 order by enc_date1 asc");
        }
        if($result && db_num_rows($result))	{
            $data='';
            while (list($count,$date) = db_fetch_row($result)){	
                $data.=date("Y-m-d",strtotime($date)).','.$count.'#';	
            }	
	return rtrim($data,'#');
	}
	else
	{
            return 'false';
	}
}
if(isset($_GET['q']))
	echo getTabData($_GET['q']);
?>