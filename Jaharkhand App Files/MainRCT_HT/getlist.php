<?php
require_once('main.inc.php'); 

$sortOptions=array('village_name'=>'vill_name','locality_name'=>'person_attr.Locality',
					'identifier'=>'PID.identifier','fullname'=>'Full_Name','gender'=>'PE.Gender',
					'age'=>'Age','encounter_type'=>'Encounter_Name',
					'encounter_date'=>'Encounter_Date','ASHA_assigned'=>'person_attr.ASHA_assigned');
$orderWays=array('DESC'=>'DESC','ASC'=>'ASC');

//Sorting options...
if($_GET['sort']) {
        $order_by =$sortOptions[$_GET['sort']];
}
if($_GET['order']) {
    $order=$orderWays[$_GET['order']]; 
} 

$order_by =$order_by!=''?$order_by:'vill_name';
$order=$order!=''?$order:'ASC';
$pagelimit=$_GET['limit']?$_GET['limit']:PAGE_LIMIT;
$page=($_GET['p'] && $_GET['p']!='' && is_numeric($_GET['p']))?$_GET['p']:1;
$search_arr1 = array(
				'person_attr.Locality' => $_GET['locality_name'],
				'person_attr.Village' => $_GET['village_name'],
				'person_attr.ASHA_assigned' => $_GET['asha_name'],
				'ET.name' => $_GET['encounter_name'],
				'E.encounter_datetime'=>$_GET['asha_date'],);
$search_arr = array(
				'locality' => $_GET['locality_name'],
				'vill_name' => $_GET['village_name'],
				'asha_assigned' => $_GET['asha_name'],
				'enc_type' => $_GET['encounter_name'],
				'enc_date'=>$_GET['asha_date'],
);
$search_str = "";
$k = 1;
foreach($search_arr as $key => $value)
{
	if($value != '')
	{
		$search_str .= " ".$key." = '".$value."' and"; 
		$k++;
	}
}
if($k != 1)
{
	$search_str = "and ".trim($search_str,'and');
}
if($search_str==''&&isset($_GET['asha_fdate'])&&isset($_GET['asha_tdate'])){
	$f=date("Y-m-d H:i", strtotime($_GET['asha_fdate']) );
	$t=date("Y-m-d H:i", strtotime($_GET['asha_tdate'] . "+1 days"));
	$search_str=$search_str."and enc_date >='".$f."' AND enc_date <='".$t."'";
}
elseif($search_str!=''&& $_GET['asha_fdate']!=''&& $_GET['asha_tdate']!=''){
	$f=date("Y-m-d H:i", strtotime($_GET['asha_fdate']) );
	$t=date("Y-m-d H:i", strtotime($_GET['asha_tdate'] . "+1 days") );
	$search_str=$search_str."and enc_date >='".$f."' AND enc_date <='".$t."'";
}
//echo $search_str;
$qselect="select id,enc_id,patient_id,vill_name,locality,first_name,sur_name,gender,age,enc_type,enc_date,asha_assigned from cvd_basetable where enc_date is not null and patient_id is not null";
//Pagenation stuff....wish MYSQL could auto pagenate (something better than limit)
$query="$qselect ".$search_str." ORDER BY $order_by $order ";
//echo $query;
$totalquery = "select count(*) from (".$query.")";
//echo "total----->".$totalquery;
$total=db_count("select count(*) from (".$query.") c");
$pageNav=new Pagenate($total,$page,$pagelimit);
$pageNav->setPARAMS('sort='.urlencode($_REQUEST['sort']).'&order='.urlencode($_REQUEST['order']).'&locality_name=locality_name&village_name=village_name&hh_head_fname=hh_head_fname');
$query .= " LIMIT ".$pageNav->getStart().",".$pageNav->getLimit();
//echo $query;
$tabs_res = db_query($query);

$negorder=$order=='DESC'?'ASC':'DESC'; //Negate the sorting..

if($order=='ASC')
{
	$filterimg='images/acending.png';
}
else
{
	$filterimg='images/descending.png';
}

$html = '<div style="width:90%; margin:auto;">';?>
<p> <?php $$encounter_types = db_query('Select encounter_type_id, name from encounter_type'); ?>

			<b>Encounter Type&nbsp;:&nbsp;</b>
			<select class="dropdown" id="encounterdd" onchange="return searchListing('List','village_name','<?php echo $negorder;?>','<?php echo $page;?>','locality_name','village_name','hh_head_fname');">
<option value="">Select</option>';

<?php $encounterselected = '';
if($$encounter_types && db_num_rows($$encounter_types))	{
	while (list($id,$encounter) = db_fetch_row($$encounter_types)) {
		if($search_arr1['ET.name'] != '' && !strcmp($encounter,$search_arr1['ET.name']))
		{
			$encounterselected = 'selected';
			$btnfilterstatus = '';
		}
		$html.='<option value="'.$id.'" '.$encounterselected.'>'.$encounter.'</option>';
		$encounterselected = '';
	}
}

