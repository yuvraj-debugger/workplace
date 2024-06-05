<?php
namespace App\Http\Livewire;

use App\Models\Module;
use App\Models\ModuleFunction;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolesPermission;
use App\Models\Submodule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RolesPermissions extends Component
{

    public $module_id;

    public $role_id;

    public $name;

    public $User_id;

    public $modulesData = [];

    public $functionsData = [];

    public $show = '0';

    public $status;

    protected $rules = [
        'name' => 'required'
    ];

    public function edit($user_id)
    {
        $this->resetValidation();
        $user = Role::where('_id', $user_id)->first();
        if (! empty($user)) {
            $this->User_id = $user->_id;
            $this->name = $user->name;
        }
    }

    public function render()
    {
        $roles = Role::get();
        $modules = Module::get();
        foreach($roles as $role)
        {
            $role->module=$modules;
            foreach($role->module as $module)
            {
                
                $module->submodule=Submodule::where('module_id',$module->_id)->get();
                
                foreach ($module->submodule as $submodule)
                {
                    $submodule->selected=$this->moduleSelected($submodule->_id,2,1,$role->_id);
                    $submodule->functions=ModuleFunction::where('sub_module_id',$submodule->_id)->get();
                }
            }
        }
        
        return view('livewire.roles-permissions', compact('modules', 'roles'));
    }

    public function getsubmodules($module_id)
    {
        return Submodule::where('module_id', $module_id)->pluck('name', '_id');
    }

    public function moduleData($role_id)
    {
        if (empty($this->modulesData)) {
            $this->modulesData = Module::pluck('name', '_id');
        }
    }

    public function functionData($submodule_id)
    {
        $functionsData = ModuleFunction::where('sub_module_id', $submodule_id)->pluck('name', '_id');
        return $functionsData;
    }

    public function modulepermissions($module_id, $value, $role_id)
    {
        $permissions = Permission::where('permission_id', $module_id)->where('role_id', $role_id)
            ->where('permission_type', 1)
            ->first();

        if (! empty($permissions)) {
            if ($permissions['status'] == '1') {
                $value = '0';
            } else {
                $value = '1';
            }
            $permissions->status = $value;
            $permissions->update();

            if (! empty($this->getsubmodules($module_id))) {
                foreach ($this->getsubmodules($module_id) as $key => $submodule) {
                    $subpermission = Permission::where('permission_id', $key)->where('role_id', $role_id)
                        ->where('permission_type', 2)
                        ->first();
                    if (empty($subpermission)) {
                        $Subpermissions = new Permission();
                        $Subpermissions->status = '1';
                        $Subpermissions->permission_type = 2;
                        $Subpermissions->permission_id = $key;
                        $Subpermissions->role_id = $role_id;
                        $Subpermissions->created_by = Auth::user()->id;
                        $Subpermissions->save();
                    }
                }
            }

            Permission::whereIn('permission_id', array_keys($this->getsubmodules($module_id)->toArray()))->update([
                'status' => $value
            ]);
        } else {
            $permissions = new Permission();
            $permissions->status = '1';
            $permissions->permission_type = 1;
            $permissions->permission_id = $module_id;
            $permissions->role_id = $role_id;
            $permissions->created_by = Auth::user()->id;
            $permissions->save();

            Permission::whereIn('permission_id', array_keys($this->getsubmodules($module_id)->toArray()))->update([
                'status' => 1
            ]);
        }
    }

    public function submodulepermissions($sub_module_id, $value, $role_id)
    {
        $permissions = Permission::where('permission_id', $sub_module_id)->where('role_id', $role_id)
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
            $this->alertSuccess('Permisison Updated Successfully!!');
            
        } else {
            $permissions = new Permission();
            $permissions->status = 1;
            $permissions->permission_type = 2;
            $permissions->permission_id = $sub_module_id;
            $permissions->role_id = $role_id;
            $permissions->created_by = Auth::user()->id;
            $permissions->save();
            $this->alertSuccess('Permisison Updated Successfully!!');
            
        }
    }

    public function functionspermissions($module_function_id,$funct, $role_id)
    {
        $permissions = Permission::where('permission_id', $module_function_id)->where('role_id', $role_id)
            ->where('permission_type', 3)
            ->first();
        if (! empty($permissions)) {
            if ($permissions['status'] == 1) {
                $value = 0;
            } else {
                $value = 1;
            }
            $permissions->status = $value;
            $permissions->update();
            $this->alertSuccess('Permission Update successfully!');
            
        } else {
            $permissions = new Permission();
            $permissions->status = 1;
            $permissions->permission_type = 3;
            $permissions->permission_id = $module_function_id;
            $permissions->role_id = $role_id;
            $permissions->created_by = Auth::user()->id;
            $permissions->save();
            $this->alertSuccess('Permission Update successfully!');
        }
    }

    public function moduleSelected($module_id,$permission_type , $status, $role_id)
    {
        $permission = Permission::where('permission_id', $module_id)->where('permission_type',$permission_type)->where('role_id',$role_id)->first();
        
        if (!empty($permission)&&($permission->status==$status)) {
            return 1;
        }
        return 0;
    }

    public function sumbit()
    {
        $this->validate();
        $users = Role::find($this->User_id);
        if (! empty($users)) {
            $users->update([
                'name' => $this->name
            ]);
            $this->alertSuccess('roles update  Successfully!');
        } else {
            $user = Role::Create([
                'name' => $this->name
            ]);
            $this->alertSuccess('roles added  Successfully!');
        }
        $this->name = '';
        $this->emit('userStore', 'personalInfo');
    }

    public function alertSuccess($msg)
    {
        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => $msg
        ]);
    }

    public function allDelete()
    {
        Permission::truncate();
    }
    public function delete($user_id)
    {
        $user = Role::findOrFail($user_id);
        $user->delete();
    }

    public function resetData()
    {
        $this->resetValidation();
        $this->User_id = '';
        $this->name = '';
    }

    public function addform()
    {
        $this->resetData();
    }

}

