<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class EmployeeAddition extends Model
{
    use HasFactory;

    protected $table = 'employee_addition';

    protected $fillable = [
        'id',
        'salary_slip_id',
        'addition_id',
        'deduction_id',
        'name',
        'value'
    ];
    public function getEmployee()
    {
        $user = User::where('_id', $this->employee_id)->first();
        return ! empty($user) ? $user->first_name.' '.$user->last_name : '';
    }
    public function getEmployeeId()
    {
        $user = User::where('_id', $this->employee_id)->first();
        return ! empty($user) ? $user->employee_id : '';
    }
    public function getRemoveID()
    {
        $user = User::where('_id', $this->employee_id)->first();
        return ! empty($user) ? str_replace("SSPL", "", $user->employee_id ) : '';
    }
    public function getEmployeeJoiningDate()
    {
        $user = User::where('_id', $this->employee_id)->first();
        return ! empty($user) ? $user->joining_date : '';
    }
    public function getEmployeeDesignation()
    {
        $user = User::where('_id', $this->employee_id)->first();
        if(! empty($user)){
            $employeeDesignation = Employeedesignation::where('_id',$user->designation)->first();
        }
        return ! empty($employeeDesignation) ? $employeeDesignation->title : '';
    }
    public function getEmployeeRole()
    {
        $user = User::where('_id', $this->employee_id)->first();
        if(! empty($user)){
            $userRole = Role::where('_id',$user->user_role)->first();
        }
        return ! empty($userRole) ? $userRole->name : '';
    }
}
