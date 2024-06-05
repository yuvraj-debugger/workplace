<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class Module extends Model
{
    use HasFactory,ModelLog;

    protected $table = "modules";

    protected $tagName = 'modules';
    
    protected $fillable = [

        'name',
        'status',
        'type',
        'created_by'
    ];

    public function submodulesData()
    {
        return $this->hasMany(Submodule::class);

        // return Submodule::where('module_id',$module_id)->get();
    }

    public function moduleSelected($module_id, $permission_type, $status, $role_id)
    {
        return $permission = Permission::where('permission_id', $module_id)->where('role_id', $role_id)
            ->where('permission_type', $permission_type)
            ->value('status');
    }
}
