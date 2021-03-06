<?php

namespace App\Models;

use DB;

class UsersModel extends CommonModel
{

    public function loginCheck()
    {
        $users = DB::table('cvd_users')
                ->select('*')
                ->where($this->where);
        $users = $users->get();

        if (count($users) == 0) {
            return NULL;
        }
        return $users;
    }

    public function getUsers($columnName = NULL)
    {
        $users = DB::table('cvd_users')
                ->select('cvd_users.*', 'roles.role_name')
                ->join('role_users', 'users.user_id', '=', 'role_users.user_id')
                ->join('roles', 'roles.role_id', '=', 'role_users.role_id')
                ->where($this->where);
        if ($columnName != NULL) {
            $users = $users->orderBy($columnName, 'DESC');
        }
        $users = $users->get();

        if (count($users) == 0) {
            return NULL;
        }

        return $users;
    }

    public function dashboardDetails()
    {
        $dashboard = array();

        $select = "select phc_name, count(_id) as ashacount 
                   from household 
                   
                   group by phc_name";
//        $select = "select phc_name, count(_id) as ashacount 
//                   from cvd_riskasses 
//                   where enc_type='SH_CVD_ASHA_SCREENING_1'
//                   group by phc_name";
        $barchartdetails = DB::select(DB::raw($select), $this->where);

        $dashboard["barchart2"] = $barchartdetails;

        //Asha Screening
        $select = "select phc_name, count(hh_id) as ashacount 
                   from cvd_riskasses
                   where enc_type='SH_CVD_ASHA_SCREENING_1'
                   group by phc_name";
        $barchartdetails = DB::select(DB::raw($select), $this->where);

        $dashboard["barchart1"] = $barchartdetails;

        $select2 = "select count(_id) gender_count,gender,phc_name
                    from cvd_riskasses 
                    where enc_type='SH_CVD_ASHA_SCREENING_1'
                    group by phc_name,gender";
        $gendertdetails = DB::select(DB::raw($select2), $this->where);
        $dashboard["gender"] = $gendertdetails;

        $select3 = "select *
                    from
                    (select count(_id) as hbp from cvd_riskasses where hbp =1 and enc_type='SH_CVD_ASHA_SCREENING_1') as hbp,
                    (select count(_id) as diag from cvd_riskasses where diag =1 and enc_type='SH_CVD_ASHA_SCREENING_1') as diag,
                    (select count(_id) as cancer from cvd_riskasses where (mth_cn =1 or brts_cn=1 or cvr_cn = 1) and enc_type='SH_CVD_ASHA_SCREENING_1') as cancer,
                    (select count(_id) as COPD from cvd_riskasses where  copd_dis = 1 and enc_type='SH_CVD_ASHA_SCREENING_1') as COPD,
                    (select count(_id) as cvd from cvd_riskasses where  high_risk_calc = 2 and enc_type='SH_CVD_ASHA_SCREENING_1') as cvd";
        $piedetails = DB::select(DB::raw($select3), $this->where);
        $dashboard["piechart"] = $piedetails;

//        echo "<pre>"; print_r($dashboard);exit;
        if (count($dashboard) == 0) {
            return NULL;
        }

        return $dashboard;
    }

    public function dashboardCVD()
    {
        $dashboard = array();

        $hbp = "select count(_id) as hbp, phc_name from cvd_riskasses where hbp =1 and enc_type='SH_CVD_ASHA_SCREENING_1' group by phc_name";
        $hbpdetails = DB::select(DB::raw($hbp), $this->where);
        $dashboard["hbp"] = $hbpdetails;

        $diag = "select count(_id) as diag, phc_name from cvd_riskasses where diag =1 and enc_type='SH_CVD_ASHA_SCREENING_1' group by phc_name";
        $diagdetails = DB::select(DB::raw($diag), $this->where);
        $dashboard["diag"] = $diagdetails;

        $cancer = "select count(_id) as cancer, phc_name from cvd_riskasses where (mth_cn =1 or brts_cn=1 or cvr_cn = 1) and enc_type='SH_CVD_ASHA_SCREENING_1' group by phc_name";
        $cancerdetails = DB::select(DB::raw($cancer), $this->where);
        $dashboard["cancer"] = $cancerdetails;

        $copd = "select count(_id) as COPD, phc_name from cvd_riskasses where  copd_dis = 1 and enc_type='SH_CVD_ASHA_SCREENING_1' group by phc_name";
        $copddetails = DB::select(DB::raw($copd), $this->where);
        $dashboard["copd"] = $copddetails;

        $cvd = "select count(_id) as cvd, phc_name from cvd_riskasses where  high_risk_calc = 2 and enc_type='SH_CVD_ASHA_SCREENING_1' group by phc_name";
        $cvdddetails = DB::select(DB::raw($cvd), $this->where);
        $dashboard["cvd"] = $cvdddetails;

        $phc_name = "select  distinct phc_name 
                    from cvd_riskasses
                    where (hbp =1 or diag =1 or  mth_cn =1 or brts_cn=1 or cvr_cn = 1 or  copd_dis = 1 or high_risk_calc = 2) and enc_type='SH_CVD_ASHA_SCREENING_1'";
        $phc_namedetails = DB::select(DB::raw($phc_name), $this->where);
        $dashboard["phc_names"] = $phc_namedetails;

        //Ref doctor
        $refdoc = "select count(_id) as refdoc from cvd_riskasses where  ref_doc = 1 and enc_type='SH_CVD_ASHA_SCREENING_1'";
        $refdocdetails = DB::select(DB::raw($refdoc), $this->where);
        $dashboard["refdoc"] = $refdocdetails;

        //To bring the doctor follow ups , asha follow ups , any disese patient count
        $query = 'select * from
                (select count(_id) as diseases_count
                from cvd_riskasses
                where (hbp =1 or diag =1 or  mth_cn =1 or brts_cn=1 or cvr_cn = 1 or  copd_dis = 1 or high_risk_calc = 2) and enc_type="SH_CVD_ASHA_SCREENING_1") diseases_count,
                (select count(_id) as docotor_count
                from cvd_riskasses
                where enc_type like "SH_CVD_DOCTOR_%") docotor_count,
                (select count(_id) as followup_count
                from cvd_riskasses
                where enc_type like "SH_CVD_ASHA_FOLLOWUP_%") followup_count';
        $count_details = DB::select(DB::raw($query), $this->where);
        $dashboard["count_details"] = $count_details;

        if (count($dashboard) == 0) {
            return NULL;
        }

        return $dashboard;
    }

