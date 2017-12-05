<?php

namespace App\Models;

use DB;

class UsersModel extends CommonModel
{

    public function loginCheck()
    {
        $users = DB::table('users')
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
        $users = DB::table('users')
                ->select('users.*', 'roles.role_name')
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
        $dashboard=array();
        $select = "select phc_name, count(_id) as ashacount 
                   from cvd_riskasses 
                   where enc_type='SH_CVD_ASHA_SCREENING_1'
                   group by phc_name";
        $barchartdetails = DB::select(DB::raw($select), $this->where);
       
        $dashboard["barchart1"]=$barchartdetails;
        
        //Asha Screening
        $select = "select phc_name, count(_id) as ashacount 
                   from cvd_riskasses 
                   group by phc_name";
        $barchartdetails = DB::select(DB::raw($select), $this->where);
       
        $dashboard["barchart2"]=$barchartdetails;
        
        $select2 = "select count(_id) gender_count,gender
                    from cvd_riskasses 
                    where enc_type='SH_CVD_ASHA_SCREENING_1'
                    group by gender";
        $gendertdetails = DB::select(DB::raw($select2), $this->where);
        $dashboard["gender"]=$gendertdetails;
        
        $select3 = "select *
                    from
                    (select count(_id) as hbp from cvd_riskasses where hbp =1 ) as hbp,
                    (select count(_id) as diag from cvd_riskasses where diag =1 ) as diag,
                    (select count(_id) as cancer from cvd_riskasses where mth_cn =1 or brts_cn=1 or cvr_cn = 1) as cancer,
                    (select count(_id) as COPD from cvd_riskasses where  copd_dis = 1) as COPD,
                    (select count(_id) as cvd from cvd_riskasses where  high_risk_calc = 2) as cvd";
        $piedetails = DB::select(DB::raw($select3), $this->where);
        $dashboard["piechart"]=$piedetails;
        
//        echo "<pre>"; print_r($dashboard);exit;
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

}
