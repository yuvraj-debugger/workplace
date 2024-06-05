<?php

namespace App\Http\Livewire;

use App\Models\Module;
use App\Models\ModuleFunction;
use App\Models\Permission;
use App\Models\RolesPermission;
use App\Models\Submodule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfilePermission extends Component
{
    public $emp_id;
    public $user_id;
    public $role_id;

    public function mount($emp_id){
        $this->emp_id = $emp_id;   
    }
    public function render(){
        $this->role_id = User::where('_id', $this->emp_id)->value('user_role');
        $modules=Module::pluck('name', '_id');
        return view('livewire.profile-permission',compact('modules'));
    }
    
   
    public function getsubmodules($module_id)
    {
        
        return Submodule::where('module_id',$module_id)->get();
     
    }
    public function getmodulefunction($sub_module_id)
    {
        
        return  ModuleFunction::where('sub_module_id',$sub_module_id)->get();
      
    }
    public function functionData($submodule_id){
        
        
        $functionsData=ModuleFunction::where('sub_module_id',$submodule_id)->pluck('name', '_id');
        return $functionsData;
    }
    public function modulepermissions($module_id,$emp_id,$value){
        $permissions=RolesPermission::where('permission_id',$module_id)->where('user_id',$this->emp_id)->where('permission_type',1)->first();
        if(!empty($permissions)){
            if($permissions['status'] == '1'){
                $value = '0';
            }else{
                $value= '1';
            }
            $permissions->status=$value;
            $permissions->update();
        }else{
            $permissions=new RolesPermission();
            $permissions->user_id=$this->emp_id;
            $permissions->status='1';
            $permissions->permission_type=1;
            $permissions->permission_id=$module_id;
            $permissions->created_by=Auth::user()->id;
            $permissions->save();    
        }
        // dd($permissions->toArray());
    }
    public function submodulepermissions($sub_module_id,$emp_id,$value){
        $permissions=RolesPermission::where('permission_id',$sub_module_id)->where('user_id',$this->emp_id)->where('permission_type',2)->first();
        if(!empty($permissions)){
            if($permissions['status'] == '1'){
                $value = '0';
            }else{
                $value= '1';
            }
            $permissions->status=$value;
            $permissions->update();
        }else{
            $permissions=new RolesPermission();
            $permissions->user_id=$this->emp_id;
            $permissions->status='1';
            $permissions->permission_type=2;
            $permissions->permission_id=$sub_module_id;
            $permissions->created_by=Auth::user()->id;
            $permissions->save();   
        }
    }
    public function functionspermissions($module_function_id, $emp_id,$value){ 
      
        $permissions=RolesPermission::where('permission_id',$module_function_id)->where('user_id',$this->emp_id)->where('permission_type',3)->first();
        if(!empty($permissions)){
            if($permissions['status'] == '0'){
                $value = '1';
            }else{
                $value= '0';
            }
            $permissions->status=$value;
            $permissions->update();
        }else{
            $permissions=new RolesPermission();
            $permissions->status='1';
            $permissions->permission_type=3;
            $permissions->permission_id=$module_function_id;
            $permissions->user_id=$this->emp_id;;
            $permissions->created_by=Auth::user()->id;
            $permissions->save();    
        }
    }
    public function moduleSelected($module_id, $permission_type,$status)
    {
     
        $permission=RolesPermission::where('permission_id',$module_id)->where('permission_type',$permission_type)->where('user_id',$this->emp_id)->value('status');
        if($permission)
        {
            return 1;
        }
        return 0;
    }
}
