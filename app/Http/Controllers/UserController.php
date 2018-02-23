<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Excel;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{

    public function __construct(Request $request, UserService $userService)
    {
        $this->request = $request;
        $this->userService = $userService;
    }

    public function show()
    {
        return view('login.login', []);
    }

    public function dashboard()
    {
//        echo 333;exit;
        $details = $this->userService->dashboardDetails();
        return view('users.chart', ["title" => "Dashboard",
            "details" => $details
        ]);
    }

    public function reportsView()
    {
        $details = $this->userService->getreportsList();
        $analyticsphc = $this->userService->getAnalyticsPHC();
        return view('users.reports', ["title" => "Reports",
            "details" => $details,
            "householdphc" => $analyticsphc,
            'postData' => Input::all()
        ]);
    }

    public function householdView()
    {

        $details = $this->userService->getHousehold();
        $houseHoldPhc = $this->userService->getHouseholdPHC();
        $householdAsha = $this->userService->getHouseholdAsha();
        return view('users.household', ["title" => "Household",
            "details" => $details,
            "householdphc" => $houseHoldPhc,
            "householdasha" => $householdAsha,
            'postData' => Input::all()
        ]);
    }

    public function getPatientsView()
    {

        $details = $this->userService->getPatients();
        $houseHoldPhc = $this->userService->getAnalyticsPHC();
        $encType = $this->userService->getCsdbEncType();
        return view('users.patients', ["title" => "Patients ",
            "details" => $details,
            "householdphc" => $houseHoldPhc,
            "encType" => $encType,
            'postData' => Input::all()
        ]);
    }

    public function analyticsView($type = NULL)
    {
        $this->request->request->add(['type' => $type]);
        $details = $this->userService->getAnalytics($type);
//        echo "<pre>";
//        print_r($details);exit;
        $analyticsphc = $this->userService->getAnalyticsPHC();
        $csdbasha = $this->userService->getCsdbAsha();

        return view('users.analytics', ["title" => "Analytics",
            "details" => $details,
            "analyticsphc" => $analyticsphc,
            "csdbasha" => $csdbasha,
            'postData' => Input::all()
        ]);
    }

    public function diseaseView()
    {

        $details = $this->userService->getDisease();
//        echo "<pre>";
//        print_r($details);exit;
        $analyticsphc = $this->userService->getAnalyticsPHC();
        $csdbasha = $this->userService->getCsdbAsha();

        return view('users.disease', ["title" => "Analytics",
            "details" => $details,
            "analyticsphc" => $analyticsphc,
            "csdbasha" => $csdbasha,
            'postData' => Input::all()
        ]);
    }

    public function analyticsVillage()
    {
        $status = $this->userService->getAnalyticsPHCVillage();
        return response()->json($status, 200);
    }

    public function patientPHC()
    {
        $status = $this->userService->getAnalyticsPHC();
        return response()->json($status, 200);
    }

    public function householdVillage()
    {
        $status = $this->userService->getHouseholdPHCVillage();
        return response()->json($status, 200);
    }

    public function createHousehold()
    {
        $data = $this->userService->createHousehold();
        return response()->json(['household_id' => $data], 200);
    }

    public function getHousehold()
    {

        $data = $this->userService->getHousehold();
        return response()->json(['patients' => $data], 200);
    }

    public function getHouseholdCount()
    {

        $data = $this->userService->getHousehold();
        $listcout = count($data);
        return response()->json(['patientsCount ' => $listcout], 200);
    }

    public function downloadExcel()
    {
        $data = $this->userService->downloadData();
//        echo "<pre>";
//print_r($data);exit;
        $type = "xlsx";
        return Excel::create('Regports', function($excel) use ($data) {
                    $excel->sheet('Patients', function($sheet) use ($data) {
                        $sheet->fromArray($data);
                    });
                })->download($type);
    }

    public function loginCheck()
    {
        $status = $this->userService->loginCheck();
        return response()->json($status, 200);
    }

    public function logout()
    {
        $this->request->session()->forget('user_id');
        $this->request->session()->forget('user_name');
        $this->request->session()->forget('user_role');

        $this->request->session()->flush();
        return redirect('/staff/login');
    }

    public function createUserView()
    {
        return view('users.createUser', ["title" => "Mtc Create User", "user" => "", "pageHeading" => "Add New User"]);
    }

    public function updateUserView($user_id)
    {

        $this->request->request->add(['user_id_equal' => $user_id]);
        $userDetails = $this->userService->getUserDetails();
        if ($userDetails == NULL) {
            return redirect('/dashboard');
        }
        $user = (array) $userDetails[0];

        return view('users.createUser', ["title" => "Mtc Create User",
            "user" => $user,
            "pageHeading" => "Edit User"
        ]);
    }

    public function createUser()
    {

        $this->userService->createUser();
        return redirect('users/list/' . $this->request->input("role_type"));
    }

    public function updateUser()
    {
        $this->userService->updateUser();
        return redirect('users/update/' . $this->request->input("user_id"))
                        ->with('status', 'User updated successfully');
        ;
    }

    public function changePassword()
    {
        return view('users.changePassword', ["title" => "Mtc Change Password", "pageHeading" => "Change Password"]);
    }

    public function userUpdatePassword()
    {
        $status = $this->userService->changePassword();
        $errors = [];
        if ($status['status'] == false) {
            $errors = $status['message'];
        }
        if (is_bool($status) === true) {

            Session::flash('status', 'Password Updated successfully.');
        }
        return view('users.changePassword', ["title" => "Mtc Change Password", "pageHeading" => "Change Password",
            "errors" => $errors
        ]);
    }

    public function userNameCheck()
    {
        $details = $this->userService->getUserDetails();
        if ($details === NULL) {
            return "true";
        }
        return "false";
    }

    /**
     * To delete the specified link id
     * @return type
     */
    public function deleteUser($user_id)
    {
        $this->request->request->add(['user_id' => $user_id]);

        //User record not found
        $user = $this->userService->getUserList();
        if (count($user) == 0) {
            return redirect('/dashboard');
        }
        $roleName = $user[0]->role_name;

        $status = $this->userService->deleteUser();
        if ($status) {
            Session::flash('status', 'Success! Record is deleted successfully.');
        }

        return redirect('/users/list/' . $roleName);
    }

    /**
     * To get users list
     * @return type
     */
    public function getUserList($type = NULL)
    {
        echo 8888;
        exit;
        $title = "";
        if ($type == "student") {
            $this->request->request->add(['role_name' => "student"]);
            $title = "All Students";
        } else if ($type == "staff") {
            $this->request->request->add(['role_name' => "staff"]);
            $title = "All Staff";
        } else {
            return redirect('/dashboard');
        }

        $users = $this->userService->getUserList();
        return view('users.uersList', ["title" => $title,
            "usersList" => $users, "type" => $type]);
    }

    public function ashaView()
    {
        $details = $this->userService->ashaDetails();
//                print_r($details);exit;
      
        return view('users.ashas', ["title" => "Asha",
            "details" => $details,
        ]);
    }

}