$html.='</select>&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:auto; float:right;">
						<input type="submit" class="btn btn-default" id="btnExport" name="export" value="Export" onClick="return togglePopup(true,\'export\');"/>
						<input type="submit" class="btn btn-default" id="btnExportAll" name="export" value="Export All" onClick="return togglePopup(true,\'exportall\');"/>
					</span></p>
		<b>Village&nbsp;:&nbsp;</b>
		<select id="villagedd" class="dropdown form-control" onchange="enableBtnFilter();">
		<option value="">Select</option>';
		$result = db_query('Select distinct(vill_name) from cvd_basetable where vill_name is not null order by asha_assigned asc;');
			$selected = '';			
			$btnfilterstatus='disabled';
			if($result && db_num_rows($result))	{
				$id = 1;
				while (list($vill_name) = db_fetch_row($result)) {
					if($search_arr1['person_attr.Village'] != '' && !strcmp($vill_name,$search_arr1['person_attr.Village']))
					{
						$selected = 'selected';						
						$btnfilterstatus = '';
					}
					$html.='<option value="'.$id.'" '.$selected.'>'.$vill_name.'</option>';
					$id = $id + 1;
					$selected = '';
				}
			}			
		
		$html.='</select>&nbsp;&nbsp;&nbsp;&nbsp;
					<b>Locality&nbsp;:&nbsp;</b>
						<select class="dropdown form-control" id="localitydd" onchange="enableBtnFilter();">;
						<option value="">Select</option>';
                          				
					
			$html.='</select>&nbsp;&nbsp;&nbsp;&nbsp;';
			$asha_result = db_query('Select distinct(asha_assigned) from cvd_basetable where asha_assigned is not null order by asha_assigned asc;');
			$html.='<b>ASHA&nbsp;:&nbsp;</b>
						<select class="dropdown form-control" id="ashadd" onchange="enableBtnFilter();">
						<option value="">Select</option>';
			$userselected = '';
                        $id;
                        if($asha_result && db_num_rows($asha_result))	{	 
                            while (list($asha_assigned) = db_fetch_row($asha_result)) {
				if($search_arr1['person_attr.ASHA_assigned'] != '' && !strcmp($asha_assigned,$search_arr1['person_attr.ASHA_assigned']))
					{
						$userselected = 'selected';
						$btnfilterstatus = '';
					}
					$html.='<option value="'.$id.'" '.$userselected.'>'.$asha_assigned.'</option>';
					$userselected = '';					
				}
			}
$html.='</select>&nbsp;&nbsp;&nbsp;&nbsp;';
$html.='<input type="text" name="pfromdate" placeholder="Encounter Start Date" value="'.$_GET['asha_fdate'].'" id="pfromdate" class="pfromdate form-control">
<input type="text" name="ptodate" id="ptodate" value="'.$_GET['asha_tdate'].'" placeholder="Encounter End Date" class="ptodate form-control">';
$dateselected = '';

$html.='</select>&nbsp;&nbsp;<span>Count:'.$total.'</span>&nbsp;&nbsp;';
			
			$html.='<input class="" type="submit" id="btnFilter" name="search" value="Filter" onclick="return searchListing('.'\'List\''.',\'village_name\',\''.$negorder.'\',\''.$page.'\',\'locality_name\',\'village_name\',\'hh_head_fname\');"  '.$btnfilterstatus.'/>&nbsp;&nbsp;
					<input type="submit" name="clear" value="Reset" onclick="return searchListing('.'\'Clear\''.',\'village_name\',\''.$negorder.'\',\''.$page.'\',\'locality_name\',\'village_name\',\'hh_head_fname\');" />
					<span id="errorMessage" style="color:#EFA71E;font-weight:bold;display:none;float:right;margin-top:5px;margin-right:40%;">Please Select Village</span>

					</div><br/>';

