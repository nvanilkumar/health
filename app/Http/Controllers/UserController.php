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

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show2()
    {
        return view('login.login', []);
    }

    public function show()
    {

        return view('login.login', []);
    }

    public function charts()
    {
        return view('users.chart', []);
    }

    public function dashboard()
    {
        //echo 333;exit;
        $details = $this->userService->dashboardDetails();
        return view('users.chart', ["title" => "Dashboard",
            "details" => $details
        ]);
    }

    public function reportsView()
    {
        return view('users.reports', ["title" => "Reports"]);
    }

    public function householdView()
    {

        $details = $this->userService->getHousehold();
        $houseHoldPhc = $this->userService->getHouseholdPHC();
        return view('users.household', ["title" => "Household",
            "details" => $details,
            "householdphc" => $houseHoldPhc,
             'postData' => Input::all()
        ]);
    }
    
    public function getPatientsView()
    {

        $details = $this->userService->getPatients();
        $houseHoldPhc = $this->userService->getHouseholdPHC();
        return view('users.patients', ["title" => "Household",
            "details" => $details,
            "householdphc" => $houseHoldPhc,
             'postData' => Input::all()
        ]);
    }
    
    public function analyticsView($type)
    {
        echo $type;exit;
        $details = $this->userService->getAnalytics($type);
        $analyticsphc = $this->userService->getAnalyticsPHC();
        return view('users.analytics', ["title" => "Analytics",
            "details" => $details,
            "analyticsphc" => $analyticsphc,
             'postData' => Input::all()
        ]);
    }
    
    public function analyticsVillage()
    {
        $status = $this->userService->getAnalyticsVillage();
        return response()->json($status, 200);
    }

    public function householdVillage()
    {
        $status = $this->userService->getHouseholdPHCVillage();
        return response()->json($status, 200);
    }

    public function createHousehold()
    {
//        echo 88;exit;
        $this->userService->createHousehold();
    }

    public function getHousehold()
    {
//        echo 88;exit;
        $data = $this->userService->getHousehold();
        return response()->json(['data' => $data], 200);
    }

    public function downloadExcel()
    {
        $data = $this->userService->getHousehold();

//        $data = array("check"=> "test1",
//            "check2"=> "test2",
//            
//            );
        $type = "xlsx";
        return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
                    $excel->sheet('Households', function($sheet) use ($data) {
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

    /**
     * To Assign selected users to the specified group
     * @return type
     */
    public function assignGroupUsersView()
    {
        $userData = $this->request->input("userData");
        $userData = json_decode($userData);

        $groupService = new \App\Services\GroupService($this->request);
        $groups = $groupService->getGroupList();

        return view('users.groupAssign', ["title" => "Assign Users to group",
            "groups" => $groups,
            "userData" => $userData,
            "pageHeading" => "Add New User"]);
    }

    public function assignGroupUsers()
    {
        $value = $this->userService->assignGroupUsers();
        //On Success redirecting to edit group page
        if ($value == true) {
            return redirect('groups/update/' . $this->request->input("group_id"))
                            ->with('status', 'Users Assigned Successfully');
        }
        return redirect('dashboard');
    }

    public function chat()
    {
        $this->request->request->add(['role_name' => "student"]);
        $usersList = $this->userService->getUserList();
        return view('users.chat', ["title" => "Mtc Chat",
            "pageHeading" => "Mtc Chat",
            "usersList" => $usersList
        ]);
    }

}
