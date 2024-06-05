<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Permission;
use App\Models\RolesPermission;
Use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Models\Role;
use App\Models\Module;
use App\Models\Submodule;
use App\Models\ModuleFunction;
use Illuminate\Support\Facades\Session;
use App\Models\Employeedesignation;
use App\Models\Employeedepartment;

class AdminController extends Controller
{
    public function addEmployee()
    {
        return view('admin.Employee.add-employee');
    }

    public function employee()
    {
        if ((FacadesAuth::user()->user_role == 0) || Permission::userpermissions('employees', 1) || RolesPermission::userpermissions('employees', 1)) {
            return view('admin.Employee.employee');
        } else {
            return redirect('/dashboard');
        }
    }

    public function profile($employee_id = '')
    {
        if ($employee_id != '') {
            $userDetail = User::where('_id', $employee_id)->first();
            if (empty($userDetail)) {
                return redirect('/employee');
            }
        }

        return view('admin.profile', compact('employee_id'));
    }


    public function employeeleaves()
    {
      
        return view('admin.Leaves.employee-leaves');
    }

    public function leavesetting()
    {
        return view('admin.Leaves.leaves-setting');
    }


    public function adminattendance()
    {
        return view('admin.Attendance.admin-attendance');
    }
    public function hrattendance()
    {
        $id=FacadesAuth::user()->_id;
        return view('admin.Attendance.admin-hrattendance',compact('id'));
    }
    
   
    public function whoisin()
    {
        return view('admin.Attendance.admin-whoisin');
    }

    public function employeeattendance()
    {
        return view('admin.Employee.employee-attendance');
    }

   

    public function employeedepartment()
    {
        if ((FacadesAuth::user()->user_role == 0) || (Permission::userpermissions('employee_department', 1) || RolesPermission::userpermissions('employee_department', 1))) {
            return view('admin.Employee.employee-department');
        } else {
            return redirect('/dashboard');
        }
    }
    public function employeedesignation()
    {
        if ((FacadesAuth::user()->user_role == 0) || (Permission::userpermissions('employee_designation', 1) || RolesPermission::userpermissions('employee_designation', 1))) {
            return view('admin.Employee.employee-designation');
        } else {
            return redirect('/dashboard');
        }
    }
    public function employeelist()
    {
        if ((FacadesAuth::user()->user_role == 0) || (Permission::userpermissions('list_view', 2, 'employees'))) {
            return view('admin.Employee.employee-list');
        } else {
            return redirect('/dashboard');
        }
    }

    public function rolespermissions()
    {
        $role=Role::where('_id',FacadesAuth::user()->user_role)->first();
        if ((FacadesAuth::user()->user_role == 0) || (! empty($role) &&  $role->name=="HR")) {
        return view('admin.roles-permisssions');
        }else {
            return redirect('/dashboard');
        }
    }

    public function profilepermissions($id)
    {
        return view('admin.profile-permissions', compact('id'));
    }

    public function forgot()
    {
        return view('auth.forgot-message');
    }

    public function permisisonUpdate(Request $request)
    {
        $permissions = Permission::where('permission_id', $request->subModule)->where('role_id', $request->roleId)
            ->where('permission_type', 2)
            ->first();
        if (! empty($permissions)) {
            if ($permissions->status == 1) {
                $value = 0;
            } else {
                $value = 1;
            }
            $permissions->status = $value;
            $permissions->update();
        } else {
            $permissions = new Permission();
            $permissions->status = 1;
            $permissions->permission_type = 2;
            $permissions->permission_id = $request->subModule;
            $permissions->role_id = $request->roleId;
            $permissions->created_by = FacadesAuth::user()->_id;
            $permissions->save();
        }
    }

    public function funPermissionUpdate(Request $request)
    {
        $permissions = Permission::where('permission_id', $request->funModule)->where('role_id', $request->roleId)
            ->where('permission_type', 3)
            ->first();

        if (! empty($permissions)) {
            if ($permissions->status == 1) {
                $value = 0;
            } else {
                $value = 1;
            }
            $permissions->status = $value;
            $permissions->update();
        } else {
            $permissions = new Permission();
            $permissions->status = 1;
            $permissions->permission_type = 3;
            $permissions->permission_id = $request->funModule;
            $permissions->role_id = $request->roleId;
            $permissions->created_by = FacadesAuth::user()->_id;
            $permissions->save();
        }
    }
    public function editEmployee(Request $request)
    {
            $userData = User::where('_id',$request->userId)->first();
            $employeeDesignation = Employeedesignation::where('_id',$userData->designation)->first();
            $employeeDepartment = Employeedepartment::where('_id',$userData->department)->first();
            $reportingManager = User::where('_id',$userData->reporting_manager)->first();
            $emplouyeRole = Role::where('_id',$userData->user_role)->first();
            if(! empty($userData)){
                $employee =[];
                $employee = new User();
                $employee->_id = $userData->_id;
                $employee->first_name = $userData->first_name;
                $employee->last_name = $userData->last_name;
                $employee->email = $userData->email;
                $employee->date_of_birth = $userData->date_of_birth;
                $employee->joining_date = $userData->joining_date;
                $employee->contact = $userData->contact;
                $employee->photo = $userData->photo;
                $employee->designation = ! empty($employeeDesignation) ? $employeeDesignation->title : '';
                $employee->designation_id = ! empty($employeeDesignation) ? $employeeDesignation->_id : '';
                $employee->department_id = ! empty($employeeDepartment) ? $employeeDepartment->_id : '';
                $employee->department = ! empty($employeeDepartment) ? $employeeDepartment->title : '';
                $employee->reporting_manager_id = ! empty($reportingManager) ? $reportingManager->_id:'';
                $employee->reporting_manager = ! empty($reportingManager) ? $reportingManager->first_name.' '.$reportingManager->last_name :'';
                $employee->app_login = $userData->app_login;
                $employee->employee_id = $userData->employee_id;
                $employee->email_notification = $userData->email_notification;
                $employee->workplace = $userData->workplace;
                $employee->status = $userData->status;
                $employee->user_role_id = ! empty($emplouyeRole) ? $emplouyeRole->_id :'';
                return $employee;
            }
         
    }
    
}