    public function getHouseholdPHC()
    {
        $select = "select distinct phc_name
                   from household";
        $householdphc = DB::select(DB::raw($select), $this->where);

        if (count($householdphc) == 0) {
            return NULL;
        }

        return $householdphc;
    }

    public function getHouseholdAsha()
    {
        $select = "select distinct asha_assigned
                   from household";
        $householdAsha = DB::select(DB::raw($select), $this->where);
        if (count($householdAsha) == 0) {
            return NULL;
        }
        return $householdAsha;
    }

    public function getHouseholdPHCVillage()
    {
        $select = "select distinct village_name
                   from household
                   where phc_name = ?
                ";
        $householdphc = DB::select(DB::raw($select), $this->where);

        if (count($householdphc) == 0) {
            return NULL;
        }

        return $householdphc;
    }

    public function analyticQuery($type, $filters)
    {

        $where = "";
        if ($type == "default") {
            $where = "where 1 and enc_type='SH_CVD_ASHA_SCREENING_1'";
        }
        if ($type == "doctor") {
            $where = "where 1 and (enc_type like 'SH_CVD_ASHA_FOLLOWUP_%' or enc_type like 'SH_CVD_DOCTOR_%')";
        }
        if ($type == "hbp") {
            $where = "where hbp =1 and enc_type='SH_CVD_ASHA_SCREENING_1'";
        }
        if ($type == "diag") {
            $where = "where diag =1 and enc_type='SH_CVD_ASHA_SCREENING_1'";
        }
        if ($type == "cancer") {
            $where = "where (mth_cn =1 or brts_cn=1 or cvr_cn = 1) and enc_type='SH_CVD_ASHA_SCREENING_1' ";
        }
        if ($type == "copd") {
            $where = "where copd_dis = 1 and enc_type='SH_CVD_ASHA_SCREENING_1'";
        }
        if ($type == "cvd") {
            $where = "where high_risk_calc = 2 and enc_type='SH_CVD_ASHA_SCREENING_1' ";
        }

        //Applying the filters
        if (count($filters) > 0) {
            foreach ($filters as $key => $value) {

                if ($key != "startdate" && $key != "enddate") {
                    $where .= " and " . $key . "='" . $value . "'";
                } else if ($key == "startdate") {
                    $where .= "and created_date >='" . $value . "'";
                } else if ($key == "enddate") {
                    $where .= " and created_date <='" . $value . "'";
                }
            }
        }

        $select = "select  DATE_FORMAT(created_date, '%Y-%m-%d') as date,count(_id) as value
                    from cvd_riskasses " . $where . " 
                    group by created_date
                    order by created_date";
        $analyticData = DB::select(DB::raw($select), $this->where);

        if (count($analyticData) == 0) {
            return NULL;
        }
        return $analyticData;
    }

    public function getAnalyticsPHC()
    {
        $where = "";
        if (count($this->where) > 0) {
            $where = " where 1=1 and ";
            foreach ($this->where as $con) {
                $where .= $con[0] . " " . $con[1] . "'" . $con[2] . "'";
            }
        }
        $select = "select distinct phc_name
                   from cvd_riskasses $where";
        $analyticsphc = DB::select(DB::raw($select));

        if (count($analyticsphc) == 0) {
            return NULL;
        }
        return $analyticsphc;
    }

