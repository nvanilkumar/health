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
    
    public function analyticQuery($type,$filters)
    {
        $where="";
        if($type =="hbp")
        {
            $where ="where hbp =1 ";
        }
        if($type =="diag")
        {
            $where ="where diag =1 ";
        }
        if($type =="cancer")
        {
            $where ="where mth_cn =1 or brts_cn=1 or cvr_cn = 1 ";
        }
        if($type =="copd")
        {
            $where ="where copd_dis = 1 ";
        }
        if($type =="cvd")
        {
            $where ="where high_risk_calc = 2 ";
        }
        
        //Applying the filters
        if(count($filters) > 0)
        {
//            echo "<pre>";
//            print_r($filters);exit;
            foreach($filters as $key => $value)
            {
                if($key!= "startdate" && $key!= "enddate")
                {
                    $where .= " and ".$key."='".$value."'";
                }else if($key == "startdate"){
                    $where .= "and ".$key.">='".$value."'";
                }else if($key == "enddate"){
                    $where .= " and ".$key."<='".$value."'";
                }
            }    
            
        }    
        
       echo $select = "select created_date,count(_id)
                    from cvd_riskasses ".$where." 
                    group by created_date
                    order by created_date";exit;
        $analyticData = DB::select(DB::raw($select), $this->where);
        
        if (count($analyticData) == 0) {
            return NULL;
        }
        return $analyticData;
       
         
    }  
    
    public function getAnalyticsPHC()
    {
        $select = "select distinct phc_name
                   from cvd_riskasses";
        $analyticsphc = DB::select(DB::raw($select), $this->where);
        
        if (count($analyticsphc) == 0) {
            return NULL;
        }
        return $analyticsphc;
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

}
