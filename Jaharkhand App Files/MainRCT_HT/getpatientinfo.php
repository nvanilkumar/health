<?php
require_once('main.inc.php');

function getPatientInfoByHHID($hhid)
{	
        $username=$_SESSION['_staff']['userID'];
        $query = 'select *from cvd_basetable where id = '.$hhid;
       	$result = db_query($query);
	$table = '<table border="0" cellspacing=0 cellpadding=0 class="tgrid" align="center" style="border:0px solid #000">
					<tr>
						<th>Attribute</th>
						<th> Value</th>
					</tr>';	
       $count =0;
        if($result && ($num=db_num_rows($result))):
           while ($row = db_fetch_array($result)) {
                for($i = 0; $i < mysql_num_fields($result); $i++) {
                $cssclass = ($count%2==0)?'tr_class_0':'tr_class_1';
                $field_info = mysql_fetch_field($result, $i);
                if(strcmp($username,"drdp")==0){
                    if(strcmp("{$field_info->name}","aadhar_num")!=0&&
					strcmp("{$field_info->name}","address")!=0&&
					strcmp("{$field_info->name}","contact_num")!=0&&
					strcmp("{$field_info->name}","first_name")!=0&&
					strcmp("{$field_info->name}","sur_name")!=0){
                                            
                         $strvalue = $row["{$field_info->name}"];
                        if($strvalue == null){
                            $strvalue = "NA";
                        }
                        $table.='<tr class="'.$cssclass.'">                
			<td align="center">&nbsp;'."{$field_info->name}".'</td>
                       	<td align="center">&nbsp;'.$strvalue.'</td>						
			</tr>';
                    }
                  }else{
                     $table.='<tr class="'.$cssclass.'">                
			<td align="center">&nbsp;'."{$field_info->name}".'</td>
			<td align="center">&nbsp;'.$row["{$field_info->name}"].'</td>						
			</tr>';
                }
                $count++;
                }
           } //end of while.
                
	else: //no records found!! 
		$table.='<tr class=""><td colspan=2 style="padding-left:8px;"><b>No records found.</b></td></tr>';					
	endif; 
		
	$table.='</table>';
	
	echo $table;
}
if(isset($_GET['id']))
	echo getPatientInfoByHHID($_GET['id']);
?>