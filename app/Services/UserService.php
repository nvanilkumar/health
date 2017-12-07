<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\UsersModel;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Helpers\DateHelper;
use Validator;
use App\Helpers\CustomHelper;

class UserService
{

    protected $request;
    protected $usersModel;
    protected $auth;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->usersModel = new UsersModel();
    }

    /**
     * To create the user record
     */
    public function createUser()
    {
        if ($this->createUserValidator()->fails()) {
            return redirect()->back()
                            ->withErrors($this->createUserValidator())
                            ->withInput();
        }
        //Begin the db transaction
        $this->usersModel->dbTransactionBegin();

        //insert the record
        $password = Hash::make($this->request->input("password"));
        $this->usersModel->setTableName("users");
        $insertArray = [
            "first_name" => $this->request->input("first_name"),
            "last_name" => $this->request->input("last_name"),
            "username" => $this->request->input("username"),
            "password" => $password,
            "email" => $this->request->input("email"),
            "address" => $this->request->input("address"),
            "country" => $this->request->input("country"),
            "pincode" => $this->request->input("pincode"),
            "mobileno" => $this->request->input("mobileno"),
            "updated_by" => $this->request->session()->get('user_id'),
            "created_by" => $this->request->session()->get('user_id'),
            "status" => "active"
        ];

        $this->usersModel->setInsertUpdateData($insertArray);
        $userId = $this->usersModel->insertData();

        //bring the role id
        $roleName = $this->request->input("role_type");
        $roleId = $this->usersModel->getRoleId($roleName);
        if (count($roleId) == 0) {
            $this->usersModel->dbTransactionRollback();
            return FALSE;
        }

        //inert the user role data
        $this->usersModel->setTableName("role_users");
        $roleInsertArray = [
            "role_id" => $roleId,
            "user_id" => $userId
        ];
        $this->usersModel->setInsertUpdateData($roleInsertArray);
        $roleUserId = $this->usersModel->insertData();

        $this->usersModel->dbTransactionCommit();


        return $userId;
    }

    /**
     * To validate the login related details and 
     * send the response message
     * @return type
     */
    public function loginCheck()
    {

        $responseMessage = [];
        $username = $this->request->input("username");
        $password = $this->request->input("password");

//         \DB::enableQueryLog();
        $where = [];

        $where[] = ["email", "=", $username];
        $where[] = ["password", "=", md5($password)];

        $this->usersModel->setWhere($where);
        $users = $this->usersModel->loginCheck();
//        $query = \DB::getQueryLog();
// $query = end($query);
// var_dump($query);
        if (count($users) > 0) {
            Session::put('user_id', $users[0]->id);
            Session::put('user_name', $users[0]->first_name . " " . $users[0]->last_name);
            Session::put('user_role', $users[0]->role_name);
            $responseMessage["response"]['status'] = true;
            $responseMessage["response"]['message'] = "Successfully login";
            $responseMessage["response"]["user_id"] = $users[0]->id;
            return $responseMessage;
        }



        $responseMessage["response"]['status'] = false;
        $responseMessage["response"]['message'] = "Invalid Login details";

        return $responseMessage;
    }

    /**
     * To get the user details depends upon the where condition
     * @return type
     */
    public function getHousehold()
    {
        $setWhere = FALSE;
        $phcselect = $this->request->input("phcselect");
        if ($phcselect && ($phcselect != "select option")) {
            $where = [];
            $where[] = ["phc_name", "=", $phcselect];
            $setWhere = TRUE;
        }

        $villageselect = $this->request->input("villageselect");
        if ($villageselect && ($villageselect != "select option")) {

            $where[] = ["village_name", "=", $villageselect];
        }

        $startdate = $this->request->input("startdate");
        if ($startdate) {
            $startdate = date("Y-m-d H:i:s", strtotime($startdate));
            $where[] = ["date", ">=", $startdate];
        }

        $enddate = $this->request->input("enddate");
        if ($enddate) {
            $enddate = date("Y-m-d H:i:s", strtotime($enddate));
            $where[] = ["date", "<=", $enddate];
        }

        $this->usersModel->setTableName("household");

        if ($setWhere) {
            $this->usersModel->setWhere($where);
        }
//  \DB::enableQueryLog();
        $households = $this->usersModel->getData();

        $households = json_decode(json_encode($households), true);

//                $query = \DB::getQueryLog();
// $query = end($query);
// var_dump($query);exit;
//         echo "<pre>";
//         print_r($households);exit;
        return $households;
    }

    public function getHouseholdPHC()
    {
        $this->usersModel->resetVariable();
        $householdphc = $this->usersModel->getHouseholdPHC();

        return $householdphc;
    }

    public function getHouseholdPHCVillage()
    {
        $phcname = $this->request->input("phcname");
        if (strlen($phcname) == 0) {
            echo "invalid data";
            return "";
        }
        $where = array($phcname);
        $this->usersModel->setWhere($where);
        $householdphc = $this->usersModel->getHouseholdPHCVillage();
        $householdphc = json_decode(json_encode($householdphc), true);
//        print_r($householdphc);exit;
        return $householdphc;
    }

    public function getPatients()
    {
        $setWhere = FALSE;
        $phcselect = $this->request->input("phcselect");
        if ($phcselect && ($phcselect != "select option")) {
            $where = [];
            $where[] = ["phc_name", "=", $phcselect];
            $setWhere = TRUE;
        }

        $villageselect = $this->request->input("villageselect");
        if ($villageselect && ($villageselect != "select option")) {

            $where[] = ["village_name", "=", $villageselect];
        }

        $startdate = $this->request->input("startdate");
        if ($startdate) {
            $startdate = date("Y-m-d H:i:s", strtotime($startdate));
            $where[] = ["date", ">=", $startdate];
        }

        $enddate = $this->request->input("enddate");
        if ($enddate) {
            $enddate = date("Y-m-d H:i:s", strtotime($enddate));
            $where[] = ["date", "<=", $enddate];
        }

        $this->usersModel->setTableName("cvd_riskasses");

        if ($setWhere) {
            $this->usersModel->setWhere($where);
        }
//  \DB::enableQueryLog();
        $paitents = $this->usersModel->getData();

        $paitents = json_decode(json_encode($paitents), true);

//                $query = \DB::getQueryLog();
// $query = end($query);
// var_dump($query);exit;
//         echo "<pre>";
//         print_r($households);exit;
        return $paitents;
    }

    public function getAnalytics($type)
    {
        $filters = array();
        $phcselect = $this->request->input("phcselect");
        if ($phcselect && ($phcselect != "select option")) {
            $filters["phc_name"] =   $phcselect;
        }
        $asha_assigned = $this->request->input("asha_assigned");
        if ($asha_assigned && ($asha_assigned != "select option")) {
            $filters["asha_assigned"] =   $asha_assigned;
        }

        $villageselect = $this->request->input("villageselect");
        if ($villageselect && ($villageselect != "select option")) {
            $filters["vill_name"] = $villageselect;
        }

        $startdate = $this->request->input("startdate");
        if ($startdate) {
            $startdate = date("Y-m-d H:i:s", strtotime($startdate));
            $filters["startdate"] =$startdate;
        }

        $enddate = $this->request->input("enddate");
        if ($enddate) {
            $enddate = date("Y-m-d H:i:s", strtotime($enddate));
            $filters["enddate"] =  $enddate;
        }
        $analytics = $this->usersModel->analyticQuery($type, $filters);
        $analytics = json_decode(json_encode($analytics), true);
        return $analytics;
    }

    public function getAnalyticsPHC()
    {
        $this->usersModel->resetVariable();
        $householdphc = $this->usersModel->getAnalyticsPHC();
        return $householdphc;
    }
    public function getAnalyticsPHCVillage()
    {
        $phcname = $this->request->input("phcname");
        if (strlen($phcname) == 0) {
            echo "invalid data";
            return "";
        }
        $where = array($phcname);
        $this->usersModel->setWhere($where);
        $analyticsPHCVillage = $this->usersModel->getAnalyticsPHCVillage();
        $analyticsPHCVillage = json_decode(json_encode($analyticsPHCVillage), true);
 
        return $analyticsPHCVillage;
 
    }
    
    public function getreportsList()
    {
         $reportsList = $this->usersModel->reportsList("");
       
         $reportsList = json_decode(json_encode($reportsList), true);

        return $reportsList;
    }

    /**
     * To change the user password
     * @return type
     */
    public function changePassword()
    {
        if ($this->passwordChangeValidator()->fails()) {
            $errors["status"] = false;
            $errors["message"] = $this->passwordChangeValidator()->errors()->all();
            return $errors;
        }
        //$responseMessage = array();
        $userId = $this->request->session()->get('user_id');
        $where = [["users.user_id", "=", $userId]];
        $this->usersModel->setWhere($where);
        $user = $this->usersModel->getUsers();

        if ($user == null) {
            return false;
        }

        $oldPassword = $this->request->input("old_password");
        $oldHashedPassword = $user[0]->password;
        $status = Hash::check($oldPassword, $oldHashedPassword);
        if ($status) {
            //change to new password
            $password = Hash::make($this->request->input("new_password"));
            $updateArray = [
                "password" => $password
            ];
            $whereArray = [
                ["user_id", '=', $userId]
            ];
            $this->usersModel->setTableName("users");
            $this->usersModel->setInsertUpdateData($updateArray);
            $this->usersModel->setWhere($whereArray);
            $this->usersModel->updateData();
        } else {
            $errors["status"] = false;
            $errors["message"] = ["Invalid Password"];
            return $errors;
        }
        return true;
    }

    /**
     * Password update related validation Rules
     * @return type
     */
    public function passwordChangeValidator()
    {
        //echo "%%%%"; exit;
        return Validator::make($this->request->all(), [
                    'old_password' => 'required||string',
                    'new_password' => 'required||string',
                    'confirm_password' => 'required|string',
        ]);
    }

    /**
     * To update the user password to new value
     */
    public function userPasswordUpdate()
    {
        $password = Hash::make($this->request->input("new_password"));
        $updateArray = [
            "password" => $password
        ];
        $whereArray = [
            ["user_id", '=', $this->request->input("user_id")]
        ];
        $this->usersModel->setTableName("users");
        $this->usersModel->setInsertUpdateData($updateArray);
        $this->usersModel->setWhere($whereArray);
        $this->usersModel->updateData();
    }

    /**
     * Create user related validation Rules
     * @return type
     */
    public function createUserValidator()
    {
        return Validator::make($this->request->all(), [
                    'first_name' => 'required||string',
                    'last_name' => 'required||string',
                    'email' => 'required|email|string',
                    'password' => 'required',
                    'username' => 'required||string',
        ]);
    }

    /**
     * To get the user details depends upon the where condition
     * @return type
     */
    public function getUserDetails()
    {
        $where = [];
        $this->usersModel->setTableName("users");
        $username = $this->request->input("username");
        if ($username) {
            $where[] = ["username", "=", $username];
        }

        $userIdEqual = $this->request->input("user_id_equal");
        if ($userIdEqual) {
            $where[] = ["user_id", "=", $userIdEqual];
        }

        $userIdNotEqual = $this->request->input("user_id_not_equal");
        if ($userIdNotEqual) {
            $where[] = ["user_id", "!=", $userIdNotEqual];
        }


        $this->usersModel->setWhere($where);
        $users = $this->usersModel->getData();

        return $users;
    }

    /**
     * To Update the user related details
     */
    public function updateUser()
    {
        //validations
        if ($this->updateUserValidator()->fails()) {
            return redirect()->back()
                            ->withErrors($this->updateUserValidator())
                            ->withInput();
        }

        //update logic
        $updateArray = [
            "first_name" => $this->request->input("first_name"),
            "last_name" => $this->request->input("last_name"),
            "username" => $this->request->input("username"),
            "email" => $this->request->input("email"),
            "address" => $this->request->input("address"),
            "country" => $this->request->input("country"),
            "pincode" => $this->request->input("pincode"),
            "mobileno" => $this->request->input("mobileno"),
            "updated_by" => $this->request->session()->get('user_id'),
        ];


        if (strlen($this->request->input("password")) > 0) {
            $updateArray["password"] = Hash::make($this->request->input("password"));
        }


        $whereArray = [
            ["user_id", '=', $this->request->input("user_id")]
        ];
        $this->usersModel->setTableName("users");
        $this->usersModel->setInsertUpdateData($updateArray);
        $this->usersModel->setWhere($whereArray);
        $this->usersModel->updateData();
    }

    /**
     * Create user related validation Rules
     * @return type
     */
    public function updateUserValidator()
    {
        return Validator::make($this->request->all(), [
                    'first_name' => 'required||string',
                    'last_name' => 'required||string',
                    'email' => 'required|email|string',
                    'username' => 'required||string',
        ]);
    }

    /**
     * To get the user list depends upon 
     * the where condition based on there role
     * @return type
     */
    public function getUserList()
    {
        $where = [];
        $this->usersModel->setTableName("users");

        $role_name = $this->request->input("role_name");
        if ($role_name) {
            $where[] = ["roles.role_name", "=", $role_name];
        }

        $user_id = $this->request->input("user_id");
        if ($user_id) {
            $where[] = ["users.user_id", "=", $user_id];
        }
        $orderBy = "users.user_id";
        $this->usersModel->setWhere($where);
        $users = $this->usersModel->getUsers($orderBy);

        return $users;
    }

    /**
     * To delete the User record  id
     */
    public function deleteUser()
    {
        //validations
        if ($this->deleteUserValidator()->fails()) {
            return redirect()->back()
                            ->withErrors($this->deleteUserValidator())
                            ->withInput();
        }

        //check login user id
        $login_user_id = session('user_id');
        $user_id = $this->request->input("user_id");
        if ($user_id == $login_user_id) {
            return false;
        }

        //delete logic
        $whereArray = [
            "user_id" => $this->request->input("user_id"),
        ];

        //Begin the transaction
        $this->usersModel->dbTransactionBegin();


        $this->usersModel->setTableName("users");
        $this->usersModel->setWhere($whereArray);
        $this->usersModel->deleteData();

        //Remove Below table links as well
        //event_users   group_users   notification_users   role_users
        //survey_users

        $this->usersModel->setTableName("event_users");
        $this->usersModel->setWhere($whereArray);
        $this->usersModel->deleteData();

        $this->usersModel->setTableName("group_users");
        $this->usersModel->setWhere($whereArray);
        $this->usersModel->deleteData();

        $this->usersModel->setTableName("notification_users");
        $this->usersModel->setWhere($whereArray);
        $this->usersModel->deleteData();

        $this->usersModel->setTableName("role_users");
        $this->usersModel->setWhere($whereArray);
        $this->usersModel->deleteData();

        $this->usersModel->setTableName("survey_users");
        $this->usersModel->setWhere($whereArray);
        $this->usersModel->deleteData();

        //commit the transaction
        $this->usersModel->dbTransactionCommit();

        return TRUE;
    }

    /**
     * delete user related validations
     * @return type
     */
    public function deleteUserValidator()
    {
        return Validator::make($this->request->all(), [
                    'user_id' => 'required|integer'
        ]);
    }

    public function assignGroupUsers()
    {
        //validations
        if ($this->assignGroupUsersValidator()->fails()) {

            redirect()->back()
                    ->withErrors($this->assignGroupUsersValidator())
                    ->withInput();
            return false;
        }

        $this->usersModel->setTableName("group_users");
        //update logic
        $groupId = $this->request->input("group_id");
        $userIds = $this->request->input("user_ids");

        //Bring the group related users firs
        $groupService = new GroupService($this->request);
        $groupUsers = $groupService->getGroupUsers();

        //remove dulicate user ids from the given list
        $newUsersList = [];
        if ($userIds != NULL) {
            $newUsersList = CustomHelper::removeDuplicateRecords($userIds, $groupUsers);
        }

        //insert the records
        if (count($newUsersList) > 0) {
            $insertArray = [];
            foreach ($newUsersList as $userId) {
                $insertArray[] = [
                    "group_id" => $groupId,
                    "user_id" => $userId,
                    "created_at" => DateHelper::todayDateTime(),
                    "updated_at" => DateHelper::todayDateTime(),
                ];
            }
            $this->usersModel->setInsertUpdateData($insertArray);
            $this->usersModel->bulkInsert();
        }

        return true;
    }

    /**
     * delete assignGroupUsers related validations
     * @return type
     */
    public function assignGroupUsersValidator()
    {
        return Validator::make($this->request->all(), [
                    'group_id' => 'required|integer'
        ]);
    }

    /**
     * To Bring the dashboard details
     */
    public function dashboardDetails()
    {
        $details = $this->usersModel->dashboardDetails();

        $label = array();
        $data = array();

        $phcdetails = $details["barchart2"];
        foreach ($phcdetails as $list) {
            $label[] = $list->phc_name;
            $data[] = $list->ashacount;
        }
        $details["phclabel"] = $label;
        $details["phcdata"] = $data;

        $label = array();
        $data = array();
        $ashaphcdetails = $details["barchart1"];
        foreach ($ashaphcdetails as $list) {
            $label[] = $list->phc_name;
            $data[] = $list->ashacount;
        }
        $details["ashaphclabel"] = $label;
        $details["ashaphcdata"] = $data;

        //gender details
        $genderDetails = $details['gender'];
        foreach ($genderDetails as $glist) {
            if ($glist->gender == "F") {
                $details["femalecount"] = $glist->gender_count;
            } else {
                $details["malecount"] = $glist->gender_count;
            }
        }

        return $details;
    }

    public function createHousehold()
    {
        $this->usersModel->setTableName("household");
        $hh_id = ($this->request->input("hh_id") != "") ? $this->request->input("hh_id") : "";
        $door_no = ($this->request->input("door_no") != "") ? $this->request->input("door_no") : "";
        $locality_id = ($this->request->input("locality_id") != "") ? $this->request->input("locality_id") : 0;
        $village_name = ($this->request->input("village_name") != "") ? $this->request->input("village_name") : "";
        $phc_name = ($this->request->input("phc_name") != "") ? $this->request->input("phc_name") : "";
        $total_hh_size = ($this->request->input("total_hh_size") != "") ? $this->request->input("total_hh_size") : 0;
        $total_hh_eligible = ($this->request->input("total_hh_eligible") != "") ? $this->request->input("total_hh_eligible") : 0;
        $hh_head_fname = ($this->request->input("hh_head_fname") != "") ? $this->request->input("hh_head_fname") : "";
        $hh_head_lname = ($this->request->input("hh_head_lname") != "") ? $this->request->input("hh_head_lname") : "";

        $type_of_house = ($this->request->input("type_of_house") != "") ? $this->request->input("type_of_house") : "";
        $status_of_toilets = ($this->request->input("status_of_toilets") != "") ? $this->request->input("status_of_toilets") : "";
        $drng_water_arrg = ($this->request->input("drng_water_arrg") != "") ? $this->request->input("drng_water_arrg") : "";
        $eleciricity_arrg = ($this->request->input("eleciricity_arrg") != "") ? $this->request->input("eleciricity_arrg") : "";
        $motor_vehcile = ($this->request->input("motor_vehcile") != "") ? $this->request->input("motor_vehcile") : "";
        $type_of_fuel_cook_food = ($this->request->input("type_of_fuel_cook_food") != "") ? $this->request->input("type_of_fuel_cook_food") : "";
        $contact_info = ($this->request->input("contact_info") != "") ? $this->request->input("contact_info") : "";
        $patient_id_counter = ($this->request->input("patient_id_counter") != "") ? $this->request->input("patient_id_counter") : 0;

        $insertArray = [
            "hh_id" => $hh_id,
            "door_no" => $door_no,
            "locality_id" => $locality_id,
            "village_name" => $village_name,
            "phc_name" => $phc_name,
            "total_hh_size" => $total_hh_size,
            "total_hh_eligible" => $total_hh_eligible,
            "hh_head_fname" => $hh_head_fname,
            "hh_head_lname" => $hh_head_lname,
            "date" => DateHelper::todayDateTime(),
            "type_of_house" => $type_of_house,
            "status_of_toilets" => $status_of_toilets,
            "drng_water_arrg" => $drng_water_arrg,
            "eleciricity_arrg" => $eleciricity_arrg,
            "motor_vehcile" => $motor_vehcile,
            "type_of_fuel_cook_food" => $type_of_fuel_cook_food,
            "contact_info" => $contact_info,
            "patient_id_counter" => $patient_id_counter,
        ];

        $this->usersModel->setInsertUpdateData($insertArray);
        $userId = $this->usersModel->insertData();

        var_dump($userId);
        exit;
    }

}
