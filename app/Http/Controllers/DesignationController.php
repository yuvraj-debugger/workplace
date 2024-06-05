<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;

class DesignationController extends Controller
{
    //
    public function employeedesignation()
    {
        if ((Auth::user()->user_role == 0) || (Permission::userpermissions('employee_designation', 1))) {
            return view('admin.designation.employee-designation');
        } else {
            return redirect('/dashboard');
        }
    }
}
