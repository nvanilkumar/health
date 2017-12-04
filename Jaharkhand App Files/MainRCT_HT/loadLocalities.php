<?php
require_once('main.inc.php'); 
        $villagename = $_GET['villname'];
        $locality_name = $_GET['selectedloc'];
        $asha_name = $_GET['selectedasha'];
        $localityquery = "Select distinct(locality) from cvd_basetable where locality is not null and vill_name ='".$villagename."' order by locality asc;";
        $localityresult = db_query($localityquery);
        $localitydata='';
        $localitydata.="<option>Select</option>";
        $data='';
        if($localityresult && db_num_rows($localityresult)){
                $selected_val='';
		while (list($locality) = db_fetch_row($localityresult)) 
		{	if(strcmp($locality,$locality_name)==0){
                           $selected_val = 'selected'; 
                        }else{
                           $selected_val=''; 
                        }
			$localitydata.="<option $selected_val>".$locality."</option>";
		}	
		
	}
        //for getting asha
        $ashayquery = "Select distinct(asha_assigned) from cvd_basetable where asha_assigned is not null and vill_name ='".$villagename."' order by asha_assigned asc;";
        $asharesult = db_query($ashayquery);
        $ashadata='';
        $ashadata.="<option>Select</option>";
        
        if($asharesult && db_num_rows($asharesult)){
                $ashaselected_val='';
		while (list($asha_assigned) = db_fetch_row($asharesult)){
                    if(strcmp($asha_assigned,$asha_name)==0){
                           $ashaselected_val = 'selected'; 
                        }else{
                           $ashaselected_val=''; 
                        }
                    $ashadata.="<option $ashaselected_val>".$asha_assigned."</option>";
		}	
		
	}else{
             $totalashayquery = "Select distinct(asha_assigned) from cvd_basetable where asha_assigned is not null order by asha_assigned asc;";
             $totalasharesult = db_query($totalashayquery);
             if($totalasharesult && db_num_rows($totalasharesult)){
                 $totashaselected_val='';
                while (list($asha_assigned) = db_fetch_row($totalasharesult)){
                     if(strcmp($asha_assigned,$asha_name)==0){
                           $totashaselected_val = 'selected'; 
                        }else{
                           $totashaselected_val=''; 
                        }
                   $ashadata.="<option $totashaselected_val>".$asha_assigned."</option>";
		}
            }
      }
        $data=$localitydata.'#'.$ashadata;        
        echo $data;

?>