$html.= '<p></p>
<table width="100%" border="0" align="center" cellspacing=0 cellpadding=0 style="">
		<tr>
			<td>
				<table border="0" cellspacing=0 cellpadding=0 class="tgrid" align="center" style="border:0px solid #000">
					<tr>
						<th style="cursor:pointer;">
							<a onclick="changeTab('.'\'List\''.',\'village_name\',\''.$negorder.'\',\''.$page.'\',\'locality_name\',\'village_name\',\'hh_head_fname\');" title="Sort By Village '.$negorder.'" style="text-decoration:none; color:#FFF;">Village</a>';
							
							if($order_by=='person_attr.Village')
							{
								$html.='<img src="'.$filterimg.'" style="padding-left:3px;"/>';
							}
						$html.='</th>
						<th style="cursor:pointer;">
							<a onclick="changeTab('.'\'List\''.',\'locality_name\',\''.$negorder.'\',\''.$page.'\',\'locality_name\',\'village_name\',\'hh_head_fname\');" title="Sort By Locality '.$negorder.'" style="text-decoration:none; color:#FFF;">Locality</a>';
							
							if($order_by=='person_attr.Locality')
							{
								$html.='<img src="'.$filterimg.'" style="padding-left:3px;"/>';
							}
						$html.='</th>
						<th style="cursor:pointer;">
							<a onclick="changeTab('.'\'List\''.',\'identifier\',\''.$negorder.'\',\''.$page.'\',\'locality_name\',\'village_name\',\'hh_head_fname\');" title="Sort By Identifier '.$negorder.'" style="text-decoration:none; color:#FFF;">Identifier</a>';
							
							if($order_by=='PID.identifier')
							{
								$html.='<img src="'.$filterimg.'" style="padding-left:3px;"/>';
							}
						$html.='</th>';
                                                
                                                if(strcmp($_SESSION['_staff']['userID'],"drdp")!=0) {

                                                    $html.='<th style="cursor:pointer;">
                                                            <a onclick="changeTab('.'\'List\''.',\'fullname\',\''.$negorder.'\',\''.$page.'\',\'locality_name\',\'village_name\',\'hh_head_fname\');" title="Sort By Name '.$negorder.'" style="text-decoration:none; color:#FFF;">Name</a>';

                                                            if($order_by=='Full_Name')
                                                            {
                                                                    $html.='<img src="'.$filterimg.'" style="padding-left:3px;"/>';
                                                            }
                                                    $html.='</th>';
                                                }
						$html.='<th style="cursor:pointer;">
							<a onclick="changeTab('.'\'List\''.',\'gender\',\''.$negorder.'\',\''.$page.'\',\'locality_name\',\'village_name\',\'hh_head_fname\');" title="Sort By Gender '.$negorder.'" style="text-decoration:none; color:#FFF;">Gender</a>';
							
							if($order_by=='PE.Gender')
							{
								$html.='<img src="'.$filterimg.'" style="padding-left:3px;"/>';
							}
							$html.='</th>
						<th style="cursor:pointer;">
							<a onclick="changeTab('.'\'List\''.',\'age\',\''.$negorder.'\',\''.$page.'\',\'locality_name\',\'village_name\',\'hh_head_fname\');" title="Sort By Age '.$negorder.'" style="text-decoration:none; color:#FFF;">Age</a>';
							
							if($order_by=='Age')
							{
								$html.='<img src="'.$filterimg.'" style="padding-left:3px;"/>';
							}
							$html.='</th>
						<th style="cursor:pointer;">
							<a onclick="changeTab('.'\'List\''.',\'encounter_type\',\''.$negorder.'\',\''.$page.'\',\'locality_name\',\'village_name\',\'hh_head_fname\');" title="Sort By Encounter Type '.$negorder.'" style="text-decoration:none; color:#FFF;">Encounter Type</a>';
							
							if($order_by=='Encounter_Name')
							{
								$html.='<img src="'.$filterimg.'" style="padding-left:3px;"/>';
							}
							$html.='</th>						
						<th style="cursor:pointer;">
							<a onclick="changeTab('.'\'List\''.',\'encounter_date\',\''.$negorder.'\',\''.$page.'\',\'locality_name\',\'village_name\',\'hh_head_fname\');" title="Sort By Encounter Date '.$negorder.'" style="text-decoration:none; color:#FFF;">Encounter Date</a>';
							
							if($order_by=='Encounter_Date')
							{
								$html.='<img src="'.$filterimg.'" style="padding-left:3px;"/>';
							}
							$html.='</th>												
						<th>
							ASHA Assigned</th>
					</tr>';					
										
	$total=0;
	if($tabs_res && ($num=db_num_rows($tabs_res))): 
	    $count=0;
		while ($row = db_fetch_array($tabs_res)) {
			$cssclass = ($count%2==0)?'tr_class_0':'tr_class_1';									
			
			$html.='<tr class="'.$cssclass.'" id="'.$row['id'].'" onclick="onRowSelection(this.id);">                
						<td align="center">&nbsp;'.($row['vill_name']!=""? strtoupper($row['vill_name']):"-").'</td>
						<td align="center">&nbsp;'.($row['locality']!=""? strtoupper($row['locality']):"-").'</td>
						<td align="center">&nbsp;'.$row['patient_id'].'</td>';
                                        if(strcmp($_SESSION['_staff']['userID'],"drdp")!=0) {
						$html.='<td align="center">&nbsp;'.strtoupper($row['first_name'])." ".strtoupper($row['sur_name']).'</td>';
                                        }
						$html.='<td align="center">&nbsp;'.$row['gender'].'</td>
						<td align="center">&nbsp;'.$row['age'].'</td>
						<td align="center">&nbsp;'.$row['enc_type'].'</td>
						<td align="center">&nbsp;'.$row['enc_date'].'</td>						
						<td align="center">&nbsp;'.($row['asha_assigned']!=""?$row['asha_assigned']:"-").'</td>
					</tr>';
			$count++;
		} //end of while.
	else: //no records found!! 
		$html.='<tr class=""><td colspan=9 style="padding-left:8px;"><b>No records found.</b></td></tr>';					
	endif; 
		
	$html.='</table>
			</td>
		</tr>';
	if($num>0 && $pageNav->getNumPages()>1){ //if we actually had any records returned
		$html.='<tr><td class="pagenavcss" style="text-align:left;padding:15px 0 0 10px;"><span style="font-size:16px;">page:</span>'.$pageNav->getPaging().'&nbsp;</td></tr>';
		}
	$html.='</table><br/><div class="clear"></div>';
		
	echo $html;
?>
