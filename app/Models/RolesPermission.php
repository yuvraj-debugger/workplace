<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class RolesPermission extends Model
{
    use HasFactory,ModelLog;

    protected $table = "roles_permissions";

    protected $tagName = 'roles permissions';

    protected $fillable = [
        'user_id',
        'permission_type',
        'permission_id',
        'role_id',
        'status',
        'type',
        'created_by'
    ];

    // public static function userpermissions($pannel_name,$type, $module_name = ''){

    // if($type==0){
    // $permissions=Module::where('name',$pannel_name)->first();
    // if(!empty($permissions)){

    // $permissions_data=RolesPermission::where('permission_id',$permissions->_id)->where('permission_type',1)->where('user_id',Auth::user()->_id)->first();

    // if(!empty($permissions_data)&&!empty($permissions_data->status==1))
    // {
    // return true;
    // }
    // }
    // }else if($type==1){
    // $module_id = Module::where('name',$module_name)->value('_id');

    // $permissions=Submodule::where('module_id', $module_id)->where('name',$pannel_name)->first();

    // if(!empty($permissions)){
    // $permissions_data=RolesPermission::where('permission_id',$permissions->_id)->where('permission_type',2)->where('user_id',Auth::user()->_id)->first();
    // // return $permissions_data['_id'];
    // if(!empty($permissions_data)&&$permissions_data->status==1)
    // {
    // return true;
    // }
    // }
    // }else if ($type==2){
    // $permissions=ModuleFunction::where('name',$pannel_name)->first();
    // if(!empty($permissions))
    // {
    // $permissions_data=RolesPermission::where('permission_id',$permissions->_id)->where('permission_type',3)->where('user_id',Auth::user()->_id)->first();
    // if(!empty($permissions_data)&&!empty($permissions_data->status==1))
    // {
    // return true;
    // }
    // }
    // }
    // return false;
    // }
    public static function userpermissions($pannel_name, $type)
    {
        if ($type == 0) {
            $permissions = Module::where('name', $pannel_name)->first();

            if (! empty($permissions)) {
                $permissions_data = RolesPermission::where('permission_id', $permissions->_id)->where('permission_type', 1)
                    ->where('user_id', Auth::user()->_id)
                    ->first();
                if (! empty($permissions_data) && ! empty($permissions_data->status == 1)) {
                    return true;
                }
            }
        } else if ($type == 1) {
            $permissions = Submodule::where('name', $pannel_name)->first();
            if (! empty($permissions)) {
                $permissions_data = RolesPermission::where('permission_id', $permissions->_id)->where('permission_type', 2)
                    ->where('user_id', Auth::user()->_id)
                    ->first();
                if (! empty($permissions_data) && ! empty($permissions_data->status == 1)) {
                    return true;
                }
            }
        } else if ($type == 2) {
            $permissions = ModuleFunction::where('name', $pannel_name)->first();
            if (! empty($permissions)) {
                $permissions_data = RolesPermission::where('permission_id', $permissions->_id)->where('permission_type', 3)
                    ->where('user_id', Auth::user()->_id)
                    ->first();
                if (! empty($permissions_data) && ! empty($permissions_data->status == 1)) {
                    return true;
                }
            }
        }
        return false;
    }
}
