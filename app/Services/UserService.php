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
    protected $maxDisease;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->usersModel = new UsersModel();
        $this->maxDisease = 0;
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
        $this->usersModel->setTableName("cvd_users");
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

        $where[] = ["username", "=", $username];
        $where[] = ["password", "=", md5($password)];

        $this->usersModel->setWhere($where);
        $users = $this->usersModel->loginCheck();
//        $query = \DB::getQueryLog();
// $query = end($query);
// var_dump($query);
        if (count($users) > 0) {
            Session::put('user_id', $users[0]->user_id);
            Session::put('user_name', $users[0]->username);
            Session::put('user_role', $users[0]->role_name);
            $responseMessage["response"]['status'] = true;
            $responseMessage["response"]['message'] = "Successfully login";
            $responseMessage["response"]["user_id"] = $users[0]->user_id;
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
        $ashaselect = $this->request->input("ashaselect");
        if ($ashaselect && ($ashaselect != "Choose ANM")) {
            $where = [];
            $where[] = ["asha_assigned", "=", $ashaselect];
            $setWhere = TRUE;
        }

        $phcselect = $this->request->input("phcselect");
        if ($phcselect && ($phcselect != "Choose PHC")) {
            $where = [];
            $where[] = ["phc_name", "=", $phcselect];
            $setWhere = TRUE;
        }

        $villageselect = $this->request->input("villageselect");
        if ($villageselect && ($villageselect != "Choose Village")) {

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
//        echo 888; 
//        var_dump( $this->request->all()) ;exit;
        //pagination
        $startingIndex = 0;
        $pageNo = 1;
        if ($this->request->input("page")) {
            $pageNo = $this->request->input("page");
        }

        $perPage = 1000; //default value
        if ($this->request->input("page_size")) {
            $perPage = $this->request->input("page_size");
        }

        if ($pageNo > 1) {
            $startingIndex = ($pageNo - 1) * $perPage;
        }
        $this->usersModel->setStartingIndex($startingIndex);
        $this->usersModel->setRecords($perPage);
       
        //

        $this->usersModel->setTableName("household");

        if ($setWhere) {
            $this->usersModel->setWhere($where);
        }
        
//  \DB::enableQueryLog();
        $households = $this->usersModel->getOrderByData("_id");

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

    public function getHouseholdAsha()
    {
        $this->usersModel->resetVariable();
        $householdAsha = $this->usersModel->getHouseholdAsha();
        return $householdAsha;
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
        $encselect = $this->request->input("encselect");
        if ($encselect && ($encselect != "Choose ENC Type")) {
            $where = [];
            $where[] = ["enc_type", "=", $encselect];
            $setWhere = TRUE;
        }
        $phcselect = $this->request->input("phcselect");
        if ($phcselect && ($phcselect != "Choose PHC")) {
            $where[] = ["phc_name", "=", $phcselect];
            $setWhere = TRUE;
        }

        $villageselect = $this->request->input("villageselect");
        if ($villageselect && ($villageselect != "Choose Village")) {

            $where[] = ["vill_name", "=", $villageselect];
        }

        $startdate = $this->request->input("startdate");
        if ($startdate) {
            $startdate = date("Y-m-d H:i:s", strtotime($startdate));
            $where[] = ["created_date", ">=", $startdate];
        }

        $enddate = $this->request->input("enddate");
        if ($enddate) {
            $enddate = date("Y-m-d H:i:s", strtotime($enddate));
            $where[] = ["created_date", "<=", $enddate];
        }

        $patient_id = $this->request->input("patient_id");
        if ($patient_id) {

            $where[] = ["patient_id", "=", $patient_id];
            $setWhere = TRUE;
        }
        $hh_id = $this->request->input("hh_id");
        if ($hh_id) {

            $where[] = ["hh_id", "=", $hh_id];
            $setWhere = TRUE;
        }

        $this->usersModel->setTableName("cvd_riskasses");

        if ($setWhere) {
            $this->usersModel->setWhere($where);
        }
//  \DB::enableQueryLog();
        $paitents = $this->usersModel->getOrderByData("_id");

        $paitents = json_decode(json_encode($paitents), true);

//                $query = \DB::getQueryLog();
// $query = end($query);
// var_dump($query);exit;
//         echo "<pre>";
//         print_r($households);exit;
        return $paitents;
    }

    /**
     * To Bring enc type screening first and last screening of the paitent
     * @return type
     */
    public function getPatientScreening()
    {

        $where = [];
        $encselect = $this->request->input("encselect");
        if ($encselect && ($encselect != "Choose ENC Type")) {

            $where["enc_type"] = $encselect;
        }
        $phcselect = $this->request->input("phcselect");
        if ($phcselect && ($phcselect != "Choose PHC")) {
            $where["phc_name"] = $phcselect;
        }

        $villageselect = $this->request->input("villageselect");
        if ($villageselect && ($villageselect != "Choose Village")) {

            $where["vill_name"] = $villageselect;
        }

        $startdate = $this->request->input("startdate");
        if ($startdate) {
            $startdate = date("Y-m-d H:i:s", strtotime($startdate));
            $where["created_date"] = $startdate;
        }

        $enddate = $this->request->input("enddate");
        if ($enddate) {
            $enddate = date("Y-m-d H:i:s", strtotime($enddate));
            $where["created_date"] = $enddate;
        }

        $patient_id = $this->request->input("patient_id");
        if ($patient_id) {

            $where["patient_id"] = $patient_id;
        }


//  \DB::enableQueryLog();
        $paitents = $this->usersModel->patientScreening($where);
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
        $filters = $this->prepareFilter();
        $analytics = $this->usersModel->analyticQuery($type, $filters);
//        echo "<pre>";
//        print_r($analytics);
////        echo max(array_column($analytics, 'value'));
//        exit;
        $this->getDiseaseMaxValue($analytics);
        $analytics = json_decode(json_encode($analytics), true);
        $user_role_type = session('user_role');
        if ($user_role_type == 'stakeholders') {
            $analytics = $this->getStakeUserAnalytics($analytics);
        }
        return $analytics;
    }

    /**
     * To calculate the max value
     * @param type $analytics
     */
    public function getDiseaseMaxValue($analytics)
    {
        if(count($analytics) > 0)
        foreach ($analytics as $k => $v) {
            if ($v->value > $this->maxDisease) {
                $this->maxDisease = $v->value;
            }
        }
    }

    public function getStakeUserAnalytics($analytics)
    {
        $fillterValue = 0;
        if (count($analytics) > 0)
            foreach ($analytics as $key => $value) {
                $temp = $value["value"];
                $analytics[$key]["value"] = $value["value"] + $fillterValue;
                $fillterValue = $fillterValue + $temp;
            }
        return $analytics;
    }

    public function getDisease()
    {
        $allList = array();
        $allList["hbp"] = $this->getAnalytics("hbp");
        $allList["diag"] = $this->getAnalytics("diag");
        $allList["cancer"] = $this->getAnalytics("cancer");
        $allList["copd"] = $this->getAnalytics("copd");
        $allList["cvd"] = $this->getAnalytics("cvd");

        $allList = $this->analyticGraphDataProcess($allList);
        $allList["maxValue"] = $this->maxDisease;
        return $allList;
    }

    public function getAnalyticsPHC()
    {
        $this->usersModel->resetVariable();
        $where = [];
        $encselect = $this->request->input("encselect");
        if ($encselect && ($encselect != "Choose ENC Type")) {

            $where[] = ["enc_type", "=", $encselect];
            $this->usersModel->setWhere($where);
        }

        $householdphc = $this->usersModel->getAnalyticsPHC();
        return $householdphc;
    }

    public function getCsdbAsha()
    {
        $this->usersModel->resetVariable();
        $householdphc = $this->usersModel->getCsdbAsha();
        return $householdphc;
    }

    public function getCsdbEncType()
    {
        $this->usersModel->resetVariable();
        return $this->usersModel->getCsdbEncType();
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
        $filters = array();
        $filters = $this->prepareFilter();
//        print_r($filters);exit;
        $reportsList = $this->usersModel->reportsList($filters);
        $reportsList = json_decode(json_encode($reportsList), true);
        return $reportsList;
    }

    public function downloadData()
    {
        $details = array();
        $type = $this->request->input("type");
        if ($type == "patients") {
            $details = $this->getPatients();
        } else if ($type == "reports") {
            $details = $this->getreportsList();
//            var_dump($details);exit;
        } else if ($type == "household") {
            $details = $this->getHousehold();
        } else if ($type == "patientScreening") {
            $details = $this->getPatientScreening();
        }

        return $details;
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
            $this->usersModel->setTableName("cvd_users");
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
        $this->usersModel->setTableName("cvd_users");
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
        $this->usersModel->setTableName("cvd_users");
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
        $this->usersModel->setTableName("cvd_users");
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
        $this->usersModel->setTableName("cvd_users");

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


        $this->usersModel->setTableName("cvd_users");
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
        $details["cvdgroup"] = $this->usersModel->dashboardCVD();
//        echo "<pre>";
//print_r($details["cvdgroup"]);exit;
        $label = array();
        $data = array();

        $phcdetails = $details["barchart2"];
        foreach ($phcdetails as $list) {
            $label[] = strtoupper($list->phc_name);
            $data[] = $list->ashacount;
        }
        $details["phclabel"] = $label;
        $details["phcdata"] = $data;

        $label = array();
        $data = array();
        $ashaphcdetails = $details["barchart1"];
        foreach ($ashaphcdetails as $list) {
            $label[] = strtoupper($list->phc_name);
            $data[] = $list->ashacount;
        }
        $details["ashaphclabel"] = $label;
        $details["ashaphcdata"] = $data;

        //gender details
        $genderDetails = $details['gender'];
//        echo "<pre>";
//        print_r($genderDetails); 
        foreach ($genderDetails as $glist) {
            $details["genderphc"][] = strtoupper($glist->phc_name);
            if ($glist->gender == "F") {
                $details["femalecount"][strtoupper($glist->phc_name)] = $glist->gender_count;
            } else {
                $details["malecount"][strtoupper($glist->phc_name)] = $glist->gender_count;
            }
        }

        if (count($details["genderphc"]) > 0) {
            $details["genderphc"] = array_unique($details["genderphc"]);
        }
        $details["femalecount"] = $this->keyValueCheck($details["femalecount"], $details["genderphc"]);
        $details["malecount"] = $this->keyValueCheck($details["malecount"], $details["genderphc"]);

        $details["cvdgroup"] = $this->processCVD($details["cvdgroup"]);
//        echo "<pre>";
//        print_r($details);
//     
//        exit;
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
        $asha_assigned = ($this->request->input("asha_assigned") != "") ? $this->request->input("asha_assigned") : 0;

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
            "asha_assigned" => $asha_assigned
        ];

        $this->usersModel->setInsertUpdateData($insertArray);
        $userId = $this->usersModel->insertData();

        return $userId;
    }

    public function prepareFilter()
    {
        $filters = array();
        $phcselect = $this->request->input("phcselect");
        if ($phcselect && ($phcselect != "Choose PHC") && ($phcselect != "select option")) {
            $filters["phc_name"] = $phcselect;
        }
        $asha_assigned = $this->request->input("ashaselect");
        if ($asha_assigned && ($asha_assigned != "Choose ANM")) {
            $filters["asha_assigned"] = $asha_assigned;
        }

        $villageselect = $this->request->input("villageselect");
        if ($villageselect && ($villageselect != "Choose Village") && ($villageselect != "select option")) {
            $filters["vill_name"] = $villageselect;
        }

        $startdate = $this->request->input("startdate");
        if ($startdate) {
            $startdate = date("Y-m-d H:i:s", strtotime($startdate));
            $filters["startdate"] = $startdate;
        }

        $enddate = $this->request->input("enddate");
        if ($enddate) {
            $enddate = date("Y-m-d H:i:s", strtotime($enddate));
            $filters["enddate"] = $enddate;
        }
        return $filters;
    }

    public function keyValueCheck($searchArray, $indexArray)
    {
        $mainArray = array();
        foreach ($indexArray as $basevalue) {
            if (array_key_exists($basevalue, $searchArray)) {
                $mainArray[$basevalue] = $searchArray[$basevalue];
            } else {
                $mainArray[$basevalue] = 0;
            }
        }
        return $mainArray;
    }

    public function processCVD($cvdDetails)
    {
        $resultArray = array();


        foreach ($cvdDetails["phc_names"] as $value) {

            $resultArray["phc_name"][] = strtoupper($value->phc_name);
        }

        foreach ($cvdDetails["cvd"] as $value) {

            $resultArray["cvd"][strtoupper($value->phc_name)] = $value->cvd;
        }

        foreach ($cvdDetails["hbp"] as $value) {

            $resultArray["hbp"][strtoupper($value->phc_name)] = $value->hbp;
        }

        foreach ($cvdDetails["diag"] as $value) {

            $resultArray["diag"][strtoupper($value->phc_name)] = $value->diag;
        }
        foreach ($cvdDetails["cancer"] as $value) {

            $resultArray["cancer"][strtoupper($value->phc_name)] = $value->cancer;
        }

        foreach ($cvdDetails["copd"] as $value) {

            $resultArray["copd"][strtoupper($value->phc_name)] = $value->COPD;
        }
        $resultArray["cvd"] = $this->keyValueCheck($resultArray["cvd"], $resultArray["phc_name"]);
        $resultArray["hbp"] = $this->keyValueCheck($resultArray["hbp"], $resultArray["phc_name"]);
        $resultArray["diag"] = $this->keyValueCheck($resultArray["diag"], $resultArray["phc_name"]);
        $resultArray["cancer"] = $this->keyValueCheck($resultArray["cancer"], $resultArray["phc_name"]);
        $resultArray["copd"] = $this->keyValueCheck($resultArray["copd"], $resultArray["phc_name"]);
        $resultArray["count_details"] = $cvdDetails["count_details"];
        $resultArray["refdoc"] = $cvdDetails["refdoc"];

        return $resultArray;
    }

    public function analyticGraphDataProcess($cvdDetails)
    {
        $resultArray = array();

        if (count($cvdDetails["cvd"]) > 0)
            foreach ($cvdDetails["cvd"] as $value) {
                $resultArray[$value["date"]]["cvd"] = $value["value"];
            }

        if (count($cvdDetails["hbp"]) > 0)
            foreach ($cvdDetails["hbp"] as $value) {
                $resultArray[$value["date"]]["hbp"] = $value["value"];
            }

        if (count($cvdDetails["diag"]) > 0)
            foreach ($cvdDetails["diag"] as $value) {
                $resultArray[$value["date"]]["diag"] = $value["value"];
            }

        if (count($cvdDetails["cancer"]) > 0)
            foreach ($cvdDetails["cancer"] as $value) {
                $resultArray[$value["date"]]["cancer"] = $value["value"];
            }

        if (count($cvdDetails["copd"]) > 0)
            foreach ($cvdDetails["copd"] as $value) {
                $resultArray[$value["date"]]["copd"] = $value["value"];
            }

        //Add all categoires to array list
        $indexArray = array("cvd", "hbp", "diag", "cancer", "copd");
        $labelsArray = array();
        $returnArray = array();
        $returnArray["data"] = array();

        foreach ($resultArray as $key => $value) {
            $returnArray["data"][] = $this->keyValueCheckAddField($resultArray[$key], $indexArray, $key);
            $labelsArray[] = $key;
        }
        $returnArray["labels"] = $labelsArray;
        return $returnArray;
    }

    public function keyValueCheckAddField($searchArray, $indexArray, $label)
    {
        $mainArray = array();
        foreach ($indexArray as $basevalue) {
            if (array_key_exists($basevalue, $searchArray)) {
                $mainArray[$basevalue] = $searchArray[$basevalue];
            } else {
                $mainArray[$basevalue] = 0;
            }
            $mainArray['label'] = $label;
        }
        return $mainArray;
    }

    public function apicheck()
    {

        echo $this->request->header('userid');
        echo $this->request->header("tabimei");
        $userid = $this->request->input("userid");
        $tabimei = $this->request->input("tabimei");

//         \DB::enableQueryLog();
        $where = [];

        $where[] = ["uid", "=", $userid];
        $where[] = ["tabimei", "=", $tabimei];

        $this->usersModel->setWhere($where);
        $users = $this->usersModel->loginCheck();
        if (count($users) > 0) {
            return true;
        }

        return false;
    }

    public function ashaDetails()
    {
        $ashData = $this->usersModel->getAshaDetails();
        return $ashData;
    }

}
