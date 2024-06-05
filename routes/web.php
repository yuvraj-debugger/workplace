<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;
use App\Http\Livewire\RolesPermissions;
use App\Http\Livewire\Holidays;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmployeeShiftController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\MasterLeaveController;
use App\Http\Controllers\UserActivitiesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/download/{filename}', function ($filename) {
    $file = Storage::disk(config('filesystems.default'))->get('employee_document/'.$filename );
    $headers = [
        'Content-Type' => 'application/pdf',
        'Content-Description' => 'File Transfer',
        'Content-Disposition' => "attachment; filename={$filename}",

    ];

    return response($file, 200, $headers);
});
    

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
    
    Route::get('/employee-seperate-out', function () {
        $heading = 'Employee Seperate Out';
        return view('admin.coming-soon',compact('heading'));
    })->name('employee-seperate-out');
    
    Route::get('/reporting-structure', function () {
        $heading = 'Reporting Structure';
        return view('admin.coming-soon',compact('heading'));
    })->name('reporting-structure');
    
    Route::get('/mass-communication', function () {
        $heading = 'Mass Communication';
        return view('admin.coming-soon',compact('heading'));
    })->name('mass-communication');
    
    Route::get('/leaves-settings', function () {
        $heading = 'Leaves Settings';
        return view('admin.coming-soon',compact('heading'));
    })->name('admin.leavesetting');


