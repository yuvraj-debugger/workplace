<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class Submodule extends Model
{
    use HasFactory,ModelLog;

    protected $table = "sub_modules";

    protected $tagName = 'sub modules';

    protected $fillable = [
        'name',
        'module_id',
        'status',
        'type',
        'created_by'
    ];

    public function modulefunctionsData($sub_module_id)
    {
        return ModuleFunction::where('sub_module_id', $sub_module_id)->get();
    }

    public function moduleSelected($module_id, $permission_type, $status, $role_id)
    {
        return Permission::where('permission_id', $module_id)->where('role_id', $role_id)
            ->where('permission_type', $permission_type)
            ->value('status');
    }

    public static function moduleValue($module_id, $role_id, $permission_type)
    {
        $permission = Permission::where('permission_id', $module_id)->where('permission_type', $permission_type)
            ->where('role_id', $role_id)
            ->first();

        if (! empty($permission) && ($permission->status == 1)) {
            return true;
        }
        return false;
    }
}