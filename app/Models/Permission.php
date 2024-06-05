<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class Permission extends Model
{
    use HasFactory,ModelLog;

    protected $table = "permissions";

    protected $tagName = 'permissions';

    protected $fillable = [
        'permission_type',
        'permission_id',
        'role_id',
        'status',
        'type',
        'created_by'
    ];

    public static function userpermissions($pannel_name, $type, $subModule = null)
    {
        if ($type == 0) {
            $permissions = Module::where('name', $pannel_name)->first();

            if (! empty($permissions)) {
                $permissions_data = Permission::where('permission_id', $permissions->_id)->where('role_id', Auth::user()->user_role)
                    ->where('permission_type', 1)
                    ->first();
                if (! empty($permissions_data) && ! empty($permissions_data->status == 1)) {
                    return true;
                }
            }
        } else if ($type == 1) {

            $permissions = Submodule::where('name', $pannel_name)->first();

            if (! empty($permissions)) {

                $permissions_data = Permission::where('permission_id', $permissions->_id)->where('permission_type', 2)
                    ->where('role_id', Auth::user()->user_role)
                    ->first();
                if (! empty($permissions_data) && ! empty($permissions_data->status == 1)) {
                    return true;
                }
            }
        } else if ($type == 2) {

            $sub_permissions = Submodule::where('name', $subModule)->first();

            if (! empty($sub_permissions)) {
                $permissions = ModuleFunction::where('name', $pannel_name)->where('sub_module_id', $sub_permissions->_id)->first();
                if (! empty($permissions)) {
                    $permissions_data = Permission::where('permission_id', $permissions->_id)->where('role_id', Auth::user()->user_role)->first();
                    if (! empty($permissions_data) && ! empty($permissions_data->status == 1)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
