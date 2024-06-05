<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ModuleFunction extends Model
{
    use HasFactory;
    protected $table="modules_functions";
    protected $fillable = [
      
        'name',
        'module_id',
        'sub_module_id',
        'status',
        'type',  
        'created_by',
    ];

    public function submodule()
    {
        return $this->belongsTo(Submodule::class);
    }

    public function moduleSelected($module_id, $permission_type,$status,$role_id)
    {
        return $permission=Permission::where('permission_id',$module_id)->where('role_id',$role_id)->where('permission_type',$permission_type)->value('status');
       
    }
}
