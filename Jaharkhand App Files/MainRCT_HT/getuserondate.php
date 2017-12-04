<?php
require_once('main.inc.php');

function getTabData($f,$t)
{
    $days_limit = intval(DAYS_LIMIT);

    $result;
   // $t=$t." 59:59:59";
    $f=date("Y-m-d H:i:s", strtotime($f) );
    $t=date("Y-m-d H:i:s", strtotime($t . "+1 days") );
   // echo $f.'-'.$t;exit;
   // echo 'select count(*),Date(encounter_datetime) from encounter where WHERE (encounter_datetime BETWEEN "'.$f.'" AND "'.$t.'") group by Date(encounter_datetime) order by encounter_datetime asc';exit;

    if (empty($f)) {


        $result = db_query('select count(*),Date(encounter_datetime) from encounter group by Date(encounter_datetime) order by encounter_datetime asc');



    }else{

        $result = db_query('select count(*),Date(encounter_datetime) from encounter where  encounter_datetime >="'.$f.'" AND encounter_datetime <="'.$t.'" group by Date(encounter_datetime) order by encounter_datetime asc');


    }


    if($result && db_num_rows($result))	{
        $data='';
        while (list($count,$date) = db_fetch_row($result))
        {
            $data.=$date.','.$count.'#';
        }
        return rtrim($data,'#');
    }
    else
    {
        return 'false';
    }
}
if(isset($_GET['f']))
    echo getTabData($_GET['f'],$_GET['t']);
?>