    public function getCsdbAsha()
    {
        $select = "select distinct asha_assigned
                   from cvd_riskasses order by asha_assigned ASC ";
        $analyticsphc = DB::select(DB::raw($select), $this->where);

        if (count($analyticsphc) == 0) {
            return NULL;
        }
        return $analyticsphc;
    }

    public function getCsdbEncType()
    {
        $select = "select distinct enc_type
                   from cvd_riskasses order by enc_type ASC ";
        $analyticsphc = DB::select(DB::raw($select), $this->where);

        if (count($analyticsphc) == 0) {
            return NULL;
        }
        return $analyticsphc;
    }

    public function getAnalyticsPHCVillage()
    {
        $select = "select distinct vill_name as village_name
                   from cvd_riskasses
                   where phc_name = ?
                ";
        $analyticsPHCVillage = DB::select(DB::raw($select), $this->where);

        if (count($analyticsPHCVillage) == 0) {
            return NULL;
        }

        return $analyticsPHCVillage;
    }

    public function getAshaList()
    {
        $select = "select distinct asha_assigned
                   from cvd_riskasses
                   where asha_assigned<>'null' order by asha_assigned ASC ";
        $analyticsphc = DB::select(DB::raw($select), $this->where);

        if (count($analyticsphc) == 0) {
            return NULL;
        }
        return $analyticsphc;
    }

    public function reportsList($filters)
    {
        $where = "where 1 ";

        //Applying the filters
        if (count($filters) > 0) {
            foreach ($filters as $key => $value) {

                if ($key != "startdate" && $key != "enddate") {
                    $where .= " and " . $key . "='" . $value . "'";
                } else if ($key == "startdate") {
                    $where .= "and created_date >='" . $value . "'";
                } else if ($key == "enddate") {
                    $where .= " and created_date <='" . $value . "'";
                }
            }
        }

        $select = "select phc_name, count(_id) as ashacount ,asha_assigned,
                    count(case when high_risk_calc = 2 and enc_type='SH_CVD_ASHA_SCREENING_1' then high_risk_calc end) as high_risk_count,
                    count(case when hbp = 1 and enc_type='SH_CVD_ASHA_SCREENING_1' then hbp end) as hbp,
                    count(case when diag = 1 and enc_type='SH_CVD_ASHA_SCREENING_1' then diag end) as diag,
                    count(case when (mth_cn =1 or brts_cn=1 or cvr_cn = 1) and enc_type='SH_CVD_ASHA_SCREENING_1' then mth_cn end) as cancer,
                    count(case when copd_dis = 1 and enc_type='SH_CVD_ASHA_SCREENING_1' then copd_dis end) as COPD,
                    count(case when high_risk_calc = 2 and enc_type='SH_CVD_ASHA_SCREENING_1' then high_risk_calc end) as high_risk_calc
                    from cvd_riskasses " . $where . " 
                    group by phc_name ,asha_assigned
                    order by asha_assigned ASC";
        $analyticData = DB::select(DB::raw($select), $this->where);

        if (count($analyticData) == 0) {
            return NULL;
        }
        return $analyticData;
    }

    /**
     * To Bring the patient min screening type and max screening type
     * @return type
     */
    public function patientScreening($filters)
    {
        $where = " and  1 ";

        //Applying the filters
        if (count($filters) > 0) {
            foreach ($filters as $key => $value) {

                if ($key != "startdate" && $key != "enddate") {
                    $where .= " and " . $key . "='" . $value . "'";
                } else if ($key == "startdate") {
                    $where .= "and created_date >='" . $value . "'";
                } else if ($key == "enddate") {
                    $where .= " and created_date <='" . $value . "'";
                }
            }
        }

        $select = "select _id,patient_id,first_name,enc_type,current_encounter
                   from cvd_riskasses as cvr
                   where (_id =(select min(_id) from cvd_riskasses as min_cvd where min_cvd.patient_id= cvr.patient_id)
                    or _id =(select max(_id) from cvd_riskasses as min_cvd where min_cvd.patient_id= cvr.patient_id))
                    " . $where . " 
                    order by patient_id asc";
        $paitentData = DB::select(DB::raw($select), $this->where);

        if (count($paitentData) == 0) {
            return NULL;
        }
        return $paitentData;
    }

    public function getAshaDetails()
    {
        $select = "Select u.user_id,u.username,pn.given_name,encounter_datetime,
					TIMESTAMPDIFF(DAY,ifnull(encounter_datetime,now()),now()) days,
					TIMESTAMPDIFF(HOUR,ifnull(encounter_datetime,now()),now()) mod 24 hours,
					TIMESTAMPDIFF(MINUTE,ifnull(encounter_datetime,now()),now()) mod 60 minutes
					from users u
					join person_name pn on u.person_id = pn.person_id
					left join (Select max(encounter_datetime) encounter_datetime,creator from encounter
					group by creator order by creator) a on u.user_id = a.creator order by encounter_datetime desc";
        $ashData = DB::select(DB::raw($select), $this->where);

        if (count($ashData) == 0) {
            return NULL;
        }
        return $ashData;
    }

}
