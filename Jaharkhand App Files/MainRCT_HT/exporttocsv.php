<?php
require_once('main.inc.php');

function export2CSVOnBasetable(){
    
    $username=$_SESSION['_staff']['userID'];
    $order_by = 'enc_id';	
    $order='ASC';
    $search_str='';
    $locality ='';
    $vill_name='';
    $current_user_login='';
    $current_encounter='';
    $from_date ='';
    $to_date='';
    
    $locality =  $_GET['locality_name'];
    $vill_name = $_GET['village_name'];
    $current_user_login = $_GET['asha_name'];
    $current_encounter = $_GET['encounter_name'];
    $from_date = $_GET['pfdate'];
    $to_date = $_GET['ptdate'];
    
    
   if($locality != ''){
        $search_str .= " locality = '".$locality."' and";
   }
   if($vill_name != ''){
        $search_str .= " vill_name = '".$vill_name."' and";
   }
   if($current_user_login != ''){
        $search_str .= " current_user_login = '".$current_user_login."' and";
   }
   if($current_encounter != ''){
        $search_str .= " current_encounter = '".$current_encounter."' and";
   }
  
   if($from_date != ''){
        $search_str .= " enc_date >= '".$from_date."' and";
   }
   if($to_date != ''){
        $search_str .= " enc_date <= '".$to_date." 23:59:59' and";
   }
   
   if($search_str == ''){
       $search_str.="and";
   }
   $searchBuilder;
   $searchBuilder = " where ".$search_str." enc_id >0 and patient_id is not null and enc_date is not null"; 
   
  $qselect ='select enc_id,
patient_id,
consent_num,';
if(strcmp($username,"drdp")!=0){
    $qselect.='first_name, sur_name,';
}
$qselect.='contact_num,
shared_phone,
dob,
dob_unsure,
address,
vill_name,
locality,
gender,
doa,
age,
aadhar_num,
ph_hrtattack,
ph_bp,
ph_bp_since,
ph_medication,
ph_stroke,
ph_pvd,
ph_pvd_since,
ph_diab,
ph_hrtattack_since,
ph_stroke_since,
ph_diab_since,
fh_hrtattack,
fh_stroke,
fh_diab,
rh_q1,
rh_q2,
rh_q2_yes,
rh_q2_no,
rh_ques2_if_other_reason,
th_bp,
th_aptt,
th_lltt,
th_diab,
tobacco_ques,
sh_current,
sh_agestarted,
sh_quit,
ch_current,
ch_agestarted,
ch_quit,
sbp1,
dbp1,
sbp2,
dbp2,
sbp3,
dbp3,
hr1,
hr2,
hr3,
sbp_avg,
dbp_avg,
hr_avg,
bp_cuffsize,
pulse,
bg_fasting_calc,
bg_rectime,
bg_value,
tc,
ldl,
hdl,
tg,
chol_resultdate,
ht,
wt,
bg_lasteat,
bp_perday,
bp_perweek,
bp_perlastweek,
bp_peryesterday,
lltt_perday,
lltt_perweek,
lltt_perlastweek,
lltt_peryesterday,
aptt_perday,
aptt_perweek,
aptt_perlastweek,
aptt_peryesterday,
bp_druglist,
lltt_druglist,
aptt_druglist,
med_bp,
med_statin,
med_aspirin,
med_bp_reason,
med_lltt_reason,
med_aptt_reason,
tt_pres,
ref_card_no,
cvd_risk,
smoker_calc,
ref_doc,
next_visit_1month,
tt_adher,
med_received,
update_date,
created_date,
current_user_login,
current_user_role,
last_encounter,
current_encounter,
enc_date,
enc_type,
phc_name,
asha_assigned,
diab_calc,
smoker_tl,
ar_recom,
nv_ar,
nv_ar_tl,
ph_cvd_calc,
high_risk_calc,
nv_diab,
nv_diab_tl,
ref_doc_tl,
target_sbp,
target_sbp_tl,
target_dbp,
target_dbp_tl from cvd_basetable';
      $query="$qselect ".$searchBuilder." ORDER BY $order_by $order ";
      //echo $query;
      $result = db_query($query);
	
	$filename ="";
	
	if($_GET['locality_name'] != '')
		$filename = $_GET['locality_name'];
	if($_GET['village_name'] != '')
		$filename .= "_".$_GET['village_name'];
	if($_GET['asha_name'] != '')
		$filename .= "_".$_GET['asha_name'];
	
	$filename = str_replace(" ","",$filename);
	
	if($filename != "")
		$filename = 'sh_'.$filename.'_'.date('Y-M-d');
	else
		$filename = 'sh_'.date('Y-M-d');
	
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$filename.'.csv');
	header('Pragma: no-cache');
	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	// output the column headings
        
         if(strcmp($username,"drdp")==0){
               fputcsv($output, array('enc_id',
                'patient_id',
                'consent_num',
                'contact_num',
                'shared_phone',
                'dob',
                'dob_unsure',
                'address',
                'vill_name',
                'locality',
                'gender',
                'doa',
                'age',
                'aadhar_num',
                'ph_hrtattack',
                'ph_bp',
                'ph_bp_since',
                'ph_medication',
                'ph_stroke',
                'ph_pvd',
                'ph_pvd_since',
                'ph_diab',
                'ph_hrtattack_since',
                'ph_stroke_since',
                'ph_diab_since',
                'fh_hrtattack',
                'fh_stroke',
                'fh_diab',
                'rh_q1',
                'rh_q2',
                'rh_q2_yes',
                'rh_q2_no',
                'rh_ques2_if_other_reason',
                'th_bp',
                'th_aptt',
                'th_lltt',
                'th_diab',
                'tobacco_ques',
                'sh_current',
                'sh_agestarted',
                'sh_quit',
                'ch_current',
                'ch_agestarted',
                'ch_quit',
                'sbp1',
                'dbp1',
                'sbp2',
                'dbp2',
                'sbp3',
                'dbp3',
                'hr1',
                'hr2',
                'hr3',
                'sbp_avg',
                'dbp_avg',
                'hr_avg',
                'bp_cuffsize',
                'pulse',
                'bg_fasting_calc',
                'bg_rectime',
                'bg_value',
                'tc',
                'ldl',
                'hdl',
                'tg',
                'chol_resultdate',
                'ht',
                'wt',
                'bg_lasteat',
                'bp_perday',
                'bp_perweek',
                'bp_perlastweek',
                'bp_peryesterday',
                'lltt_perday',
                'lltt_perweek',
                'lltt_perlastweek',
                'lltt_peryesterday',
                'aptt_perday',
                'aptt_perweek',
                'aptt_perlastweek',
                'aptt_peryesterday',
                'bp_druglist',
                'lltt_druglist',
                'aptt_druglist',
                'med_bp',
                'med_statin',
                'med_aspirin',
                'med_bp_reason',
                'med_lltt_reason',
                'med_aptt_reason',
                'tt_pres',
                'ref_card_no',
                'cvd_risk',
                'smoker_calc',
                'ref_doc',
                'next_visit_1month',
                'tt_adher',
                'med_received',
                'update_date',
                'created_date',
                'current_user_login',
                'current_user_role',
                'last_encounter',
                'current_encounter',
                'enc_date',
                'enc_type',
                'phc_name',
                'asha_assigned',
                'diab_calc',
                'smoker_tl',
                'ar_recom',
                'nv_ar',
                'nv_ar_tl',
                'ph_cvd_calc',
                'high_risk_calc',
                'nv_diab',
                'nv_diab_tl',
                'ref_doc_tl',
                'target_sbp',
                'target_sbp_tl',
                'target_dbp',
                'target_dbp_tl'
                ));
         }else{
              fputcsv($output, array('enc_id',
            'patient_id',
            'consent_num',
            'first_name',
            'sur_name',
            'contact_num',
            'shared_phone',
            'dob',
            'dob_unsure',
            'address',
            'vill_name',
            'locality',
            'gender',
            'doa',
            'age',
            'aadhar_num',
            'ph_hrtattack',
            'ph_bp',
            'ph_bp_since',
            'ph_medication',
            'ph_stroke',
            'ph_pvd',
            'ph_pvd_since',
            'ph_diab',
            'ph_hrtattack_since',
            'ph_stroke_since',
            'ph_diab_since',
            'fh_hrtattack',
            'fh_stroke',
            'fh_diab',
            'rh_q1',
            'rh_q2',
            'rh_q2_yes',
            'rh_q2_no',
            'rh_ques2_if_other_reason',
            'th_bp',
            'th_aptt',
            'th_lltt',
            'th_diab',
            'tobacco_ques',
            'sh_current',
            'sh_agestarted',
            'sh_quit',
            'ch_current',
            'ch_agestarted',
            'ch_quit',
            'sbp1',
            'dbp1',
            'sbp2',
            'dbp2',
            'sbp3',
            'dbp3',
            'hr1',
            'hr2',
            'hr3',
            'sbp_avg',
            'dbp_avg',
            'hr_avg',
            'bp_cuffsize',
            'pulse',
            'bg_fasting_calc',
            'bg_rectime',
            'bg_value',
            'tc',
            'ldl',
            'hdl',
            'tg',
            'chol_resultdate',
            'ht',
            'wt',
            'bg_lasteat',
            'bp_perday',
            'bp_perweek',
            'bp_perlastweek',
            'bp_peryesterday',
            'lltt_perday',
            'lltt_perweek',
            'lltt_perlastweek',
            'lltt_peryesterday',
            'aptt_perday',
            'aptt_perweek',
            'aptt_perlastweek',
            'aptt_peryesterday',
            'bp_druglist',
            'lltt_druglist',
            'aptt_druglist',
            'med_bp',
            'med_statin',
            'med_aspirin',
            'med_bp_reason',
            'med_lltt_reason',
            'med_aptt_reason',
            'tt_pres',
            'ref_card_no',
            'cvd_risk',
            'smoker_calc',
            'ref_doc',
            'next_visit_1month',
            'tt_adher',
            'med_received',
            'update_date',
            'created_date',
            'current_user_login',
            'current_user_role',
            'last_encounter',
            'current_encounter',
            'enc_date',
            'enc_type',
            'phc_name',
            'asha_assigned',
            'diab_calc',
            'smoker_tl',
            'ar_recom',
            'nv_ar',
            'nv_ar_tl',
            'ph_cvd_calc',
            'high_risk_calc',
            'nv_diab',
            'nv_diab_tl',
            'ref_doc_tl',
            'target_sbp',
            'target_sbp_tl',
            'target_dbp',
            'target_dbp_tl'
            ));
         }

  // fetch the data		
	// loop over the rows, outputting them
	while ($row = mysql_fetch_assoc($result)) 
		fputcsv($output, $row);
		
	fpassthru($output);
        
    
}

