<?php
  
use Carbon\Carbon;
use App\Models\Submodule;
use App\Models\ModuleFunction;
use App\Models\Permission;
use App\Models\RolesPermission;
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('test')) {
    function getSubAccounts($id)
    {
        return Accounts::where('parent_account_name', $id)->pluck('name', '_id')->toArray();
    }
}
if (! function_exists('getsubmodules')) {

function getsubmodules($module_id){
        return $sub= Submodule::where('module_id',$module_id)->pluck('name', '_id');
    }
}
if (! function_exists('moduleSelected')) {

 function moduleSelected($module_id, $permission_type,$status,$role_id)
    {
        // return $role_id;
        return $permission=Permission::where('permission_id',$module_id)->where('role_id',$role_id)->where('permission_type',$permission_type)->value('status');
}
}
if (! function_exists('empModuleSelected')) {

    function empModuleSelected($module_id, $permission_type,$status,$user_id)
    {
        return $permission=RolesPermission::where('permission_id',$module_id)->where('user_id',$user_id)->where('permission_type',$permission_type)->value('status');
    }
}
if (! function_exists('getmodulefunction')) {

function getmodulefunction($sub_module_id){
        return $function= ModuleFunction::where('sub_module_id',$sub_module_id)->pluck('name', '_id');  
    }
}
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertMdyToYmd')) {
    function convertMdyToYmd($date)
    {
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
}