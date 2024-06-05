<?php
namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Permission;
use App\Models\RolesPermission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Employeedesignation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employeedepartment;
use Illuminate\Support\Facades\Validator;
use App\Models\Team;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Exports\EmployeeExport;
use App\Models\Country;
use App\Models\BloodGroup;
use App\Models\UserAddress;
use App\Models\UserEmergencyContact;
use App\Models\UserJoiningDetail;
use App\Models\UserOfficialContact;
use App\Models\UserFamilyInfo;
use App\Models\UserEducationInfo;
use App\Models\EmployeeDegree;
use App\Models\EmployeeSkills;
use App\Models\UserBankInfo;
use App\Models\UserExperienceInfo;
use App\Models\UserAdditionalInfo;
use App\Models\MasterDocument;
use App\Models\UserDocument;
use App\Models\UserAttendance;
use App\Models\Leave;
use Illuminate\Support\Facades\Cookie;
use AWS\CRT\HTTP\Response;
use App\Models\UserStatutoryInfo;
use Illuminate\Support\Facades\Mail;
use App\Models\JoiningLogs;
use App\Models\EmployeeShift;
use App\Models\LeaveAllocation;

class EmployeeController extends Controller
{

    //
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0] . "'s Team",
            'personal_team' => true
        ]));
    }

    public function employee(Request $request)
    {
        /* Searching Functionality */
        $employeeName = $request->search_name ?? "";
        $desigantionName = $request->search_designation ?? "";
        $status = $request->search_status ?? "";
        $roleName = $request->search_role ?? "";
        $gender = $request->search_gender ?? "";
        /* End here */

        $roles = Role::get();
        $designations = Employeedesignation::get();
        $departments = Employeedepartment::get();
        $employee = User::where('user_role', '!=', '0')->orderBy('first_name','ASC')->where('status','1')->get();
        
        if ((Auth::user()->user_role == 0) || Permission::userpermissions('employees', 1) || RolesPermission::userpermissions('employees', 1)) {
            $users = User::select([
                '_id',
                'first_name',
                'last_name',
                'email',
                'photo',
                'status',
                'contact',
                'department',
                'designation',
                'user_role'
            ])->where('user_role', '!=', '0')->orderBy('_id', 'DESC');

            if (($employeeName) && ($employeeName != 'all') && ($employeeName != '')) {
                $users = User::whereIn('_id', $employeeName);
            }
            if (($desigantionName) && ($desigantionName != 'all') && ($desigantionName != '')) {
                $users = $users->where('designation', $desigantionName);
            }
            if (($status) && ($status != 'all') && ($status != '')) {
                $users = $users->where('status', $status);
            }
            if (($roleName) && ($roleName != 'all') && ($roleName != '')) {
                $users = $users->where('user_role', $roleName);
            }
            if (($gender) && ($gender != 'all') && ($gender != '')) {
                $users = $users->where('gender', '=', $gender);
            }
            $role = Role::where('_id', Auth::user()->user_role)->first();

            if (! empty($role) && ($role->name == 'Management')) {
                $userManager = User::where('reporting_manager', Auth::user()->_id)->get()
                    ->pluck('_id')
                    ->toArray();
                $users = $users->whereIn('_id', $userManager);
            }
            $users = $users->paginate(12)->withQueryString();
            return view('admin.Employee.employee', compact('roles', 'designations', 'employee', 'users', 'employeeName', 'desigantionName', 'status', 'roleName', 'departments', 'gender'));
        } else {
            return redirect('/dashboard');
        }
    }

    public function addEmployee(Request $request)
    {
        $roles = Role::get();
        $designations = Employeedesignation::get();
        $departments = Employeedepartment::get();
        $employee = User::get();
        $employee_id = (User::count() + 1);
        $employeeShifts = EmployeeShift::get();
        return view('admin.Employee.add', compact('roles', 'designations', 'employee', 'departments', 'employee_id', 'employeeShifts'));
    }

    public function employeeCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:100',
            'last_name' => 'nullable|regex:/^[\pL\s\-]+$/u|min:3|max:100',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required',
            'date_of_birth' => 'nullable|before:' . now()->subYears(18)->toDateString(),
            'joining_date' => 'nullable|after:date_of_birth',
            'contact' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'shift_id'=>'required'
        ], [
            'shift_id.required' => 'Employee shift is required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $url = asset('images/user.png');
        if (! empty($request->photo)) {
            if (! empty($request->photo->getClientOriginalName())) {
                if (! in_array($request->photo->getClientOriginalExtension(), [
                    'png',
                    'jpg',
                    'jpeg',
                    'gif'
                ])) {
                    return response()->json([
                        'errors' => [
                            'photo' => 'png,jpg,jpeg is allowed only'
                        ]
                    ]);
                }
                $filename = time() . '.' . $request->photo->getClientOriginalName();
                $filePath = 'employee_image/' . $filename;
                $path = Storage::disk('s3')->put($filePath, file_get_contents($request->photo));
                $url = Storage::disk('s3')->url($filePath);
            } else {
                $url = asset('images/user.png');
            }
        }

        if(! empty($request->employee_id)){
            $user = User::where('user_role','!=','0')->get()->pluck('employee_id')->toArray();
            if(in_array('SSPL'.$request->employee_id,$user)){
                return response()->json([
                    'errors' => [
                        'employee_id' => 'This employee code is already exists'
                    ]
                ]);
            }
        }
        $user = User::Create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth,
            'joining_date' => $request->joining_date,
            'contact' => $request->contact,
            'photo' => $url,
            'contact' => $request->contact,
            'designation' => $request->designation,
            'department' => $request->department,
            'reporting_manager' => $request->reporting_manager,
            'app_login' => $request->app_login,
            'employee_id' => 'SSPL' . $request->employee_id,
            'email_notification' => $request->email_notification,
            'workplace' => $request->workplace,
            'user_role' => $request->user_role,
            'gender' => $request->gender,
            'status' => $request->status,
            'notes' => $request->notes,
            'probation_period' => $request->probation_period,
            'shift_id' => $request->shift_id
        ]);
        $this->createTeam($user);
        Session::flash('success', 'Employee added successfully');
    }

    public function employeeUpdate($id)
    {
        $userUpdate = User::where('_id', $id)->first();
        $employee_id = str_replace('SSPL', '', $userUpdate->employee_id);
        $roles = Role::get();
        $designations = Employeedesignation::get();
        $departments = Employeedepartment::get();
        $employee = User::get();
        $employeeShifts = EmployeeShift::get();
        return view('admin.Employee.update', compact('userUpdate', 'roles', 'designations', 'employee', 'departments', 'employee_id', 'employeeShifts'));
    }

    public function employeeUpdated(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required||regex:/^[\pL\s\-]+$/u|min:3|max:100',
            // 'last_name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:100',
            'email' => 'required|email:rfc,dns|unique:users,email,' . $request->user_id . ',_id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'date_of_birth' => 'nullable|before:' . now()->subYears(18)->toDateString(),
            'employee_id' => 'unique:users,employee_id,' . $request->user_id.',_id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $updateUser = User::where('_id', $request->user_id)->first();

        if (! empty($updateUser)) {
            $url = asset('images/user.png');
            if (! empty($request->photo)) {
                if (! empty($request->photo->getClientOriginalName())) {
                    $filename = time() . '.' . $request->photo->getClientOriginalName();
                    $filePath = 'employee_image/' . $filename;
                    $path = Storage::disk('s3')->put($filePath, file_get_contents($request->photo));
                    $url = Storage::disk('s3')->url($filePath);
                    $updateUser->photo = $url;
                } else {
                    $url = asset('images/user.png');
                }
            }
        }
        if(! empty($request->employee_id)){
            $user = User::where('user_role','!=','0')->where('_id','!=',$request->user_id)->get()->pluck('employee_id')->toArray();
                if(in_array('SSPL'.$request->employee_id,$user)){
                    return response()->json([
                        'errors' => [
                            'employee_id' => 'This employee code is already exists'
                        ]
                    ]);
                }
        }
        $updateUser->first_name = $request->first_name;
        $updateUser->last_name = $request->last_name;
        $updateUser->email = $request->email;
        $updateUser->password = $request->password != '' ? Hash::make($request->password) : $updateUser->password;
        $updateUser->date_of_birth = $request->date_of_birth;
        $updateUser->joining_date = $request->joining_date;
        $updateUser->contact = $request->contact;
        $updateUser->designation = $request->designation;
        $updateUser->department = $request->department;
        $updateUser->reporting_manager = $request->reporting_manager;
        $updateUser->app_login = $request->app_login;
        $updateUser->mail_notification = $request->email_notification;
        $updateUser->employee_id = 'SSPL' . $request->employee_id;
        $updateUser->workplace = $request->workplace;
        $updateUser->user_role = $request->user_role;
        $updateUser->status = $request->status;
        $updateUser->gender = $request->gender;
        $updateUser->notes = $request->notes;
        $updateUser->probation_period = $request->probation_period;
        $updateUser->shift_id = $request->shift_id;
        $updateUser->update();
        Session::flash('success', 'Employee updated successfully');
    }

    public function userDelete(Request $request)
    {
        $userDelete = User::where('_id', $request->id)->first();
        $userDelete->status = '3';
        $userDelete->update();
        Session::flash('info', 'Employee deleted successfully');
    }

    public function userInactive(Request $request)
    {
        $userDelete = User::where('_id', $request->id)->first();
        $userDelete->status = '2';
        $userDelete->update();
        Session::flash('success', 'Employee Inactivated successfully');
    }

    public function employeeExport(Request $request)
    {
        $searchName = $request->search_name ?? '';
        $searchDesignation = $request->search_designation ?? '';
        $searchStatus = $request->search_status ?? '';
        $searchRole = $request->search_role ?? '';

        $fileName = 'EmployeeData.csv';

        $query = User::orderBy('_id', 'Desc')->get();
        if (($searchName != '' && $searchName != 'all')) {
            $query = User::orderBy('_id', 'Desc')->where('_id', $searchName)->get();
        } elseif (($searchDesignation != '' && $searchDesignation != 'all')) {
            $query = User::orderBy('_id', 'Desc')->where('designation', $searchDesignation)->get();
        } elseif (($searchStatus != '' && $searchStatus != 'all')) {
            $query = User::orderBy('_id', 'Desc')->where('status', $searchStatus)->get();
        } elseif (($searchRole != '' && $searchRole != 'all')) {
            $query = User::orderBy('_id', 'Desc')->where('user_role', $searchRole)->get();
        }
        $columns = array(
            'Employee_id ',
            'First Name',
            'Last Name',
            'Email',
            'Date Of Birth',
            'Joining Date',
            'Contact',
            'Photo',
            'Department',
            'Designation',
            'Reporting Manager',
            'Email Notification',
            'App Login',
            'Workplace',
            'Status',
            'User Role',
            'Gender',
            'Whats App Number',
            'Blood Group',
            'Marital Status',
            'Children',
            'Passport Number',
            'Passport Expiry Date',
            'Spouse Employment',
            'Religion',
            'Nationality'
        );
        $callback = function () use ($query, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($query as $task) {
                $row = array(
                    $task->employee_id,
                    $task->first_name,
                    $task->last_name,
                    $task->email,
                    $task->date_of_birth,
                    $task->joining_date,
                    $task->contact,
                    $task->photo,
                    $task->getdepartment()->title ?? '',
                    $task->getdesignation()->title ?? '',
                    $task->getReportingmanager(),
                    $task->email_notification == 1 ? 'no' : 'yes',
                    $task->app_login == 1 ? 'no' : 'yes',
                    $task->workplace == 1 ? 'WFO' : 'WFH',
                    $task->status == 1 ? 'Active' : 'Inactive',
                    $task->get_userrole()->name ?? 'admin',
                    $task->gender ?? '',
                    $task->whatsapp ?? '',
                    $task->blood_group ?? '',
                    $task->marital_status ?? '',
                    $task->children ?? '',
                    $task->passport_number ?? '',
                    $task->passport_expiry_date ?? '',
                    $task->spouse_employment ?? '',
                    $task->religion ?? '',
                    $task->nationality ?? ''
                );
                fputcsv($file, $row);
            }
        };
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        return response()->stream($callback, 200, $headers);
    }

    public function employeeProfile(Request $request, $employee_id)
    {
        if ($employee_id != '') {
            $userDetail = User::where('_id', $employee_id)->first();
            if (empty($userDetail)) {
                return redirect('/employee');
            }
        }

        $tabs = isset($_GET) ? (! empty($_GET) ? $_GET['activetab'] : "personal") : "personal";
        $from_Date = $request->from_date ?? "";
        $to_Date = $request->to_date ?? "";
        $leave_from_date = $request->leave_from_date ?? "";
        $leave_to_date = $request->leave_to_date ?? "";
        $userData = User::where('_id', $employee_id)->first();
        $emergencyContact = UserEmergencyContact::where('user_id', $employee_id)->get();
        $joiningDetail = UserJoiningDetail::where('user_id', $employee_id)->first();
        $officialContact = UserOfficialContact::where('user_id', $employee_id)->first();
        $familyInformation = UserFamilyInfo::where('user_id', $employee_id)->get();
        $userEducation = UserEducationInfo::where('user_id', $employee_id)->get();
        $employeeSkills = EmployeeSkills::where('user_id', $employee_id)->get();
        $allDegree = EmployeeDegree::get();
        $userExperience = UserExperienceInfo::where('user_id', $employee_id)->get();
        $bankInfo = UserBankInfo::where('user_id', $employee_id)->first();

        $userAdditionDetails = UserAdditionalInfo::where('user_id', $employee_id)->first();
        $masterDocument = MasterDocument::all();
        $employeeDocument = UserDocument::where('user_id', $employee_id)->paginate(10)
            ->withQueryString()
            ->appends([
            'activetab' => 'document'
        ]);

        // $employeeFolder = Folder::where('user_id',$employee_id) ->paginate(10)->withQueryString()->appends([ 'activetab' => 'document' ]);
        $employeeBank = UserStatutoryInfo::where('user_id', $employee_id)->first();

        $employeeAttendance = UserAttendance::where('user_id', $employee_id);

        if ($from_Date || $to_Date) {
            $employeeAttendance = $employeeAttendance->where('date', '>=', strtotime($from_Date))->where('date', '<=', strtotime($to_Date));
        }
        $employeeAttendance = $employeeAttendance->orderBy('date', 'DESC')
            ->paginate(5)
            ->withQueryString()
            ->appends([
            'activetab' => 'attendance'
        ]);

        $employeeLeave = Leave::where('name', $employee_id);

        if ($leave_from_date) {
            $employeeLeave = Leave::where('name', $employee_id)->where('str_from_date', strtotime($leave_from_date))->where('str_to_date', strtotime($leave_to_date));
        }
        $employeeLeave = $employeeLeave->paginate(5)
            ->withQueryString()
            ->appends([
            'activetab' => 'leaves'
        ]);
        ;

        return view('admin.Employee.employee-profile', compact('userData', 'tabs', 'emergencyContact', 'joiningDetail', 'officialContact', 'familyInformation', 'userEducation', 'allDegree', 'employeeSkills', 'bankInfo', 'userExperience', 'userAdditionDetails', 'masterDocument', 'employeeDocument', 'employeeAttendance', 'from_Date', 'to_Date', 'leave_from_date', 'leave_to_date', 'employeeLeave', 'employeeBank'));
    }

    public function personalInformation($employee_id, Request $request)
    {
        $countries = Cache::rememberForever('countries', function () {
            return Country::get();
        });
        $bloodGroup = BloodGroup::get();
        $userData = User::where('_id', $employee_id)->first();

        return view('admin.Employee.personal-information', compact('userData', 'countries', 'bloodGroup'));
    }

    public function addPersonalInformation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whatsapp' => 'nullable|numeric|max_digits:15',
            'children' => 'nullable',
            'nationality' => 'required|regex:/^[a-zA-Z ]*$/|max:90',
            'marital_status' => 'required|regex:/^[a-zA-Z ]*$/|max:90',
            'personal_email' => 'nullable|email',
            'blood_group' => 'nullable',
            'passport_number' => 'nullable|regex:/^[a-zA-Z0-9 ]*$/',
            'religion' => 'nullable|alpha',
            'currentzipcode' => 'nullable|numeric|max_digits:15',
            'permanentzipcode' => 'nullable|numeric|max_digits:15'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        User::where('_id', $request->user_id)->update([
            'gender' => $request->gender,
            'whatsapp' => $request->whatsapp,
            'personal_email' => $request->personal_email,
            'nationality' => $request->nationality,
            'religion' => $request->religion,
            'blood_group' => $request->blood_group,
            'marital_status' => $request->marital_status,
            'spouse_employment' => $request->spouse_employment,
            'children' => $request->children,
            'passport_number' => $request->passport_number,
            'passport_expiry_date' => strtotime($request->passport_expiry_date)
        ]);
        $addressExist = UserAddress::where('user_id', $request->user_id)->first();
        $addressData = array(
            'user_id' => $request->user_id,
            'current_country_id' => $request->selectedCurrentCountry,
            'current_state_id' => $request->current_state_id,
            'current_city_id' => $request->current_city_id,
            'current_zipcode' => $request->currentzipcode,
            'current_address' => $request->currentaddress,
            'permanent_country_id' => $request->selectedPermanentCountry,
            'permanent_state_id' => $request->permanent_state_id,
            'permanent_city_id' => $request->permanent_city_id,
            'permanent_zipcode' => $request->permanentzipcode,
            'permanent_address' => $request->permanentaddress,
            'present' => '0',
            'notes' => $request->notes
        );
        if ($addressExist) {
            UserAddress::where('_id', $addressExist['_id'])->update($addressData);
        } else {
            UserAddress::create($addressData);
        }
        Session::flash('success', 'Information updated successfully');
    }

    // public function allCountries()
    // {

    // Country::query()->truncate();

    // }
    public function addEmergency(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'relationship' => 'required',
            'phone' => 'required',
            'phone_two' => 'nullable|numeric|min_digits:10|max_digits:15',
            'email' => 'nullable|email:rfc,dns|max:90'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        UserEmergencyContact::create([
            'name' => $request->name,
            'relationship' => $request->relationship,
            'phone' => $request->phone,
            'phone_two' => $request->phone_two,
            'email' => $request->email,
            'user_id' => $request->user_id,
            'notes' => $request->notes
        ]);
        Session::flash('success', 'Emergency added successfully');
    }

    public function editEmergency(Request $request)
    {
        $emergencyContact = UserEmergencyContact::where('_id', $request->id)->where('user_id', $request->userId)->first();
        if (! empty($emergencyContact)) {
            $data = [
                'id' => $emergencyContact->_id,
                'name' => $emergencyContact->name,
                'relationship' => $emergencyContact->relationship,
                'phone' => $emergencyContact->phone,
                'phone_two' => $emergencyContact->phone_two,
                'email' => $emergencyContact->email,
                'notes' => $emergencyContact->notes,
                'user_id' => $emergencyContact->user_id
            ];
            return json_encode($data);
        }
    }

    public function updateEmergency(Request $request)
    {
        $updateContact = UserEmergencyContact::where('_id', $request->edit_id)->where('user_id', $request->user_id)->first();
        $updateContact->name = ! empty($request->name) ? $request->name : '';
        $updateContact->relationship = ! empty($request->relationship) ? $request->relationship : '';
        $updateContact->phone = ! empty($request->phone) ? $request->phone : '';
        $updateContact->phone_two = ! empty($request->phone_two) ? $request->phone_two : "";
        $updateContact->email = ! empty($request->email) ? $request->email : "";
        $updateContact->notes = ! empty($request->notes) ? $request->notes : "";
        $updateContact->user_id = ! empty($request->user_id) ? $request->user_id : '';
        $updateContact->update();
        Session::flash('success', 'Emergency added successfully');
    }

    public function contactDelete(Request $request)
    {
        $contactDelete = UserEmergencyContact::where('_id', $request->id)->first();
        $contactDelete->delete();
    }

    public function editJoining(Request $request)
    {
        $editJoining = UserJoiningDetail::where('user_id', $request->userId)->first();
        if (! empty($editJoining)) {
            $data = [
                'user_id' => $editJoining->user_id,
                'confirmation_check' => $editJoining->confirmation_check,
                'notice_period' => $editJoining->notice_period,
                'probation_period' => $editJoining->probation_period,
                'other_terms' => $editJoining->other_terms,
                'notes' => $editJoining->notes
            ];
            return json_encode($data);
        }
    }

    public function addJoining(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notice_period' => 'nullable|regex:/^[a-zA-Z0-9 ]*$/|max:20',
            'probation_period' => 'nullable|regex:/^[a-zA-Z0-9 ]*$/|max:20'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $userJoining = UserJoiningDetail::where('user_id', $request->user_id)->first();
        $joiningData = array(
            'user_id' => $request->user_id,
            'confirmation_date' => date('Y-m-d'),
            // 'notice_period' => $request->notice_period,
            'probation_period' => $request->probation_period,
            // 'other_terms' => $request->other_terms,
            'notes' => $request->notes,
            'status' => '5'
            // 'confirmation_check' => $request->confirmation_check
        );
        $user = User::where('_id', $request->user_id)->update([
            'probation_period' => $request->probation_period
        ]);

        if (! empty($userJoining)) {
            UserJoiningDetail::where('user_id', $userJoining->user_id)->update($joiningData);
            Session::flash('success', 'Joining updated successfully');
        } else {
            UserJoiningDetail::create($joiningData);
            Session::flash('success', 'Joining added successfully');
        }
        $user = User::where('_id', $request->user_id)->first();
        $userEmail = $user->email;
        $rm = User::where('_id', $user->reporting_manager)->first();
        $joiningdetails = UserJoiningDetail::where('user_id', $request->user_id)->first();

        Mail::send('emails.employeeExtend', [
            'name' => $user->first_name . ' ' . $user->last_name,
            'probation_period' => $joiningdetails->probation_period,
            'joining_date' => $user->joining_date,
            'rm_name' => $rm->first_name . ' ' . $rm->last_name
        ], function ($user) use ($rm) {
            $user->to($rm->email);
            $user->subject('Probation Extension Update');
        });
        Mail::send('emails.employeeExtendUser', [
            'name' => $user->first_name . ' ' . $user->last_name,
            'probation_period' => $joiningdetails->probation_period,
            'joining_date' => $user->joining_date
        ], function ($user) use ($userEmail) {
            $user->to($userEmail);
            $user->subject('Probation Extension');
        });
    }

    public function editOfficialContact(Request $request)
    {
        $editOfficial = UserOfficialContact::where('user_id', $request->userId)->first();

        if (! empty($editOfficial)) {
            $data = [
                'user_id' => $editOfficial->user_id,
                'redmine_username' => $editOfficial->redmine_username,
                'discord_username' => $editOfficial->discord_username,
                'skype_id' => $editOfficial->skype_id,
                'notes' => $editOfficial->notes
            ];
            return json_encode($data);
        }
    }

    public function addOfficialcontact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'redmine_username' => 'nullable|max:90',
            'discord_username' => 'nullable|max:90',
            'skype_id' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $userOfficial = UserOfficialContact::where('user_id', $request->user_id)->first();
        $officialData = array(
            'user_id' => $request->user_id,
            'redmine_username' => $request->redmine_username,
            'discord_username' => $request->discord_username,
            'skype_id' => $request->skype_id,
            'notes' => $request->notes
        );
        if (! empty($userOfficial)) {
            UserOfficialContact::where('user_id', $userOfficial->user_id)->update($officialData);
            Session::flash('success', 'Contact updated successfully');
        } else {
            UserOfficialContact::create($officialData);
            Session::flash('success', 'Contact added successfully');
        }
    }

    public function addFamilyInformation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_of_birth' => 'nullable|before:' . now()->toDateString(),
            'name' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25',
            'relationship' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25',
            'phone' => 'nullable|numeric|min_digits:10|max_digits:15',
            'address' => 'nullable|min:3'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        UserFamilyInfo::create([
            'user_id' => $request->user_id,
            'date_of_birth' => $request->name,
            'name' => $request->name,
            'relationship' => $request->relationship,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'address' => $request->address,
            'notes' => $request->notes
        ]);
        Session::flash('success', 'Family added successfully');
    }

    public function editFamily(Request $request)
    {
        $userFamily = UserFamilyInfo::where('_id', $request->id)->where('user_id', $request->userId)->first();
        if (! empty($userFamily)) {
            $data = [
                'id' => $userFamily->_id,
                'date_of_birth' => $userFamily->date_of_birth,
                'relationship' => $userFamily->relationship,
                'name' => $userFamily->name,
                'phone' => $userFamily->phone,
                'address' => $userFamily->address,
                'user_id' => $userFamily->user_id,
                'notes' => $userFamily->notes
            ];
            return json_encode($data);
        }
    }

    public function updateFamilyInformation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_of_birth' => 'nullable|before:' . now()->toDateString(),
            'name' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25',
            'relationship' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25',
            'phone' => 'nullable|numeric|min_digits:10|max_digits:15',
            'address' => 'nullable|min:3'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $updateContact = UserFamilyInfo::where('_id', $request->edit_family_id)->where('user_id', $request->user_id)->first();
        $updateContact->relationship = $request->relationship;
        $updateContact->phone = $request->phone;
        $updateContact->name = ! empty($request->name) ? $request->name : "";
        $updateContact->address = ! empty($request->address) ? $request->address : "";
        $updateContact->user_id = ! empty($request->user_id) ? $request->user_id : '';
        $updateContact->notes = ! empty($request->notes) ? $request->notes : '';
        $updateContact->update();
        Session::flash('success', 'Family updated successfully');
    }

    public function FamilyDelete(Request $request)
    {
        $contactDelete = UserFamilyInfo::where('_id', $request->id)->first();
        $contactDelete->delete();
        Session::flash('info', 'Family deleted successfully');
    }

    public function addEducationDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'institute' => 'required',
            'starting_date' => 'bail|nullable|before:' . now()->toDateString(),
            'completed_date' => 'nullable|after:starting_date|before:' . now()->toDateString()
        ], [
            'document' => 'nullable',
            'extension' => 'nullable|in:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        if (! empty($request->document)) {
            if (! empty($request->document->getClientOriginalName())) {
                $filename = time() . '.' . $request->document->getClientOriginalName();
                $filePath = 'Education_document/' . $filename;
                $path = Storage::disk('s3')->put($filePath, file_get_contents($request->document));
                $url = Storage::disk('s3')->url($filePath);
            }
        }
        $userEducation = UserEducationInfo::Create([
            'institute' => $request->institute,
            'starting_date' => $request->starting_date,
            'completed_date' => $request->completed_date,
            'degree' => $request->degree,
            'grade' => $request->grade,
            'document' => ! empty($url) ? $url : '',
            'user_id' => $request->user_id,
            'notes' => $request->notes
        ]);
        Session::flash('success', 'Education added successfully');
    }

    public function editEmployeeEducation(Request $request)
    {
        $employeeEducation = UserEducationInfo::where('_id', $request->id)->where('user_id', $request->userId)->first();
        if (! empty($employeeEducation)) {
            $data = [
                'id' => $employeeEducation->_id,
                'institute' => $employeeEducation->institute,
                'starting_date' => $employeeEducation->starting_date,
                'completed_date' => $employeeEducation->completed_date,
                'degree' => $employeeEducation->degree,
                'grade' => $employeeEducation->grade,
                'document' => $employeeEducation->document,
                'user_id' => $employeeEducation->user_id,
                'notes' => $employeeEducation->notes
            ];
            return json_encode($data);
        }
    }

    public function updateEducationDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'institute' => 'required|regex:/^[a-zA-Z ]*$/',
            'starting_date' => 'bail|nullable|before:' . now()->toDateString(),
            'completed_date' => 'nullable|after:starting_date|before:' . now()->toDateString()
        ], [
            'document' => 'nullable',
            'extension' => 'nullable|in:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $updateEducation = UserEducationInfo::where('_id', $request->edit_education_id)->where('user_id', $request->user_id)->first();
        if (! empty($updateEducation)) {
            if (! empty($request->document)) {
                if (! empty($request->document->getClientOriginalName())) {
                    $filename = time() . '.' . $request->document->getClientOriginalName();
                    $filePath = 'employee_experience/' . $filename;
                    $path = Storage::disk('s3')->put($filePath, file_get_contents($request->document));
                    $url = Storage::disk('s3')->url($filePath);
                    $updateEducation->document = $url;
                }
            }
        }
        $updateEducation->institute = $request->institute;
        $updateEducation->starting_date = $request->starting_date;
        $updateEducation->completed_date = ! empty($request->completed_date) ? $request->completed_date : "";
        $updateEducation->user_id = ! empty($request->user_id) ? $request->user_id : '';
        $updateEducation->grade = $request->grade;
        $updateEducation->notes = $request->notes;
        $updateEducation->update();
        Session::flash('success', 'Education updated successfully');
    }

    public function educationDelete(Request $request)
    {
        $educationDelete = UserEducationInfo::where('_id', $request->id)->first();
        $educationDelete->delete();

        Session::flash('info', 'Education deleted successfully');
    }

    public function addSkills(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_skill' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $employeeSkill = EmployeeSkills::Create([
            'employee_skill' => $request->employee_skill,
            'user_id' => $request->user_id,
            'notes' => $request->notes
        ]);
        Session::flash('success', 'Skill added successfully');
    }

    public function editSkills(Request $request)
    {
        $employeeSkill = EmployeeSkills::where('_id', $request->id)->where('user_id', $request->userId)->first();
        if (! empty($employeeSkill)) {
            $data = [
                'id' => $employeeSkill->_id,
                'employee_skill' => $employeeSkill->employee_skill,
                'user_id' => $employeeSkill->user_id,
                'notes' => $employeeSkill->notes
            ];
            return json_encode($data);
        }
    }

    public function updatedSkills(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_skill' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $updateSkill = EmployeeSkills::where('_id', $request->id)->where('user_id', $request->user_id)->first();
        $updateSkill->employee_skill = $request->employee_skill;
        $updateSkill->user_id = ! empty($request->user_id) ? $request->user_id : '';
        $updateSkill->notes = ! empty($request->notes) ? $request->notes : '';
        $updateSkill->update();
        Session::flash('success', 'Skill updated successfully');
    }

    public function skillDelete(Request $request)
    {
        $skillDelete = EmployeeSkills::where('_id', $request->id)->first();
        $skillDelete->delete();
        Session::flash('info', 'Skill deleted successfully');
    }

    public function editBankInfo(Request $request)
    {
        $editBankInfo = UserBankInfo::where('user_id', $request->userId)->first();
        if (! empty($editBankInfo)) {
            $data = [
                'username' => $editBankInfo->username,
                'bank_name' => $editBankInfo->bank_name,
                'account' => $editBankInfo->account,
                'ifsc' => $editBankInfo->ifsc,
                'pan' => $editBankInfo->pan,
                'user_id' => $editBankInfo->user_id,
                'notes' => $editBankInfo->notes
            ];
            return json_encode($data);
        }
    }

    public function addBankInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'bank_name' => 'required',
            'account' => 'required',
            'ifsc' => 'required|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/|max:15',
            'pan' => 'required|regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/|max:15'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $userBank = UserBankInfo::where('user_id', $request->user_id)->first();
        $bankInfo = array(
            'username' => $request->username,
            'bank_name' => $request->bank_name,
            'account' => $request->account,
            'ifsc' => $request->ifsc,
            'pan' => $request->pan,
            'user_id' => $request->user_id,
            'notes' => $request->notes
        );
        if (! empty($userBank)) {
            UserBankInfo::where('user_id', $userBank->user_id)->update($bankInfo);
            Session::flash('success', 'Bank Information updated successfully');
        } else {
            UserBankInfo::create($bankInfo);
            Session::flash('success', 'Bank Information added successfully');
        }
    }

    public function experienceInformation($employee_id)
    {
        $userData = User::where('_id', $employee_id)->first();
        $countries = Country::all();
        return view('admin.Employee.experience-information', compact('userData', 'countries'));
    }

    public function addExperience(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'designation' => 'required|regex:/^[a-zA-Z ]*$/',
            'employee_type' => 'required',
            'relevant_experience' => 'required',
            'period_from' => 'required|date|before_or_equal:period_to',
            'period_to' => 'required|date|after_or_equal:period_from'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        if (! empty($request->documents)) {
            if (! empty($request->documents->getClientOriginalName())) {
                $filename = time() . '.' . $request->documents->getClientOriginalName();
                $filePath = 'employee_experience/' . $filename;
                $path = Storage::disk('s3')->put($filePath, file_get_contents($request->documents));
                $url = Storage::disk('s3')->url($filePath);
            }
        }
        $userExperience = UserExperienceInfo::Create([
            'user_id' => $request->user_id,
            'company_name' => $request->company_name,
            'designation' => $request->designation,
            'employee_type' => $request->employee_type,
            'period_from' => strtotime($request->period_from),
            'period_to' => strtotime($request->period_to),
            'relevant_experience' => $request->relevant_experience,
            'skills' => $request->skills,
            'employee_id' => $request->employee_id,
            'net_pay' => $request->net_pay,
            'company_city' => $request->company_city,
            'company_state' => $request->company_state,
            'company_country' => $request->company_country,
            'company_pincode' => $request->company_pincode,
            'company_website' => $request->company_website,
            'manager_name' => $request->manager_name,
            'manager_designation' => $request->manager_designation,
            'manager_contact' => $request->manager_contact,
            'manager_email' => $request->manager_email,
            'verification_status' => $request->verification_status,
            'leaving_reason' => $request->leaving_reason,
            'documents' => ! empty($url) ? $url : '',
            'notes' => $request->notes
        ]);
        Session::flash('success', 'Experience added successfully');
    }

    public function editExperience($experience_id, $employee_id)
    {
        $userData = User::where('_id', $employee_id)->first();
        $employeeExperience = UserExperienceInfo::where('_id', $experience_id)->where('user_id', $employee_id)->first();
        $countries = Country::all();
        return view('admin.Employee.edit-experience-information', compact('userData', 'countries', 'employeeExperience'));
    }

    public function updatedExperienced(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'designation' => 'required|regex:/^[a-zA-Z ]*$/',
            'employee_type' => 'required',
            'relevant_experience' => 'required',
            // 'employee_id' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
            'period_from' => 'required|before:' . now()->toDateString(),
            'period_to' => 'nullable|after:experienceinputs.*.period_from|before:' . now()->toDateString()
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $userExperience = UserExperienceInfo::where('_id', $request->edit_experience_id)->where('user_id', $request->user_id)->first();
        if (! empty($userExperience)) {
            if (! empty($request->documents)) {
                if (! empty($request->documents->getClientOriginalName())) {
                    $filename = time() . '.' . $request->documents->getClientOriginalName();
                    $filePath = 'employee_experience/' . $filename;
                    $path = Storage::disk('s3')->put($filePath, file_get_contents($request->documents));
                    $url = Storage::disk('s3')->url($filePath);
                    $userExperience->documents = $url;
                }
            }
        }
        $userExperience->company_name = $request->company_name;
        $userExperience->designation = $request->designation;
        $userExperience->employee_type = $request->employee_type;
        $userExperience->period_from = strtotime($request->period_from);
        $userExperience->period_to = strtotime($request->period_to);
        $userExperience->relevant_experience = $request->relevant_experience;
        $userExperience->skills = $request->skills;
        $userExperience->employee_id = $request->employee_id;
        $userExperience->net_pay = $request->net_pay;
        $userExperience->company_city = $request->company_city;
        $userExperience->company_state = $request->company_state;
        $userExperience->company_country = $request->company_country;
        $userExperience->company_pincode = $request->company_pincode;
        $userExperience->company_website = $request->company_website;
        $userExperience->manager_name = $request->manager_name;
        $userExperience->manager_designation = $request->manager_designation;
        $userExperience->manager_contact = $request->manager_contact;
        $userExperience->manager_email = $request->manager_email;
        $userExperience->verification_status = $request->verification_status;
        $userExperience->leaving_reason = $request->leaving_reason;
        $userExperience->notes = $request->notes;
        $userExperience->update();
        Session::flash('success', 'Experience upated successfully');
    }

    public function deleteExperience(Request $request)
    {
        $experienceDelete = UserExperienceInfo::where('_id', $request->id)->first();
        $experienceDelete->delete();
        Session::flash('info', 'Experience deleted successfully');
    }

    public function editAdditionData(Request $request)
    {
        $editAddition = UserAdditionalInfo::where('user_id', $request->userId)->first();
        if (! empty($editAddition)) {
            $data = [
                'user_id' => $editAddition->user_id,
                'allergies' => $editAddition->allergies,
                'smoke' => $editAddition->smoke,
                'drink' => $editAddition->drink,
                'diet' => $editAddition->diet,
                'hobbies' => $editAddition->hobbies,
                'notes' => $editAddition->notes
            ];
            return json_encode($data);
        }
    }

    public function updatedAddition(Request $request)
    {
        $userAddition = UserAdditionalInfo::where('user_id', $request->user_id)->first();
        $additionData = array(
            'user_id' => $request->user_id,
            'allergies' => $request->allergies,
            'smoke' => $request->smoke,
            'drink' => $request->drink,
            'diet' => $request->diet,
            'hobbies' => $request->hobbies,
            'user_id' => $request->user_id,
            'notes' => $request->notes
        );
        if (! empty($userAddition)) {
            UserAdditionalInfo::where('user_id', $userAddition->user_id)->update($additionData);
            Session::flash('success', 'Additional details updated successfully');
        } else {
            UserAdditionalInfo::create($additionData);
            Session::flash('success', 'Additions details added successfully');
        }
    }

    public function uploadDocuments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25',
            'type' => 'required'
        ], [
            'document' => 'nullable',
            'extension' => 'nullable|in:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        if (! empty($request->document)) {
            foreach ($request->document as $file) {
                $filename = time() . '.' . $file->getClientOriginalName();
                $filePath = 'employee_documents/' . $filename;
                $path = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $url = Storage::disk('s3')->url($filePath);
                $userDocument = UserDocument::Create([
                    'user_id' => $request->user_id,
                    'type' => $request->type,
                    'name' => $request->name,
                    'document' => ! empty($url) ? $url : '',
                    'notes' => $request->notes
                ]);
            }
        }
        Session::flash('success', 'Document added successfully');
    }

    public function editEmployeeDocument(Request $request)
    {
        $employeeDocument = UserDocument::where('_id', $request->id)->where('user_id', $request->userId)->first();
        if (! empty($employeeDocument)) {
            $data = [
                'id' => $employeeDocument->_id,
                'type' => $employeeDocument->type,
                'name' => $employeeDocument->name,
                'document' => $employeeDocument->document,
                'user_id' => $employeeDocument->user_id,
                'notes' => $employeeDocument->notes
            ];
            return json_encode($data);
        }
    }

    public function documentView(Request $request)
    {
        $document = UserDocument::where('_id', $request->id)->where('user_id', $request->userId)->first();

        $data = [
            'notes' => ! empty($document) ? $document->notes : ''
        ];
        return json_encode($data);
    }

    public function updatedDocuments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25',
            'type' => 'required'
        ], [
            'document' => 'nullable',
            'extension' => 'nullable|in:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $userDocuments = UserDocument::where('_id', $request->edit_document_id)->where('user_id', $request->user_id)->first();
        if (! empty($userDocuments)) {
            if (! empty($request->document)) {
                if (! empty($request->document->getClientOriginalName())) {
                    $filename = time() . '.' . $request->document->getClientOriginalName();
                    $filePath = 'employee_experience/' . $filename;
                    $path = Storage::disk('s3')->put($filePath, file_get_contents($request->document));
                    $url = Storage::disk('s3')->url($filePath);
                    $userDocuments->document = $url;
                }
            }
        }
        $userDocuments->name = $request->name;
        $userDocuments->type = $request->type;
        $userDocuments->notes = $request->notes;
        $userDocuments->update();
    }

    public function deleteDocument(Request $request)
    {
        $deleteDocument = UserDocument::where('_id', $request->id)->first();
        $deleteDocument->delete();
        Session::flash('info', 'Document deleted successfully');
    }

    public function bankStatutory($employee_id, Request $request)
    {
        $userData = User::where('_id', $employee_id)->first();
        $userbankstatutory = UserStatutoryInfo::where('user_id', $employee_id)->first();
        return view('admin.Employee.bank-statutory', compact('userData', 'userbankstatutory'));
    }

    public function addbankstatutory(Request $request)
    {
        $validator = Validator::make($request->all(), [
//             'esi_number' => 'required',
//             'dispensary' => 'required',
//             'branch_office' => 'required',
            'previousInsNo' => 'nullable|numeric',
            'employerCode' => 'nullable|numeric',
            'nameAddress' => 'nullable|min:3|max:90',
            'nomineeName' => 'nullable|regex:/^[a-zA-Z ]*$/|min:3|max:90',
            'particularName' => 'nullable|regex:/^[a-zA-Z ]*$/|min:3|max:90',
            'particularDateofbirth' => 'nullable|before:' . now()->toDateString(),
            'particularRelationship' => 'nullable|regex:/^[a-zA-Z ]*$/|min:3|max:90',
            'nomineeAddress' => 'nullable|min:3|max:90',
            'nomineeRelationship' => 'nullable|regex:/^[a-zA-Z ]*$/|min:3|max:90',
            'employerEmail' => 'nullable|email:rfc,dns',
            'uan' => 'nullable|numeric|min_digits:12|max_digits:12'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $user_id = $request->user_id;
        $statutoryInfoExist = UserStatutoryInfo::where('user_id', $user_id)->first();
        $statutoryData = array(
            'user_id' => $user_id,
            'esi' => ! empty($request->esi) ? '1' : '0',
            'esi_number' => $request->esi_number,
            'branch_office' => $request->branch_office,
            'dispensary' => $request->dispensary,
            'previous_employment' => ! empty($request->previous_employment) ? '1' : '0',
            'previousInsNo' => $request->previousInsNo,
            'employerCode' => $request->employerCode,
            'nameAddress' => $request->nameAddress,
            'employerEmail' => $request->employerEmail,
            'nomineeName' => $request->nomineeName,
            'nomineeRelationship' => $request->nomineeRelationship,
            'nomineeAddress' => $request->nomineeAddress,
            'particularName' => $request->particularName,
            'particularDateofbirth' => $request->particularDateofbirth,
            'particularRelationship' => $request->particularRelationship,
            'residancePlace' => $request->residancePlace,
            'nominee_detail' => ! empty($request->nominee_detail) ? '1' : '0',
            'family_particular' => $request->family_particular,
            'residing' => $request->residing,
            'pf' => ! empty($request->pf) ? '1' : '0',
            'uan' => $request->uan,
            'pf_scheme' => $request->pf_scheme,
            'pension_scheme' => $request->pension_scheme,
            'pf_number' => $request->pf_number,
            'pf_joinDate' => $request->pf_joinDate != '' ? strtotime($request->pf_joinDate) : ''
        );
        if ($statutoryInfoExist) {
            UserStatutoryInfo::where('_id', $statutoryInfoExist['_id'])->update($statutoryData);

            Session::flash('success', 'Bank and Statutory updated successfully');
        } else {
            UserStatutoryInfo::create($statutoryData);
            Session::flash('success', 'Bank and Statutory added successfully');
        }
    }

    public function removePhoto($id)
    {
        $userPhoto = User::where('_id', $id)->first();
        $userPhoto->photo = asset('images/user.png');
        $userPhoto->update();
        return redirect('/employee/update/' . $id);
    }

    public function probationEmployee(Request $request)
    {
        $searchStatus = $request->status ?? "";
        $role = Role::where('_id', Auth::user()->user_role)->first();
        $userJoiningData = UserJoiningDetail::orderBy('_id', 'desc');

        if (! empty($role) && ($role->name == 'HR') || (Auth::user()->user_role == 0)) {
            $userJoiningData = UserJoiningDetail::orderBy('_id', 'desc');
            if ((isset($searchStatus)) && ($searchStatus != 'all') && ($searchStatus != '')) {
                $userJoiningData = $userJoiningData->where('status', $searchStatus);
            }
            $userHr = User::where('user_role', '!=', '0')->where('status', '1')
                ->get()
                ->pluck('_id')
                ->toArray();
            $userJoiningData = $userJoiningData->whereIn('user_id', $userHr);
        }
        if (! empty($role) && ($role->name == 'Management')) {
            $userJoiningData = UserJoiningDetail::orderBy('_id', 'desc')->where('status', '0');
            if ((isset($searchStatus)) && ($searchStatus != 'all') && ($searchStatus != '')) {
                $userJoiningData = $userJoiningData->where('status', $searchStatus);
            }
            $userManager = User::where('reporting_manager', Auth::user()->_id)->where('status', '1')
                ->get()
                ->pluck('_id')
                ->toArray();
            $userJoiningData = $userJoiningData->whereIn('user_id', $userManager);
        }
        $userJoiningData = $userJoiningData->paginate(10);
        return view('admin.Employee.employee-probation', compact('userJoiningData','searchStatus'));
    }

    public function rmApprove($id)
    {
        $userJoining = UserJoiningDetail::where('user_id', $id)->update([
            'status' => '1',
            'rm_confirmation_date' => strtotime(date('Y-m-d')),
            'updated_rm' => Auth::user()->_id
        ]);
        $user = User::where('_id', $id)->first();
        if (! empty($user->reporting_manager)) {
            $rm = User::where('_id', $user->reporting_manager)->first();
            $hrd = 'hrd@softuvo.in';
            Mail::send('emails.rmApproveHR', [
                'name' => $user->first_name . ' ' . $user->last_name,
                'rm_name' => $rm->first_name . ' ' . $rm->last_name,
                'joining_date' => $user->joining_date
            ], function ($user) use ($hrd) {
                $user->to($hrd);
                $user->subject('Probation Confirmation');
            });
        }
        Session::flash('success', 'Confirmation approved successfully');
        return redirect()->to('/employee-probation');
    }

    public function hmApprove($id)
    {
        $userJoining = UserJoiningDetail::where('user_id', $id)->update([
            'status' => '2',
            'hr_confirmation_date' => strtotime(date('Y-m-d')),
            'updated_hr' => Auth::user()->_id
        ]);
        $user = User::where('_id', $id)->first();
        $userEmail = $user->email;
        $rm = User::where('_id', $user->reporting_manager)->first();
        // if (! empty($rm)) {
        // Mail::send('emails.hrApproveMailRm', [
        // 'name' => $user->first_name . ' ' . $user->last_name,
        // 'rm_name' => $rm->first_name . ' ' . $rm->last_name,
        // 'joining_date' => $user->joining_date
        // ], function ($user) use ($rm) {
        // $user->to($rm->email);
        // $user->subject('Probation Confirmation');
        // });
        // }
        Mail::send('emails.hrApproveMailEm', [
            'name' => $user->first_name . ' ' . $user->last_name,
            'rm_name' => $rm->first_name . ' ' . $rm->last_name
        ], function ($user) use ($userEmail) {
            $user->to($userEmail);
            $user->subject('Probation Confirmation');
        });
        Session::flash('success', 'Confirmation approved successfully');
        return redirect()->to('/employee-probation');
    }

    public function RMRejection(Request $request)
    {
        $userJoining = UserJoiningDetail::where('user_id', $request->user_id)->update([
            'status' => '3',
            'rm_rejection_date' => strtotime(date('Y-m-d')),
            'updated_rm' => Auth::user()->_id
        ]);
        $joiningStatus = UserJoiningDetail::where('user_id', $request->user_id)->first();

        $joining_log = JoiningLogs::Create([
            'user_id' => $request->user_id,
            'joining_details_id' => $request->joining_detail_id,
            'reason' => $request->reason,
            'type' => '1',
            'status' => $joiningStatus->status,
            'updated_by' => Auth::user()->_id
        ]);
        $user = User::where('_id', $joining_log->user_id)->first();
        if (! empty($user->reporting_manager)) {
            $rm = User::where('_id', $user->reporting_manager)->first();
            $joining_details = JoiningLogs::where('_id', $joining_log->_id)->first();
            $hrd = 'hrd@softuvo.in';
            Mail::send('emails.rmRejectionHr', [
                'name' => $user->first_name . ' ' . $user->last_name,
                'reason' => $joining_details->reason,
                'rm' => $rm->first_name . ' ' . $rm->last_name
            ], function ($user) use ($hrd) {
                $user->to($hrd);
                $user->subject('Probation Extension Update');
            });
            Session::flash('success', 'Confirmation rejected successfully');
        }
    }

    public function HRRejection(Request $request)
    {
        $userJoining = UserJoiningDetail::where('user_id', $request->user_id)->update([
            'status' => '4',
            'hr_rejection_date' => strtotime(date('Y-m-d')),
            'updated_hr' => Auth::user()->_id
        ]);
        $joiningStatus = UserJoiningDetail::where('user_id', $request->user_id)->first();
        $joining_log = JoiningLogs::Create([
            'user_id' => $request->hr_user_id,
            'joining_details_id' => $request->hr_joining_detail_id,
            'reason' => $request->reason,
            'type' => '1',
            'status' => $joiningStatus->status,
            'updated_by' => Auth::user()->_id
        ]);
        $user = User::where('_id', $request->user_id)->first();
        $rm = User::where('_id', $user->reporting_manager)->first();
        Mail::send('emails.hrRejectedMailRm', [
            'name' => $user->first_name . ' ' . $user->last_name,
            'reason' => $request->reason
        ], function ($user) use ($rm) {
            $user->to($rm->email);
            $user->subject('Probation Rejection');
        });
        Session::flash('success', 'Confirmation rejected successfully');
    }

    public function addFolder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'folder_name' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $folderCreate = UserDocument::Create([
            'folder_name' => $request->folder_name,
            'user_id' => $request->user_id,
            'created_by' => Auth::user()->_id,
            'status' => '1'
        ]);
        Session::flash('success', 'Folder created successfully');
    }

    public function LeaveApprove($leave_id, $employ_id)
    {
        $leave = Leave::where('_id', $leave_id)->where('name', $employ_id)->first();
        $leave->status = '2';
        $leave->update();

        if ($leave->status == '2') {
            $date_diff = (date('j', strtotime($leave->to_date) - strtotime($leave->from_date)));
            $days = ($date_diff);
            $leaveDedection = LeaveAllocation::where('user_id', $leave->name)->first();

            if ($leave->leave_type == '1' || $leave->leave_type == '9') {
                if ($leave->from_sessions == '2' && $leave->to_sessions == '2') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '2') {
                    $session_deduct = 0;
                } elseif ($leave->from_sessions == '2' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                }
                $leaveDedection->casual_leave = $leaveDedection->casual_leave - ($days - $session_deduct);
                $leaveDedection->emergency_leave = $leaveDedection->emergency_leave - ($days - $session_deduct);
            } elseif ($leave->leave_type == '2') {
                if ($leave->from_sessions == '2' && $leave->to_sessions == '2') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '2') {
                    $session_deduct = 0;
                } elseif ($leave->from_sessions == '2' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                }
                $leaveDedection->sick_leave = $leaveDedection->sick_leave - ($days - $session_deduct);
            } elseif ($leave->leave_type == '5') {
                if ($leave->from_sessions == '2' && $leave->to_sessions == '2') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '2') {
                    $session_deduct = 0;
                } elseif ($leave->from_sessions == '2' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                }
                $leaveDedection->comp_off = $leaveDedection->comp_off - ($days - $session_deduct);
            } elseif ($leave->leave_type == '6') {
                if ($leave->from_sessions == '2' && $leave->to_sessions == '2') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '2') {
                    $session_deduct = 0;
                } elseif ($leave->from_sessions == '2' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                }
                $leaveDedection->bereavement_leave = $leaveDedection->bereavement_leave - ($days - $session_deduct);
            } elseif ($leave->leave_type == '7') {
                if ($leave->from_sessions == '2' && $leave->to_sessions == '2') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '2') {
                    $session_deduct = 0;
                } elseif ($leave->from_sessions == '2' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                }
                $leaveDedection->maternity_leave = $leaveDedection->maternity_leave - ($days - $session_deduct);
            } elseif ($leave->leave_type == '8') {
                if ($leave->from_sessions == '2' && $leave->to_sessions == '2') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '2') {
                    $session_deduct = 0;
                } elseif ($leave->from_sessions == '2' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                }
                $leaveDedection->paternity_leave = $leaveDedection->paternity_leave - ($days - $session_deduct);
            } elseif ($leave->leave_type == '3') {
                if ($leave->from_sessions == '2' && $leave->to_sessions == '2') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '2') {
                    $session_deduct = 0;
                } elseif ($leave->from_sessions == '2' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                }
                $leaveDedection->earned_leave = $leaveDedection->earned_leave - ($days - $session_deduct);
            } elseif ($leave->leave_type == '4') {
                if ($leave->from_sessions == '2' && $leave->to_sessions == '2') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                } elseif ($leave->from_sessions == '1' && $leave->to_sessions == '2') {
                    $session_deduct = 0;
                } elseif ($leave->from_sessions == '2' && $leave->to_sessions == '1') {
                    $session_deduct = 0.5;
                }
                $leaveDedection->loss_of_pay_leave = $leaveDedection->loss_of_pay_leave - ($days - $session_deduct);
            }
            $leaveDedection->update();
        }
        if ($leave->leave_type !== '5') {
            $user = User::where('_id', $leave->name)->first();
            $name = $user->first_name . ' ' . $user->last_name;
            $user_mail = $user->email;
            $leave_status = $leave->status;
            if ($leave_status == '2') {
                $leave_status = 'Approved';
            } elseif ($leave_status == '3') {
                $leave_status = 'Rejected';
            }
            $leaveBalanced = LeaveAllocation::where('user_id', $leave->name)->first();

            Mail::send('emails.approvedLeave', [
                'name' => $name,
                'leave_type' => $leave->leave_type,
                'reason' => $leave->reason,
                'from_date' => $leave->from_date,
                'to_date' => $leave->to_date,
                'employe_code' => $user->employee_id,
                'from_session' => $leave->from_sessions,
                'to_session' => $leave->to_sessions,
                'number_of_days' => (date('d', strtotime($leave->to_date) - strtotime($leave->from_date))),
                'leave_status' => $leave->status,
                'leaveBalanced' => $leaveBalanced
            ], function ($user) use ($name, $leave_status, $user_mail) {
                $user->to($user_mail);
                $user->subject('Leave request has been' . ' ' . $leave_status);
            });
        }
        return redirect()->to('/leaves');
    }
}
