<?php
require_once 'BaseLineConfig.php';
// Set up log file
require_once 'KLogger.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
  
         echo "risk factor measurements...";
         WebLog::getInstance()->logInfo("Got into the PHP code");
	$tab_id = $_POST['tablet_id']; //don't forget to include the tablet ID !
	$user = $_POST['user_id'];
	$date = $_POST['date'];
	$time = $_POST['time'];
        if (!isset($_POST["tablet_id"]))
        {
         exit();
         WebLog::getInstance()->logInfo("Did not retrieve value for your device");
        }
	WebLog::getInstance()->logInfo("Now retrieving parameters");
        //extract parameters

	//page1
	$patient_ID = $_POST['patient_id'];
	$consent_no = $_POST['consent_no'];
        $patient_fname = $_POST['given_name'];
        $patient_lname = $_POST['sur_name'];
	$doa_no = $_POST['doa'];        
	$dob_no = $_POST['dob']; 
	$age_calc = $_POST['entered_age'];
        $hh_UUID = $_POST['hh_UUID'];
        $door_no = $_POST['door_no'];
        $locality_id = $_POST['locality_id'];
        $village_id = $_POST['village_id'];       
	
	//$patientBirthdateMonth = $_POST['patientBirthdateMonth'];        
	//$patientBirthdateDay = $_POST['patientBirthdateDay'];        
	//$patientBirthdateYear = $_POST['patientBirthdateYear'];        

	//$patient_doa_Month = $_POST['patient_doa_Month'];        
	//$patient_doa_Day = $_POST['patient_doa_Day'];        
	//$patient_doa_Year = $_POST['patient_doa_Year'];        

        $chk_date_unsure = $_POST['chk_date_unsure'];
	 $gender = $_POST['gender'];
        $marital_status = $_POST['marital_status'];
        $literacy = $_POST['literacy'];
        $occupation = $_POST['occupation'];

	//page2
        $ph_hrtattack = $_POST['ph_hrtattack'];
        $ph_hrtattack_since = $_POST['ph_hrtattack_since'];
        $stroke = $_POST['stroke'];
        $stroke_since = $_POST['stroke_since'];
        $pvd = $_POST['pvd'];
        $pvd_since = $_POST['pvd_since'];
        $dm = $_POST['dm'];
        $dm_since = $_POST['dm_since'];
	
	$ph_bp= $_POST['ph_bp'];
	$ph_bp_since= $_POST['ph_bp_since'];
	$ph_bpMed= $_POST['ph_bpMed'];

	$fh_heartattack = $_POST['fh_heartattack'];
        $fh_stroke = $_POST['fh_stroke'];
        $fh_dm = $_POST['fh_dm'];

        $smoking_question = $_POST['smoking_question'];
        $currently_smoking = $_POST['currently_smoking'];
        $age_at_smoking_starts = $_POST['age_at_smoking_starts'];
        $quit_smoking = $_POST['quit_smoking'];
        $currently_chewing = $_POST['currently_chewing'];
        $age_at_chewing_starts = $_POST['age_at_chewing_starts'];
        $quit_chewing = $_POST['quit_chewing'];


	//page3
	$sbp1 = $_POST['sbp1'];
	$dbp1 = $_POST['dbp1'];
	$hr1 = $_POST['hr1'];
	$sbp2 = $_POST['sbp2'];
	$dbp2 = $_POST['dbp2'];
	$hr2 = $_POST['hr2'];
	$sbp3 = $_POST['sbp3'];
	$dbp3 = $_POST['dbp3'];
	$hr3 = $_POST['hr3'];
	$pulse = $_POST['pulse'];
	$sbp_avg = $_POST['sbp_avg'];
	$dbp_avg = $_POST['dbp_avg'];
	$bp_cuffsize = $_POST['bp_cuffsize'];
	$bg_mgdl = $_POST['bg_mgdl'];
	$bg_eatordrink = $_POST['bg_eatordrink'];
	$bg_Decipher_fasting = $_POST['bg_Decipher_fasting'];
	$spec_aqui_time = $_POST['spec_aqui_time'];
	$bh_taking_medi = $_POST['bh_taking_medi'];
	$bh_frac_in_past = $_POST['bh_frac_in_past'];
	$bh_frac_site = $_POST['bh_frac_site'];
	$health_status = $_POST['health_status'];

	//page4 and beyond
	$contact_num = $_POST['contact_num'];
	$checkbox_sharedphone = $_POST['checkbox_sharedphone'];
	$aadhar_num = $_POST['aadhar_num'];
	$bplt = $_POST['bplt'];
	$lltt = $_POST['lltt'];
	$cvd_antiplatelet_therapy = $_POST['cvd_antiplatelet_therapy'];
        $western_medicine = $_POST['western_medicine'];
	$rec_medicine = $_POST['rec_medicine'];
	$herbal_ayush_med = $_POST['herbal_ayush_med'];

	$vpa_ans = $_POST['vpa_ans'];
	$vpa_ndays = $_POST['vpa_ndays'];
	$vpa_hrs = $_POST['vpa_hrs'];
	$vpa_min = $_POST['vpa_min'];

	$mpa_ans = $_POST['mpa_ans'];
	$mpa_ndays = $_POST['mpa_ndays'];
	$mpa_hrs = $_POST['mpa_hrs'];
	$mpa_min = $_POST['mpa_min'];

	$walking_ans = $_POST['walking_ans'];
	$walking_ndays = $_POST['walking_ndays'];
	$walking_hrs = $_POST['walking_hrs'];
	$walking_min = $_POST['walking_min'];

	$mobility_ans = $_POST['mobility_ans'];
	$selfcare_ans = $_POST['selfcare_ans'];
	$usualactivity_ans = $_POST['usualactivity_ans'];
	$paindiscomfrt = $_POST['paindiscomfrt'];
	$anxiety_dip = $_POST['anxiety_dip'];
	$health_score_today = $_POST['health_score_today'];

	$well_being_index_Q1 = $_POST['well_being_index_Q1'];
	$well_being_index_Q2 = $_POST['well_being_index_Q2'];
	$well_being_index_Q3 = $_POST['well_being_index_Q3'];
	$well_being_index_Q4 = $_POST['well_being_index_Q4'];
	$well_being_index_Q5 = $_POST['well_being_index_Q5'];
	$well_being_index_refuse = $_POST['well_being_index_refuse'];
	$height = $_POST['height'];
	$weight = $_POST['weight'];	
	$cvdrisk= $_POST['cvdrisk'];	


  $screen_date_time = explode(" ", $spec_aqui_time);
  $screened_date = $screen_date_time[0];
  $screened_time = $screen_date_time[1];
       
        WebLog::getInstance()->logInfo("POST parameters extracted");
        echo "Received params  ". $patient_fname . " " . $patient_lname . ".<br />";
               
        
        //database commands here
            //enters if connection to Db is achieved
       // $query = "INSERT INTO testDb ('EVENT_DESC') VALUES '"
       //     .mysql_escape_string($item) ."'";
      
         $query = "INSERT INTO risk_factors(hh_UUID, door_no, locality_id, village_id,tab_id,user,date,time,patient_ID,consent_no,patient_fname,patient_lname, doa_no,dob_no,chk_date_unsure,gender,marital_status,literacy,occupation, ph_hrtattack, ph_hrtattack_since, stroke, stroke_since, pvd, pvd_since, dm, dm_since,ph_bp,ph_bp_since,ph_bpMed,fh_heartattack, fh_stroke, fh_dm, smoking_question, currently_smoking, age_at_smoking_starts, quit_smoking, currently_chewing, age_at_chewing_starts, quit_chewing, sbp1, dbp1, hr1,sbp2,dbp2,hr2,sbp3,dbp3,hr3, pulse, sbp_avg,dbp_avg,bp_cuffsize,bg_mgdl,bg_eatordrink,bg_Decipher_fasting,spec_aqui_time,bh_taking_medi,bh_frac_in_past,bh_frac_site,health_status,