function export2AllCSVOnBasetable(){
    $username=$_SESSION['_staff']['userID'];
       $qselect ='select enc_id,
        patient_id,
        consent_num,';
if(strcmp($username,"drdp")!=0){
        $qselect.='first_name, sur_name,';
}
        $qselect.='contact_num,
        shared_phone,
        dob,
        dob_unsure,
        address,
        vill_name,
        locality,
        gender,
        doa,
        age,
        aadhar_num,
        ph_hrtattack,
        ph_bp,
        ph_bp_since,
        ph_medication,
        ph_stroke,
        ph_pvd,
        ph_pvd_since,
        ph_diab,
        ph_hrtattack_since,
        ph_stroke_since,
        ph_diab_since,
        fh_hrtattack,
        fh_stroke,
        fh_diab,
        rh_q1,
        rh_q2,
        rh_q2_yes,
        rh_q2_no,
        rh_ques2_if_other_reason,
        th_bp,
        th_aptt,
        th_lltt,
        th_diab,
        tobacco_ques,
        sh_current,
        sh_agestarted,
        sh_quit,
        ch_current,
        ch_agestarted,
        ch_quit,
        sbp1,
        dbp1,
        sbp2,
        dbp2,
        sbp3,
        dbp3,
        hr1,
        hr2,
        hr3,
        sbp_avg,
        dbp_avg,
        hr_avg,
        bp_cuffsize,
        pulse,
        bg_fasting_calc,
        bg_rectime,
        bg_value,
        tc,
        ldl,
        hdl,
        tg,
        chol_resultdate,
        ht,
        wt,
        bg_lasteat,
        bp_perday,
        bp_perweek,
        bp_perlastweek,
        bp_peryesterday,
        lltt_perday,
        lltt_perweek,
        lltt_perlastweek,
        lltt_peryesterday,
        aptt_perday,
        aptt_perweek,
        aptt_perlastweek,
        aptt_peryesterday,
        bp_druglist,
        lltt_druglist,
        aptt_druglist,
        med_bp,
        med_statin,
        med_aspirin,
        med_bp_reason,
        med_lltt_reason,
        med_aptt_reason,
        tt_pres,
        ref_card_no,
        cvd_risk,
        smoker_calc,
        ref_doc,
        next_visit_1month,
        tt_adher,
        med_received,
        update_date,
        created_date,
        current_user_login,
        current_user_role,
        last_encounter,
        current_encounter,
        enc_date,
        enc_type,
        phc_name,
        asha_assigned,
        diab_calc,
        smoker_tl,
        ar_recom,
        nv_ar,
        nv_ar_tl,
        ph_cvd_calc,
        high_risk_calc,
        nv_diab,
        nv_diab_tl,
        ref_doc_tl,
        target_sbp,
        target_sbp_tl,
        target_dbp,
        target_dbp_tl from cvd_basetable where patient_id is not null and enc_date is not null';
      $query="$qselect";
      $result = db_query($query);
      $filename ="";
      $filename = 'sh_cvd_all_data_'.date('Y-M-d');
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename='.$filename.'.csv');
      header('Pragma: no-cache');
      // create a file pointer connected to the output stream
      $output = fopen('php://output', 'w');
        // output the column headings
      
      if(strcmp($username,"drdp")==0){
          fputcsv($output, array('enc_id',
                    'patient_id',
                    'consent_num',
                    'contact_num',
                    'shared_phone',
                    'dob',
                    'dob_unsure',
                    'address',
                    'vill_name',
                    'locality',
                    'gender',
                    'doa',
                    'age',
                    'aadhar_num',
                    'ph_hrtattack',
                    'ph_bp',
                    'ph_bp_since',
                    'ph_medication',
                    'ph_stroke',
                    'ph_pvd',
                    'ph_pvd_since',
                    'ph_diab',
                    'ph_hrtattack_since',
                    'ph_stroke_since',
                    'ph_diab_since',
                    'fh_hrtattack',
                    'fh_stroke',
                    'fh_diab',
                    'rh_q1',
                    'rh_q2',
                    'rh_q2_yes',
                    'rh_q2_no',
                    'rh_ques2_if_other_reason',
                    'th_bp',
                    'th_aptt',
                    'th_lltt',
                    'th_diab',
                    'tobacco_ques',
                    'sh_current',
                    'sh_agestarted',
                    'sh_quit',
                    'ch_current',
                    'ch_agestarted',
                    'ch_quit',
                    'sbp1',
                    'dbp1',
                    'sbp2',
                    'dbp2',
                    'sbp3',
                    'dbp3',
                    'hr1',
                    'hr2',
                    'hr3',
                    'sbp_avg',
                    'dbp_avg',
                    'hr_avg',
                    'bp_cuffsize',
                    'pulse',
                    'bg_fasting_calc',
                    'bg_rectime',
                    'bg_value',
                    'tc',
                    'ldl',
                    'hdl',
                    'tg',
                    'chol_resultdate',
                    'ht',
                    'wt',
                    'bg_lasteat',
                    'bp_perday',
                    'bp_perweek',
                    'bp_perlastweek',
                    'bp_peryesterday',
                    'lltt_perday',
                    'lltt_perweek',
                    'lltt_perlastweek',
                    'lltt_peryesterday',
                    'aptt_perday',
                    'aptt_perweek',
                    'aptt_perlastweek',
                    'aptt_peryesterday',
                    'bp_druglist',
                    'lltt_druglist',
                    'aptt_druglist',
                    'med_bp',
                    'med_statin',
                    'med_aspirin',
                    'med_bp_reason',
                    'med_lltt_reason',
                    'med_aptt_reason',
                    'tt_pres',
                    'ref_card_no',
                    'cvd_risk',
                    'smoker_calc',
                    'ref_doc',
                    'next_visit_1month',
                    'tt_adher',
                    'med_received',
                    'update_date',
                    'created_date',
                    'current_user_login',
                    'current_user_role',
                    'last_encounter',
                    'current_encounter',
                    'enc_date',
                    'enc_type',
                    'phc_name',
                    'asha_assigned',
                    'diab_calc',
                    'smoker_tl',
                    'ar_recom',
                    'nv_ar',
                    'nv_ar_tl',
                    'ph_cvd_calc',
                    'high_risk_calc',
                    'nv_diab',
                    'nv_diab_tl',
                    'ref_doc_tl',
                    'target_sbp',
                    'target_sbp_tl',
                    'target_dbp',
                    'target_dbp_tl'
                    ));
             }else{
                   fputcsv($output, array('enc_id',
                    'patient_id',
                    'consent_num',
                    'first_name',
                    'sur_name',
                    'contact_num',
                    'shared_phone',
                    'dob',
                    'dob_unsure',
                    'address',
                    'vill_name',
                    'locality',
                    'gender',
                    'doa',
                    'age',
                    'aadhar_num',
                    'ph_hrtattack',
                    'ph_bp',
                    'ph_bp_since',
                    'ph_medication',
                    'ph_stroke',
                    'ph_pvd',
                    'ph_pvd_since',
                    'ph_diab',
                    'ph_hrtattack_since',
                    'ph_stroke_since',
                    'ph_diab_since',
                    'fh_hrtattack',
                    'fh_stroke',
                    'fh_diab',
                    'rh_q1',
                    'rh_q2',
                    'rh_q2_yes',
                    'rh_q2_no',
                    'rh_ques2_if_other_reason',
                    'th_bp',
                    'th_aptt',
                    'th_lltt',
                    'th_diab',
                    'tobacco_ques',
                    'sh_current',
                    'sh_agestarted',
                    'sh_quit',
                    'ch_current',
                    'ch_agestarted',
                    'ch_quit',
                    'sbp1',
                    'dbp1',
                    'sbp2',
                    'dbp2',
                    'sbp3',
                    'dbp3',
                    'hr1',
                    'hr2',
                    'hr3',
                    'sbp_avg',
                    'dbp_avg',
                    'hr_avg',
                    'bp_cuffsize',
                    'pulse',
                    'bg_fasting_calc',
                    'bg_rectime',
                    'bg_value',
                    'tc',
                    'ldl',
                    'hdl',
                    'tg',
                    'chol_resultdate',
                    'ht',
                    'wt',
                    'bg_lasteat',
                    'bp_perday',
                    'bp_perweek',
                    'bp_perlastweek',
                    'bp_peryesterday',
                    'lltt_perday',
                    'lltt_perweek',
                    'lltt_perlastweek',
                    'lltt_peryesterday',
                    'aptt_perday',
                    'aptt_perweek',
                    'aptt_perlastweek',
                    'aptt_peryesterday',
                    'bp_druglist',
                    'lltt_druglist',
                    'aptt_druglist',
                    'med_bp',
                    'med_statin',
                    'med_aspirin',
                    'med_bp_reason',
                    'med_lltt_reason',
                    'med_aptt_reason',
                    'tt_pres',
                    'ref_card_no',
                    'cvd_risk',
                    'smoker_calc',
                    'ref_doc',
                    'next_visit_1month',
                    'tt_adher',
                    'med_received',
                    'update_date',
                    'created_date',
                    'current_user_login',
                    'current_user_role',
                    'last_encounter',
                    'current_encounter',
                    'enc_date',
                    'enc_type',
                    'phc_name',
                    'asha_assigned',
                    'diab_calc',
                    'smoker_tl',
                    'ar_recom',
                    'nv_ar',
                    'nv_ar_tl',
                    'ph_cvd_calc',
                    'high_risk_calc',
                    'nv_diab',
                    'nv_diab_tl',
                    'ref_doc_tl',
                    'target_sbp',
                    'target_sbp_tl',
                    'target_dbp',
                    'target_dbp_tl'
                    ));
      }
      
     // fetch the data		
	// loop over the rows, outputting them
    while ($row = mysql_fetch_assoc($result)) 
	fputcsv($output, $row);
		
    fpassthru($output);
        
}