//     Route::any('/employee', [AdminController::class, 'employee'])->name('admin.employee');
    Route::get('/employee-list', [AdminController::class, 'employeelist'])->name('admin.employee-list');
    Route::get('/profile/{employee_id}', [AdminController::class, 'profile'])->name('profile');
    Route::any('/leaves', [LeaveController::class, 'adminleaves'])->name('leaves');
    Route::any('/leaveDelete', [LeaveController::class, 'leaveDelete'])->name('leaveDelete');
    Route::any('/addLeave', [LeaveController::class, 'addLeave'])->name('addLeave');
    Route::any('/editLeave', [LeaveController::class, 'editLeave'])->name('editLeave');
    Route::any('/updateLeave/{leave_id}/{employ_id}', [LeaveController::class, 'updateLeave'])->name('updateLeave');
    Route::any('/rejectLeave/{leave_id}/{employ_id}',[LeaveController::class, 'rejectLeave'])->name('rejectLeave');
    Route::any('/singleDelete', [LeaveController::class, 'singleDelete'])->name('singleDelete');
    
    Route::any('/reason-view', [LeaveController::class, 'reasonView'])->name('reasonView');
    
    Route::any('/document-view', [EmployeeController::class, 'documentView'])->name('documentView');
    Route::any('/reason-extended', [LeaveController::class, 'extendedReason'])->name('extendedReason');
    
    
    
    
    
    
    
    
    
    Route::any('/employee-leaves', [AdminController::class, 'employeeleaves'])->name('admin.employeeleaves');
    Route::any('/leaves-settings-ui', [AdminController::class, 'leavesetting'])->name('admin.leavesettingui');
    Route::any('/holidays', [HolidayController::class, 'holidays'])->name('admin.holidays');
    Route::any('/add-holidays', [HolidayController::class, 'addHoliday'])->name('addHoliday');
    Route::any('/edit-holidays', [HolidayController::class, 'editHoliday'])->name('editHoliday');
    Route::any('/updated-holidays', [HolidayController::class, 'updateHoliday'])->name('updateHoliday');
    Route::any('/delete-holidays', [HolidayController::class, 'holidayDelete'])->name('holidayDelete');
    
    Route::any('/multiple-delete', [HolidayController::class, 'MultipleDelete'])->name('multipleDelete');
    
    
    
    
    
    
    
    Route::any('/allDelete', [RolesPermissions::class, 'allDelete']);
    Route::any('/allHoliday', [Holidays::class, 'allHoliday']);
    Route::any('/allAttendance', [Holidays::class, 'allAttendance']);
    
    Route::any('/permisisonUpdate', [AdminController::class, 'permisisonUpdate'])->name('permisisonUpdate');
    Route::any('/funPermissionUpdate', [AdminController::class, 'funPermissionUpdate'])->name('funPermissionUpdate');
    Route::any('/editEmployee', [AdminController::class, 'editEmployee'])->name('editEmployee');
    Route::any('/addRole', [RolePermissionController::class, 'addRole'])->name('addRole');
    Route::any('/updateRole', [RolePermissionController::class, 'updateRole'])->name('updateRole');
    Route::any('/deleteRole', [RolePermissionController::class, 'deleteRole'])->name('deleteRole');
    Route::any('/rules/{id}', [RolePermissionController::class, 'getRules'])->name('getRule');
    
    
    /* Employee Module Start */
    Route::any('/employee', [EmployeeController::class, 'employee'])->name('admin.employee');
    Route::any('/employee/add', [EmployeeController::class, 'addEmployee'])->name('addEmployee');
    Route::any('/employee/create', [EmployeeController::class, 'employeeCreate'])->name('employeeCreate');
    Route::any('/employee/update/{id}', [EmployeeController::class,'employeeUpdate'])->name('employeeUpdate');
    Route::any('/employee/updated', [EmployeeController::class,'employeeUpdated'])->name('employeeUpdated');
    Route::any('/employee/delete', [EmployeeController::class,'userDelete'])->name('userDelete');
    Route::any('/employee/export/', [EmployeeController::class,'employeeExport'])->name('employeeExport');
    
    Route::any('/remove/photo/{id}', [EmployeeController::class,'removePhoto'])->name('removePhoto');
    
    
    Route::any('/employee-inactive', [EmployeeController::class, 'userInactive'])->name('userInactive');
    
    
    
    /* user view profile section */
    Route::any('/employee-profile/{employee_id}', [EmployeeController::class, 'employeeProfile'])->name('employeeProfile');
    
    Route::any('/personal-information/{employee_id}', [EmployeeController::class,'personalInformation'])->name('personalInformation');
    
    Route::any('/add-personalInformation', [EmployeeController::class, 'addPersonalInformation'])->name('addPersonalInformation');
    
    Route::any('/delete-countries', [EmployeeController::class,'allCountries'])->name('allCountries');
    
    Route::any('/add-emergency', [EmployeeController::class,'addEmergency'])->name('addEmergency');
    
    Route::any('/edit-emergency', [EmployeeController::class,'editEmergency'])->name('editEmergency');
    
    Route::any('/update-emergency', [EmployeeController::class,'updateEmergency'])->name('updateEmergency');
    
    
    Route::any('/delete-emergency', [EmployeeController::class,'contactDelete'])->name('contactDelete');
    Route::any('/edit-joining', [EmployeeController::class,'editJoining'])->name('editJoining');
    Route::any('/edit-official', [EmployeeController::class,'editOfficialContact'])->name('editOfficialContact');
    Route::any('/add-official', [EmployeeController::class,'addOfficialcontact'])->name('addOfficialcontact');
    Route::any('/add-family', [EmployeeController::class,'addFamilyInformation'])->name('addFamilyInformation');
    Route::any('/edit-family', [EmployeeController::class,'editFamily'])->name('editFamily');
    Route::any('/updated-family', [EmployeeController::class,'updateFamilyInformation'])->name('updateFamilyInformation');
    Route::any('/delete-family', [EmployeeController::class,'familyDelete'])->name('familyDelete');
    
    Route::any('/add-education', [EmployeeController::class,'addEducationDetails'])->name('addEducationDetails');
    
    Route::any('/edit-education', [EmployeeController::class,'editEmployeeEducation'])->name('editEmployeeEducation');
    
    Route::any('/update-education', [EmployeeController::class,'updateEducationDetails'])->name('updateEducationDetails');
    
    Route::any('/delete-education', [EmployeeController::class,'educationDelete'])->name('educationDelete');
    
    Route::any('/updated-education', [EmployeeController::class,'updatedDocuments'])->name('updatedDocuments');
    
    
    
    Route::any('/add-joining', [EmployeeController::class,'addJoining'])->name('addJoining');
    
    Route::any('/add-skill', [EmployeeController::class, 'addSkills'])->name('addSkills');
    Route::any('/edit-skill', [EmployeeController::class, 'editSkills'])->name('editSkills');
    
    Route::any('/updated-skill', [EmployeeController::class, 'updatedSkills'])->name('updatedSkills');
    
    Route::any('/delete-skill', [EmployeeController::class, 'skillDelete'])->name('skillDelete');
    
    Route::any('/add-bank', [EmployeeController::class, 'addBankInfo'])->name('addBankInfo');
    
    Route::any('/experience-information/{employee_id}', [EmployeeController::class,'experienceInformation'])->name('experienceInformation');
    
    Route::any('/add-experience', [EmployeeController::class, 'addExperience'])->name('addExperience');
    
    Route::any('/edit-experience-information/{employee_id}/{user_id}', [EmployeeController::class,'editExperience'])->name('editExperience');
    
    Route::any('/update-experience', [EmployeeController::class,'updatedExperienced'])->name('updatedExperienced');
    Route::any('/delete-experience', [EmployeeController::class,'deleteExperience'])->name('deleteExperience');
    Route::any('/edit-addition', [EmployeeController::class,'editAdditionData'])->name('editAdditionData');
    
    
    Route::any('/add-addition', [EmployeeController::class,'updatedAddition'])->name('updatedAddition');
    
    Route::any('/add-documents', [EmployeeController::class,'uploadDocuments'])->name('uploadDocuments');
    
    Route::any('/delete-documents', [EmployeeController::class,'deleteDocument'])->name('deleteDocument');
    
    
    Route::any('/edit-documents', [EmployeeController::class,'editEmployeeDocument'])->name('editEmployeeDocument');
    
    
    
    
    Route::any('/bank-statutory/{employee_id}', [EmployeeController::class,'bankStatutory'])->name('bankStatutory');
    Route::any('/bank-statutory-add', [EmployeeController::class,'addbankstatutory'])->name('addbankstatutory');
    
    Route::any('/edit-bank-info', [EmployeeController::class,'editBankInfo'])->name('editBankInfo');
    
    
    
    
    /* end here */
    
    
    Route::any('/myleaves', [LeaveController::class,'myleaves'])->name('myleaves');
    Route::any('/selfleaves', [LeaveController::class,'myleavesUpdate'])->name('selfleaves');
    Route::any('/editMyLeave', [LeaveController::class,'editMyLeave'])->name('editMyLeave');
    Route::any('/updateMyLeave', [LeaveController::class,'updateMyLeave'])->name('updateMyLeave');
    Route::any('/myDelete', [LeaveController::class,'myDelete'])->name('myDelete');
    Route::any('/leave-balances/{id?}', [LeaveController::class,'leaveBalanced'])->name('leaveBalances');
    Route::any('/employee-leave-balances', [LeaveController::class,'employeeLeaveBalanced'])->name('employeeLeaveBalances');
    
    
    Route::any('/leave-grant', [LeaveController::class,'compOff'])->name('compOff');
    Route::any('/employee-leave-grant', [LeaveController::class,'employeeCompOff'])->name('employeeCompOff');
    
    Route::any('/leave-grant-add', [LeaveController::class,'addCompoff'])->name('addCompoff');
    Route::any('/employee-comp-off', [LeaveController::class,'employeeCompoff'])->name('employeeCompoff');
    
    Route::any('/my-employee-comp-off', [LeaveController::class,'MyemployeeCompoff'])->name('MyemployeeCompoff');
    
    Route::any('/my-employee-comp-off-update', [LeaveController::class,'updateMyEmployeeCompOff'])->name('updateMyEmployeeCompOff');
    
    Route::any('/employee-comp-off-edit', [LeaveController::class,'editEmployeeComp'])->name('editEmployeeComp');
    
    Route::any('/my-employee-comp-off-edit', [LeaveController::class,'editMyEmployeeComp'])->name('editMyEmployeeComp');
    
    
    
    
    
    Route::any('/employee-comp-off-delete', [LeaveController::class,'deleteComp'])->name('deleteComp');
    
    Route::any('/my-employee-comp-off-delete', [LeaveController::class,'deleteEmployeeCompOff'])->name('deleteEmployeeCompOff');
    
    
    
    Route::any('/employee-comp-off-updated', [LeaveController::class,'updateCompOff'])->name('updateCompOff');
    
    Route::any('/employee-comp-off-all-deleted', [LeaveController::class,'allCompOffDelete'])->name('allCompOffDelete');
    
    
    Route::any('/add-comp-employee', [LeaveController::class,'addEmployeeComp'])->name('addEmployeeComp');
    
    
    
    
    
    /* End here */
    
    Route::any('/employee-attendance', [AttendanceController::class, 'adminattendance'])->name('admin.adminattendance');
    Route::any('/attendance/add', [AttendanceController::class, 'attendanceAdd'])->name('attendanceAdd');
    Route::any('/attendance/edit', [AttendanceController::class, 'editAttendance'])->name('editAttendance');
    Route::any('/attendance/update', [AttendanceController::class, 'updateAttendance'])->name('updateAttendance');
    Route::any('/ajax-attendance', [AttendanceController::class, 'ajaxAttendance'])->name('ajaxAttendance');
    
    
    /* 
    Route::any('/admin-attendance', [AdminController::class, 'adminattendance'])->name('admin.adminattendance'); */
    Route::any('/hr-attendance', [AttendanceController::class, 'hrattendance'])->name('admin.hrattendance');
    Route::any('/management-attendance', [AttendanceController::class, 'managementattendance'])->name('admin.managementattendance');
    Route::any('/my-attendance', [AttendanceController::class, 'myAttendance'])->name('admin.myAttendance');
    Route::any('/attendance-activity', [AttendanceController::class, 'attendanceActivity'])->name('admin.attendanceActivity');
    Route::any('/attendance-report', [AttendanceController::class, 'attendanceReport'])->name('admin.attendancereport');
    Route::any('/download-attendance', [AttendanceController::class, 'exportAttendance'])->name('exportAttendance');
    
    
    Route::any('/admin-whoisin', [AdminController::class, 'whoisin'])->name('admin.whoisin');
    Route::any('/employee-designation', [AdminController::class, 'employeedesignation'])->name('admin.employee-designation');
    Route::any('/employee-department', [AdminController::class, 'employeedepartment'])->name('admin.employee-department');
    Route::any('/roles-permissions', [AdminController::class, 'rolespermissions'])->name('admin.roles-permissions');
    Route::any('/profile-permissions/{employee_id}', [AdminController::class, 'profilepermissions'])->name('admin.profile-permissions');
 