contact_num,checkbox_sharedphone,aadhar_num,bplt,lltt,cvd_antiplatelet_therapy,western_medicine,rec_medicine,herbal_ayush_med,vpa_ans,vpa_ndays,mpa_ans,mpa_ndays,
walking_ans,walking_ndays,mobility_ans,selfcare_ans,usualactivity_ans,paindiscomfrt,anxiety_dip,health_score_today,well_being_index_Q1,
well_being_index_Q2,well_being_index_Q3,well_being_index_Q4,well_being_index_Q5,well_being_index_refuse,height,weight,cvdrisk,vpa_hrs,vpa_min,mpa_hrs,mpa_min,walking_hrs,walking_min,age_calc,screened_date,screened_time)  VALUES "."('".mysql_escape_string($hh_UUID)."','".mysql_escape_string($door_no)."','".mysql_escape_string($locality_id)."','".mysql_escape_string($village_id)."','".mysql_escape_string($tab_id)."','".mysql_escape_string($user)."',curdate(),curtime(),'".mysql_escape_string($patient_ID)."','".mysql_escape_string($consent_no)."','".mysql_escape_string($patient_fname)."','".mysql_escape_string($patient_lname)."','".mysql_escape_string($doa_no)."','".mysql_escape_string($dob_no)."','".mysql_escape_string($chk_date_unsure)."','".mysql_escape_string($gender)."','".mysql_escape_string($marital_status)."','".mysql_escape_string($literacy)."','".mysql_escape_string($occupation)."','".mysql_escape_string($ph_hrtattack)."','".mysql_escape_string($ph_hrtattack_since)."','".mysql_escape_string($stroke)."','".mysql_escape_string($stroke_since)."','".mysql_escape_string($pvd)."','".mysql_escape_string($pvd_since)."','".mysql_escape_string($dm)."','".mysql_escape_string($dm_since)."','".mysql_escape_string($ph_bp)."','".mysql_escape_string($ph_bp_since)."','".mysql_escape_string($ph_bpMed)."','".mysql_escape_string($fh_heartattack)."','".mysql_escape_string($fh_stroke)."','".mysql_escape_string($fh_dm)."','".mysql_escape_string($smoking_question)."','".mysql_escape_string($currently_smoking)."','".mysql_escape_string($age_at_smoking_starts)."','".mysql_escape_string($quit_smoking)."','".mysql_escape_string($currently_chewing)."','".mysql_escape_string($age_at_chewing_starts)."','".mysql_escape_string($quit_chewing)."','".mysql_escape_string($sbp1)."','".mysql_escape_string($dbp1)."','".mysql_escape_string($hr1)."','".mysql_escape_string($sbp2)."','".mysql_escape_string($dbp2)."','".mysql_escape_string($hr2)."','".mysql_escape_string($sbp3)."','".mysql_escape_string($dbp3)."','".mysql_escape_string($hr3)."','".mysql_escape_string($pulse)."','".mysql_escape_string($sbp_avg)."','".mysql_escape_string($dbp_avg)."','".mysql_escape_string($bp_cuffsize)."','".mysql_escape_string($bg_mgdl)."','".mysql_escape_string($bg_eatordrink)."','".mysql_escape_string($bg_Decipher_fasting)."','".mysql_escape_string($spec_aqui_time)."','".mysql_escape_string($bh_taking_medi)."','".mysql_escape_string($bh_frac_in_past)."','".mysql_escape_string($bh_frac_site)."','".mysql_escape_string($health_status)."','".mysql_escape_string($contact_num)."','".mysql_escape_string($checkbox_sharedphone)."','".mysql_escape_string($aadhar_num)."','".mysql_escape_string($bplt)."','".mysql_escape_string($lltt)."','".mysql_escape_string($cvd_antiplatelet_therapy)."','".mysql_escape_string($western_medicine)."','".mysql_escape_string($rec_medicine)."','".mysql_escape_string($herbal_ayush_med)."','".mysql_escape_string($vpa_ans)."','".mysql_escape_string($vpa_ndays)."','".mysql_escape_string($mpa_ans)."','".mysql_escape_string($mpa_ndays)."','".mysql_escape_string($walking_ans)."','".mysql_escape_string($walking_ndays)."','".mysql_escape_string($mobility_ans)."','".mysql_escape_string($selfcare_ans)."','".mysql_escape_string($usualactivity_ans)."','".mysql_escape_string($paindiscomfrt)."','".mysql_escape_string($anxiety_dip)."','".mysql_escape_string($health_score_today)."','".mysql_escape_string($well_being_index_Q1)."','".mysql_escape_string($well_being_index_Q2)."','".mysql_escape_string($well_being_index_Q3)."','".mysql_escape_string($well_being_index_Q4)."','".mysql_escape_string($well_being_index_Q5)."','".mysql_escape_string($well_being_index_refuse)."','".mysql_escape_string($height)."','".mysql_escape_string($weight)."','".mysql_escape_string($cvdrisk).
"','".mysql_escape_string($vpa_hrs)."','".mysql_escape_string($vpa_min)."','".mysql_escape_string($mpa_hrs)."','".mysql_escape_string($mpa_min)."','".mysql_escape_string($walking_hrs)."','".mysql_escape_string($walking_min)."','".mysql_escape_string($age_calc)."','".mysql_escape_string($screened_date)."','".mysql_escape_string($screened_time)."')";
 
        WebLog::getInstance()->logInfo("query is ".$query);
        
       if(! (mysql_query($query,  GetDatabaseConnection() ) ) )
       {
           echo "Error in insertion of db";
           WebLog::getInstance()->logInfo("Error in DB insertion");
       }
       else
	{
	//echo "insertion successful";

      $json_medi_record = $_POST['medication_record'];

         if ($json_medi_record !=="NA") {
              //Here we have medication records. Parse the Json String 
                echo "Medication record Available\n";

                $data = json_decode($json_medi_record);

                foreach ($data->input_medi as $medication) {
                      
                   // echo "name:".$medication->name."||strength:".$medication->strength."||pillsperday:".$medication->pillsperday."\n";

                    //Insert the records into Medication table
                    $medicationquery = "INSERT INTO medication (tab_id,user,Date,Time,patient_ID,name,strength,pillsperday) VALUES"."('".mysql_escape_string($tab_id)."','".mysql_escape_string($user)."','".mysql_escape_string($date)."','".mysql_escape_string($time)."','".mysql_escape_string($patient_ID)."','".mysql_escape_string($medication->name)."','".mysql_escape_string($medication->strength)."','".mysql_escape_string($medication->pillsperday)."')";
 				    if(! (mysql_query($medicationquery,  GetDatabaseConnection() ) ) )
                    {
                          echo "Error in insertion of db";
                          WebLog::getInstance()->logInfo("Error in DB insertion");
                    }
                   else
                    {
                                echo "insertion successful";
                    }

                }
          }
          else{
		echo "insertion successful";                
		echo "Medication records Not Available\n";
		
              }     


      $statsquery = 'INSERT INTO uploadstats (uid,Date,Time,RecordType) VALUES("'.$_POST['tablet_id'].'",curdate(),curtime(),"risk_factors")';
      
                  WebLog::getInstance()->logInfo("query is ".$statsquery);
                       
                  if(! (mysql_query($statsquery,  GetDatabaseConnection() ) ) )
                  {
                          echo "Error in insertion of db";
                          WebLog::getInstance()->logInfo("Error in DB insertion");
                  }
                  else
                  {
                               echo "insertion successful";
                  }

	}
        WebLog::getInstance()->logInfo("End of procedure");
        ?>
    </body>
</html>