function Export2CSV() {
			
	$order_by = 'person_attr.Village';	
	$order='ASC';
	
	$search_arr = array(
				'person_attr.Locality' => $_GET['locality_name'],
				'person_attr.Village' => $_GET['village_name'],
				'person_attr.ASHA_assigned' => $_GET['asha_name'],
				'ET.name' => $_GET['encounter_name']
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
		$search_str = " where ".trim($search_str,'and');
	}
	
	$qselect='Select E.encounter_id,person_attr.Village,person_attr.Locality,PID.identifier,
	ifnull(PN.given_name,\'\') given_name,ifnull(PN.family_name,\'\') family_name,
	PE.Gender,
	(year(now())-year(PE.birthdate)) Age,
	ET.name Encounter_Name,
	E.encounter_datetime Encounter_Date,
	person_attr.ASHA_assigned
	from encounter E 
	JOIN patient P on E.patient_id = P.patient_id
	JOIN encounter_type ET on E.encounter_type = ET.encounter_type_id
	JOIN patient_identifier PID ON P.patient_id = PID.patient_id and PID.identifier_type = 2
	JOIN person PE ON P.patient_id = PE.person_id
	JOIN person_name PN ON PE.person_id = PN.person_id
	JOIN (select aaa.Person_ID,  
		max(if(aaa.Attribute_Name = \'Village\',aaa.Value,NULL)) as \'Village\',     
		max(if(aaa.Attribute_Name =  \'ASHA_assigned\',aaa.Value,NULL)) as  \'ASHA_assigned\',
		max(if(aaa.Attribute_Name = \'PHC\',aaa.Value,NULL)) as \'PHC\',
		max(if(aaa.Attribute_Name = \'patientLocality\',aaa.Value,NULL)) as \'Locality\'
		from (Select 
				a.person_id as Person_ID,
				PAT.name Attribute_Name,
				a.Value as Value
				from (Select * from person_attribute order by date_created desc) a
		JOIN person_attribute_type PAT ON a.person_attribute_type_id = PAT.person_attribute_type_id
		group by a.person_attribute_type_id , person_id
		order by a.person_id asc, a.person_attribute_type_id ) aaa 
	group by aaa.Person_ID order by aaa.Person_ID) person_attr on PE.person_id = person_attr.Person_ID';		

	//Pagenation stuff....wish MYSQL could auto pagenate (something better than limit)
	$query="$qselect ".$search_str." ORDER BY $order_by $order ";
	
	$result = db_query($query);
	
	$filename ="";
	
	if($_GET['locality_name'] != '')
		$filename = $_GET['locality_name'];
	if($_GET['village_name'] != '')
		$filename .= "_".$_GET['village_name'];
	if($_GET['asha_name'] != '')
		$filename .= "_".$_GET['asha_name'];
	
	$filename = str_replace(" ","",$filename);
	
	if($filename != "")
		$filename = 'sh_'.$filename.'_'.date('Y-M-d');
	else
		$filename = 'sh_'.date('Y-M-d');
	
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename='.$filename.'.csv');
	header('Pragma: no-cache');
	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	
	//$col_array = array('Village Name','Locality Name','Identifier','First Name', 'Last Name','Gender','Age','Encounter Type','Encounter Date','ASHA Assigned');
	
	$col_array = array();

	$array_csv = array("PHC_NAME" => "NA",
"VILL_NAME" => "NA",
"ASHA_ASSIGNED" => "NA",
"ENC_TYPE" => "NA",
"ENC_DATE" => "NA",
"LOCALITY" => "NA",
"ADDRESS" => "NA",
"PATIENT_ID" => "NA",
"CONSENT_NUM" => "NA",
"FIRST_NAME" => "NA",
"SUR_NAME" => "NA",
"CONTACT_NUM" => "NA",
"SHARED_PHONE" => "NA",
"DOB" => "NA",
"DOB_UNSURE" => "NA",
"DOA" => "NA",
"AGE" => "NA",
"GENDER" => "NA",
"PH_HRTATTACK" => "NA",
"PH_HRTATTACK_SINCE" => "NA",
"PH_STROKE" => "NA",
"PH_STROKE_SINCE" => "NA",
"PH_PVD" => "NA",
"PH_PVD_SINCE" => "NA",
"PH_BP" => "NA",
"PH_BP_SINCE" => "NA",
"PH_DIAB" => "NA",
"PH_DIAB_SINCE" => "NA",
"FH_HRTATTACK" => "NA",
"FH_STROKE" => "NA",
"FH_DIAB" => "NA",
"TH_BP" => "NA",
"TH_APTT" => "NA",
"TH_LLTT" => "NA",
"TH_DIAB" => "NA",
"BP_DRUGLIST" => "NA",
"BP_PERDAY" => "NA",
"BP_PERWEEK" => "NA",
"BP_PERLASTWEEK" => "NA",
"BP_PERYESTERDAY" => "NA",
"APTT_DRUGLIST" => "NA",
"APTT_PERDAY" => "NA",
"APTT_PERWEEK" => "NA",
"APTT_PERLASTWEEK" => "NA",
"APTT_PERYESTERDAY" => "NA",
"LLTT_DRUGLIST" => "NA",
"LLTT_PERDAY" => "NA",
"LLTT_PERWEEK" => "NA",
"LLTT_PERLASTWEEK" => "NA",
"LLTT_PERYESTERDAY" => "NA",
"TOBACCO_QUES" => "NA",
"SH_CURRENT" => "NA",
"SH_QUIT" => "NA",
"SH_AGESTARTED" => "NA",
"CH_CURRENT" => "NA",
"CH_QUIT" => "NA",
"CH_AGESTARTED" => "NA",
"SBP1" => "NA",
"SBP2" => "NA",
"SBP3" => "NA",
"DBP1" => "NA",
"DBP2" => "NA",
"DBP3" => "NA",
"HR1" => "NA",
"HR2" => "NA",
"HR3" => "NA",
"SBP_AVG" => "NA",
"DBP_AVG" => "NA",
"HR_AVG" => "NA",
"BP_CUFFSIZE" => "NA",
"BG_VALUE" => "NA",
"BG_LASTEAT" => "NA",
"BG_RECTIME" => "NA",
"TC" => "NA",
"HDL" => "NA",
"LDL" => "NA",
"TG" => "NA",
"CHOL_RESULTDATE" => "NA",
"HT" => "NA",
"WT" => "NA",
"PH_CVD_CALC" => "NA",
"FH_CVD_CALC" => "NA",
"SMOKER_CALC" => "NA",
"DIAB_CALC" => "NA",
"SMOKER_TL" => "NA",
"BG_FASTING_CALC" => "NA",
"CVD_RISK" => "NA",
"AR_RECOM" => "NA",
"NV_AR" => "NA",
"NV_DIAB" => "NA",
"REF_DOC" => "NA",
"RH_Q1" => "NA",
"RH_Q2" => "NA",
"RH_Q2_YES" => "NA",
"RH_Q2_NO" => "NA",
"TARGET_SBP" => "NA",
"TARGET_SBP_TL" => "NA",
"TARGET_DBP" => "NA",
"TARGET_DBP_TL" => "NA",
"MED_BP" => "NA",
"MED_STATIN" => "NA",
"MED_ASPIRIN" => "NA",
"MED_BP_REASON" => "NA",
"MED_LLTT_REASON" => "NA",
"MED_APTT_REASON" => "NA",
"NEXT_VISIT_1MONTH" => "NA",
"TT_ADHER" => "NA",
"MED_RECEIVED" => "NA",
"UPDATE_DATE" => "NA",
"CREATED_DATE" => "NA",
"CURRENT_USER_LOGIN" => "NA",
"CURRENT_USER_ROLE" => "NA",
"LAST_ENCOUNTER" => "NA",
"CURRENT_ENCOUNTER" => "NA",
"TT_PRES" => "NA",
"REF_CARD_NO" => "NA",
"HIGH_RISK_CALC" => "NA");
	
	foreach($array_csv as $key => $value)
	{
		array_push($col_array, $key);
	}
		
	// output the column headings
	fputcsv($output, $col_array);

	$row_array = array();
	// fetch the data		
	// loop over the rows, outputting them
	while ($row = mysql_fetch_assoc($result))
	{
		//$row_array = $row;
		$obs_result = db_query('Select cn.concept_id,cn.name,ifnull(o.value_text,\'NA\') Value from concept_name cn 
						left outer join obs o on cn.concept_id = o.concept_id and o.encounter_id = '.$row['encounter_id'].'
						where cn.locale=\'en\' and cn.voided =\'0\' order by cn.concept_id');
		
		while ($obs_row = mysql_fetch_assoc($obs_result))
		{		
			if (array_key_exists($obs_row['name'],$array_csv))
			{
				$array_csv[$obs_row['name']] = $obs_row['Value'];				
			}						
		}
		foreach($array_csv as $key => $value)
		{
			array_push($row_array, $value);
			$array_csv[$key] = 'NA';
		}
		
		//array_shift($row_array);
		fputcsv($output, $row_array);
		$row_array = array();
	}
	
	fpassthru($output);
}

function ExportAll2CSV() {

	// Pick a filename and destination directory for the file
	// Remember that the folder where you want to write the file has to be writable
	$time = time();
	$dir = getcwd()."/tmp";
	if(!file_exists($dir))
	{	
		mkdir($dir,0777);
	}
	$file_path = $dir.'/';
	
	$hh_filename = "patient_".$time.".csv";
	
	$order_by = 'person_attr.Village';	
	$order='ASC';	
	
	$qselect='Select E.encounter_id,person_attr.Village,person_attr.Locality,PID.identifier,
	ifnull(PN.given_name,\'\') given_name,ifnull(PN.family_name,\'\') family_name,
	PE.Gender,
	(year(now())-year(PE.birthdate)) Age,
	ET.name Encounter_Name,
	E.encounter_datetime Encounter_Date,
	person_attr.ASHA_assigned
	from encounter E 
	JOIN patient P on E.patient_id = P.patient_id
	JOIN encounter_type ET on E.encounter_type = ET.encounter_type_id
	JOIN patient_identifier PID ON P.patient_id = PID.patient_id and PID.identifier_type = 2
	JOIN person PE ON P.patient_id = PE.person_id
	JOIN person_name PN ON PE.person_id = PN.person_id
	JOIN (select aaa.Person_ID,  
		max(if(aaa.Attribute_Name = \'Village\',aaa.Value,NULL)) as \'Village\',     
		max(if(aaa.Attribute_Name =  \'ASHA_assigned\',aaa.Value,NULL)) as  \'ASHA_assigned\',
		max(if(aaa.Attribute_Name = \'PHC\',aaa.Value,NULL)) as \'PHC\',
		max(if(aaa.Attribute_Name = \'patientLocality\',aaa.Value,NULL)) as \'Locality\'
		from (Select 
				a.person_id as Person_ID,
				PAT.name Attribute_Name,
				a.Value as Value
				from (Select * from person_attribute order by date_created desc) a
		JOIN person_attribute_type PAT ON a.person_attribute_type_id = PAT.person_attribute_type_id
		group by a.person_attribute_type_id , person_id
		order by a.person_id asc, a.person_attribute_type_id ) aaa 
	group by aaa.Person_ID order by aaa.Person_ID) person_attr on PE.person_id = person_attr.Person_ID';		

	//Pagenation stuff....wish MYSQL could auto pagenate (something better than limit)
	$query="$qselect ORDER BY $order_by $order ";		
	
	$result = db_query($query);
	
	// Actually create the file
	// The w+ parameter will wipe out and overwrite any existing file with the same name
	$handle = fopen($file_path.$hh_filename, 'w+');
	 
	$col_array = array();
	//$col_array = array('Village Name','Locality Name','Identifier','First Name', 'Last Name','Gender','Age','Encounter Type','Encounter Date','ASHA Assigned');

	$array_csv = array("PHC_NAME" => "NA",
"VILL_NAME" => "NA",
"ASHA_ASSIGNED" => "NA",
"ENC_TYPE" => "NA",
"ENC_DATE" => "NA",
"LOCALITY" => "NA",
"ADDRESS" => "NA",
"PATIENT_ID" => "NA",
"CONSENT_NUM" => "NA",
"FIRST_NAME" => "NA",
"SUR_NAME" => "NA",
"CONTACT_NUM" => "NA",
"SHARED_PHONE" => "NA",
"DOB" => "NA",
"DOB_UNSURE" => "NA",
"DOA" => "NA",
"AGE" => "NA",
"GENDER" => "NA",
"PH_HRTATTACK" => "NA",
"PH_HRTATTACK_SINCE" => "NA",
"PH_STROKE" => "NA",
"PH_STROKE_SINCE" => "NA",
"PH_PVD" => "NA",
"PH_PVD_SINCE" => "NA",
"PH_BP" => "NA",
"PH_BP_SINCE" => "NA",
"PH_DIAB" => "NA",
"PH_DIAB_SINCE" => "NA",
"FH_HRTATTACK" => "NA",
"FH_STROKE" => "NA",
"FH_DIAB" => "NA",
"TH_BP" => "NA",
"TH_APTT" => "NA",
"TH_LLTT" => "NA",
"TH_DIAB" => "NA",
"BP_DRUGLIST" => "NA",
"BP_PERDAY" => "NA",
"BP_PERWEEK" => "NA",
"BP_PERLASTWEEK" => "NA",
"BP_PERYESTERDAY" => "NA",
"APTT_DRUGLIST" => "NA",
"APTT_PERDAY" => "NA",
"APTT_PERWEEK" => "NA",
"APTT_PERLASTWEEK" => "NA",
"APTT_PERYESTERDAY" => "NA",
"LLTT_DRUGLIST" => "NA",
"LLTT_PERDAY" => "NA",
"LLTT_PERWEEK" => "NA",
"LLTT_PERLASTWEEK" => "NA",
"LLTT_PERYESTERDAY" => "NA",
"TOBACCO_QUES" => "NA",
"SH_CURRENT" => "NA",
"SH_QUIT" => "NA",
"SH_AGESTARTED" => "NA",
"CH_CURRENT" => "NA",
"CH_QUIT" => "NA",
"CH_AGESTARTED" => "NA",
"SBP1" => "NA",
"SBP2" => "NA",
"SBP3" => "NA",
"DBP1" => "NA",
"DBP2" => "NA",
"DBP3" => "NA",
"HR1" => "NA",
"HR2" => "NA",
"HR3" => "NA",
"SBP_AVG" => "NA",
"DBP_AVG" => "NA",
"HR_AVG" => "NA",
"BP_CUFFSIZE" => "NA",
"BG_VALUE" => "NA",
"BG_LASTEAT" => "NA",
"BG_RECTIME" => "NA",
"TC" => "NA",
"HDL" => "NA",
"LDL" => "NA",
"TG" => "NA",
"CHOL_RESULTDATE" => "NA",
"HT" => "NA",
"WT" => "NA",
"PH_CVD_CALC" => "NA",
"FH_CVD_CALC" => "NA",
"SMOKER_CALC" => "NA",
"DIAB_CALC" => "NA",
"SMOKER_TL" => "NA",
"BG_FASTING_CALC" => "NA",
"CVD_RISK" => "NA",
"AR_RECOM" => "NA",
"NV_AR" => "NA",
"NV_DIAB" => "NA",
"REF_DOC" => "NA",
"RH_Q1" => "NA",
"RH_Q2" => "NA",
"RH_Q2_YES" => "NA",
"RH_Q2_NO" => "NA",
"TARGET_SBP" => "NA",
"TARGET_SBP_TL" => "NA",
"TARGET_DBP" => "NA",
"TARGET_DBP_TL" => "NA",
"MED_BP" => "NA",
"MED_STATIN" => "NA",
"MED_ASPIRIN" => "NA",
"MED_BP_REASON" => "NA",
"MED_LLTT_REASON" => "NA",
"MED_APTT_REASON" => "NA",
"NEXT_VISIT_1MONTH" => "NA",
"TT_ADHER" => "NA",
"MED_RECEIVED" => "NA",
"UPDATE_DATE" => "NA",
"CREATED_DATE" => "NA",
"CURRENT_USER_LOGIN" => "NA",
"CURRENT_USER_ROLE" => "NA",
"LAST_ENCOUNTER" => "NA",
"CURRENT_ENCOUNTER" => "NA",
"TT_PRES" => "NA",
"REF_CARD_NO" => "NA",
"HIGH_RISK_CALC" => "NA");
	
	foreach($array_csv as $key => $value)
	{
		array_push($col_array, $key);
	}
		
	// output the column headings
	fputcsv($handle, $col_array);
	
	$row_array = array();
	// fetch the data		
	// Write all the user records to the spreadsheet
	while ($row = mysql_fetch_assoc($result))
	{
		//$row_array = $row;
		$obs_result = db_query('Select cn.concept_id,cn.name,ifnull(o.value_text,\'NA\') Value from concept_name cn 
						left outer join obs o on cn.concept_id = o.concept_id and o.encounter_id = '.$row['encounter_id'].'
						where cn.locale=\'en\' and cn.voided =\'0\' order by cn.concept_id');
		
		while ($obs_row = mysql_fetch_assoc($obs_result))
		{		
			if (array_key_exists($obs_row['name'],$array_csv))
			{
				$array_csv[$obs_row['name']] = $obs_row['Value'];				
			}						
		}
		foreach($array_csv as $key => $value)
		{
			array_push($row_array, $value);
			$array_csv[$key] = 'NA';
		}
		
		//array_shift($row_array);
		fputcsv($handle, $row_array);
		$row_array = array();
	}
	 
	// Finish writing the file
	fclose($handle);
	
	$file_names = array();
	array_push($file_names, $hh_filename);
	
	$archive_file_name = $file_path.'smarthealth_data_'.$time.'.zip';
	$zip_file = 'smarthealth_data_'.$time.'.zip';
	
	$zip = new ZipArchive();
	//create the file and throw the error if unsuccessful
	if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
    	exit("cannot open <$archive_file_name>\n");
	}
	//add each files of $file_name array to archive
	foreach($file_names as $files)
	{
  		$zip->addFile($file_path.$files,$files);
		//echo $file_path.$files,$files."<br />";
	}
	$zip->close();
	
	header("Content-type: application/zip");
	header('Content-Disposition: attachment; filename='.$zip_file);
	header("Pragma: no-cache"); 
	header("Expires: 0");
	// create a file pointer connected to the output stream
	
	readfile("$archive_file_name");
	
	//ADD UNLINK TO DELETE FILE AFTER DOWNLOAD
	unlink("$archive_file_name");
	foreach($file_names as $files)
	{
  		unlink($file_path.$files);		
	}
	exit;				
}

if(isset($_GET['exporttype'])){
	if($_GET['exporttype'] == 'export')
		export2CSVOnBasetable();
	if($_GET['exporttype'] == 'exportall')
		export2AllCSVOnBasetable();
}
?>