//     Route::any('/employee-attendance', [AdminController::class, 'employeeattendance'])->name('admin.employeeattendance');
    
    Route::any('/blood-group', [SettingController::class, 'bloodGroupAdd'])->name('admin.bloodGroupAdd');
    Route::any('/blood-add', [SettingController::class, 'addBlood'])->name('addBlood');
    Route::any('/blood-edit', [SettingController::class, 'editBlood'])->name('editBlood');
    Route::any('/blood-update', [SettingController::class, 'updateBlood'])->name('updateBlood');
    Route::any('/blood-delete', [SettingController::class, 'bloodDelete'])->name('bloodDelete');
    Route::any('/multiple-delete-blood', [SettingController::class, 'multipleDeleteBlood'])->name('multipleDeleteBlood');
    
    Route::any('/document-index', [SettingController::class, 'documentIndex'])->name('admin.documentIndex');
    Route::any('/document-add', [SettingController::class, 'documentAdd'])->name('documentAdd');
    Route::any('/document-edit', [SettingController::class, 'documentEdit'])->name('editDocument');
    Route::any('/document-update', [SettingController::class, 'updateDocument'])->name('updateDocument');
    Route::any('/document-delete', [SettingController::class, 'documentDelete'])->name('documentDelete');
    Route::any('/document-delete-multiple', [SettingController::class, 'multipleDeleteDocument'])->name('multipleDeleteDocument');
    
    
    
    Route::any('/degree-index', [SettingController::class, 'degreeeIndex'])->name('admin.degreeIndex');
    Route::any('/degree-add', [SettingController::class, 'addDegree'])->name('addDegree');
    Route::any('/degree-edit', [SettingController::class, 'editDegree'])->name('editDegree');
    Route::any('/degree-update', [SettingController::class, 'updatedDegree'])->name('updatedDegree');
    Route::any('/degree-delete', [SettingController::class, 'degreeDelete'])->name('degreeDelete');
    Route::any('/degree-delete-multiple', [SettingController::class, 'multipleDeleteDegree'])->name('multipleDeleteDegree');
    
    
    
    
    /* Employee Shift */
    Route::any('/employee-shift', [EmployeeShiftController::class, 'employeeShift'])->name('admin.employeeShift');
    Route::any('/employee-shift-add', [EmployeeShiftController::class, 'addEmployeeShift'])->name('addEmployeeShift');
    Route::any('/employee-shift-edit', [EmployeeShiftController::class, 'editEmployeeShift'])->name('editEmployeeShift');
    Route::any('/employee-shift-update', [EmployeeShiftController::class, 'updateEmployeeShift'])->name('updateEmployeeShift');
    Route::any('/employee-shift-delete', [EmployeeShiftController::class, 'shiftDelete'])->name('shiftDelete');
    
    Route::any('/multiple-delete-shift', [EmployeeShiftController::class, 'multipleDeleteShift'])->name('multipleDeleteShift');
    
    
    
    
    Route::any('/ajax-shifts', [EmployeeShiftController::class, 'ajaxShift'])->name('ajaxShift');
    
    Route::any('/add-shit-schedule', [EmployeeShiftController::class, 'addScheduleShift'])->name('addScheduleShift');
    
    Route::any('/employee-schedule', [ScheduleController::class, 'employeeSchedule'])->name('admin.employeeSchedule');
    
    Route::any('/ajax-schedule', [ScheduleController::class, 'ajaxSchedule'])->name('ajaxSchedule');
    
    Route::any('/add-schedule', [ScheduleController::class, 'addSchedule'])->name('addSchedule');
    
    Route::any('/assign-schedule', [ScheduleController::class, 'assignSchedule'])->name('assignSchedule');
    
    Route::any('/assign-ajax-shifts', [ScheduleController::class, 'assignajaxShift'])->name('assignajaxShift');
    
    Route::any('/assign-add-schedule', [ScheduleController::class, 'assignaddSchedule'])->name('assignaddSchedule');
    
    Route::any('/policy-index', [PolicyController::class, 'index'])->name('admin.policymanagement');
    
    Route::any('/policy-add', [PolicyController::class, 'addPolicy'])->name('addPolicy');
    
    Route::any('/policy-create', [PolicyController::class, 'createPolicy'])->name('createPolicy');
    
    Route::any('/policy/update/{id}', [PolicyController::class, 'updatePolicy'])->name('updatePolicy');
    
    Route::any('/policy/view/{id}', [PolicyController::class, 'viewPolicy'])->name('viewPolicy');
    
    
    Route::any('/policy/updated', [PolicyController::class, 'updatedPolicy'])->name('updatePolicy');
    
    Route::any('/policy-delete', [PolicyController::class, 'policyDelete'])->name('policyDelete');
    
    Route::any('/ckeditor-upload', [PolicyController::class, 'ckeditorUpload'])->name('ckeditorUpload');
    
    Route::any('/updateckeditor-upload', [PolicyController::class, 'updateckeditorUpload'])->name('updateckeditorUpload');
    
    Route::any('/assign-employee', [EmployeeShiftController::class, 'assignEmployee'])->name('assignEmployee');
    
//     Route::any('/delete-db', [ScheduleController::class, 'deleteDb']);
    
    Route::any('/duplicate-role', [RolePermissionController::class, 'duplicateRole'])->name('duplicateRole');
    
    Route::any('/get-submodule/{submodule_id}', [RolePermissionController::class, 'getSubModule']);
    
    Route::any('/get-module-function/{sub_id}/{module_id}', [RolePermissionController::class, 'getmoduleFunction']);
    
    Route::any('/assign-module-function', [RolePermissionController::class, 'assignModuleFunction'])->name('assignModuleFunction');
    
    Route::any('/add-module-function', [RolePermissionController::class, 'addModuleFunction'])->name('addModuleFunction');
    
    
    Route::any('/confetti', [EmployeeController::class, 'confetti'])->name('confetti');
    
    
    Route::any('/payroll-index', [PayrollController::class, 'index'])->name('admin.payroll');
    
    Route::any('/add-addtion', [PayrollController::class, 'addPayrollAddition'])->name('addPayrollAddition');
    
    Route::any('/edit-addtion', [PayrollController::class, 'editPayrollAddition'])->name('editPayrollAddition');
    
    Route::any('/update-addtion', [PayrollController::class, 'updatePayrollAddition'])->name('updatePayrollAddition');
    
    Route::any('/delete-addtion', [PayrollController::class, 'additionDelete'])->name('additionDelete');
    
    Route::any('/add-overtime', [PayrollController::class, 'addPayrollOvertime'])->name('addPayrollOvertime');
    
    Route::any('/edit-overtime', [PayrollController::class, 'editPayrollOvertime'])->name('editPayrollOvertime');
    
    Route::any('/update-overtime', [PayrollController::class, 'updatePayrollOvertime'])->name('updatePayrollOvertime');
    
    Route::any('/delete-overtime', [PayrollController::class, 'overtimeDelete'])->name('overtimeDelete');
    
    Route::any('/add-deduction', [PayrollController::class, 'addPayrollDeductions'])->name('addPayrollDeductions');
    
    Route::any('/edit-deduction', [PayrollController::class, 'editPayrollDeduction'])->name('editPayrollDeduction');
    
    Route::any('/update-deduction', [PayrollController::class, 'updatePayrollDeduction'])->name('updatePayrollDeduction');
    
    Route::any('/delete-deduction', [PayrollController::class, 'deductionDelete'])->name('deductionDelete');
    
    Route::any('/employee-salary-index', [SalaryController::class, 'index'])->name('admin.employeeSalary');
    
    Route::any('/employee-salary-add', [SalaryController::class, 'addSalary'])->name('addSalary');
    
    Route::any('/employee-salary-create', [SalaryController::class, 'salaryCreate'])->name('salaryCreate');
    
    Route::any('/get-net-salary', [SalaryController::class, 'getNetSalary'])->name('getNetSalary');
    
    Route::any('/get-deduction', [SalaryController::class, 'getDeduction'])->name('getDeduction');
    
    Route::any('/get-employee-addition', [SalaryController::class, 'getAdditionEmployee'])->name('getAdditionEmployee');
    
    Route::any('/get-employee-deduction', [SalaryController::class, 'getEmployeeDeduction'])->name('getEmployeeDeduction');
    
    Route::any('/salary/edit/{id}', [SalaryController::class, 'salaryEdit'])->name('salaryEdit');
    
    
    Route::any('/salary-updated', [SalaryController::class, 'salaryUpdate'])->name('salaryUpdate');
    
    Route::any('/salary-delete', [SalaryController::class, 'salaryDelete'])->name('salaryDelete');
    
    Route::any('/salary-slip/{salary_id}', [SalaryController::class, 'generateSlip'])->name('salarySlip');
    
    Route::any('/genarate-pdf/{salary_id}', [SalaryController::class, 'generatePdf'])->name('generatePdf');
    
    
    
    
    Route::any('/salary/approve/{salary_id}', [SalaryController::class, 'approveStatus'])->name('generatePdf');
    
    
    Route::any('/master-leaves', [MasterLeaveController::class, 'masterLeaves'])->name(' admin.masterLeaves');
    
    Route::any('/master-leaves-index', [MasterLeaveController::class, 'masterLeaves'])->name('masterallLeaves');
    Route::any('/master-leaves-add', [MasterLeaveController::class, 'addmasterLeave'])->name('addmasterLeave');
    
    Route::any('/employee-probation', [EmployeeController::class, 'probationEmployee'])->name('admin.probationEmployee');
    
    Route::any('/rm/approve/{user_id}', [EmployeeController::class, 'rmApprove'])->name('rmApprove');
    
    Route::any('/hr/approve/{user_id}', [EmployeeController::class, 'hmApprove'])->name('hrApprove');
    
    
    Route::any('/add-rm-rejection', [EmployeeController::class, 'RMRejection'])->name('Rmrejection');
    
    Route::any('/add-rejection', [EmployeeController::class, 'HRRejection'])->name('Hrrejection');
    
    
    Route::get('/add-casual',function(){
        Artisan::call('command:casual-leave');
        return "Add casual successfully";
    });
        Route::get('/add-allocate',function(){
            Artisan::call('command:leave-allocation');
            return "Add leave successfully";
        });
        
        Route::get('/add-sick',function(){
            Artisan::call('command:sick-leave');
            return "Add sick successfully";
        });
        
    Route::any('/withdraw-leave/{leave_id}', [LeaveController::class, 'withdrawLeave'])->name('withdrawLeave');
    
    Route::any('/employee-leave-approve/{leave_id}/{employ_id}', [EmployeeController::class, 'LeaveApprove'])->name('LeaveApprove');
    
    
    Route::any('/user-activities', [UserActivitiesController::class, 'index'])->name('userActivities');
    
    Route::any('/read-message', [SettingController::class, 'readMessage'])->name('readMessage');
    
    Route::any('/get-notification', [SettingController::class, 'getNotification'])->name('getNotification');
    
    Route::any('/activity-details/{id}', [UserActivitiesController::class, 'getDetails']);
    
    
    
    
    
        // Your protected routes go here
    });
    
    
    
    
    
    
    
    
