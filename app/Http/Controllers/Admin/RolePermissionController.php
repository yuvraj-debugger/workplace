<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleFunction;
use App\Models\Role;
use App\Models\Submodule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RolePermissionController extends Controller
{

    public function getRules($id)
    {
        $roles = Role::find($id);
        $modules = Module::orderBy('order','ASC')->get();
        $roles->module = $modules;
        foreach ($roles->module as $module) {

            $module->submodule = Submodule::orderBy('order','ASC')->where('module_id', $module->_id)->get();

            foreach ($module->submodule as $submodule) {
                $submodule->functions = ModuleFunction::where('sub_module_id', $submodule->_id)->get();
            }
        }
        return view('admin.userPermission.roles-permission', compact('roles', 'modules'));
    }
    public function addRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name|required|regex:/^[\pL\s\-]+$/u|min:2|max:25'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if(! empty($request->name)){
            $role = new Role();
            $role->name = $request->name;
            $role->save();
            return redirect('/roles-permissions');
        }
       
        Session::flash('success', 'Role added successfully');
        return redirect('/roles-permissions');
    }

    public function updateRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name|required|regex:/^[\pL\s\-]+$/u|min:2|max:25'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $role = Role::where('_id', $request->id)->first();
        if (! empty($role)) {
            $role->name = $request->name;
            $role->update();
        }
        Session::flash('success', 'Role updated successfully');
        return redirect('/roles-permissions');
        return true;
    }
    public function deleteRole(Request $request)
    {
        $role = Role::where('_id', $request->id)->first();
        $role->delete();
        Session::flash('success', 'Role deleted successfully');
    }
    public function duplicateRole()
    {
        $allModule = Module::paginate(10)->withQueryString();
        return view('admin.userPermission.duplicate-data', compact('allModule'));
    }
    public function getSubModule(Request $request,$id)
    {
        $subModules = Submodule::where('module_id',$id)->paginate(10);
        return view('admin.userPermission.duplicate-submodule', compact('subModules'));
    }
    public function getmoduleFunction(Request $request,$sub_id,$module_id)
    {
        $moduleFunction = ModuleFunction::where('sub_module_id',$sub_id)->where('module_id',$module_id)->paginate(10);
        return view('admin.userPermission.duplicate-module-function', compact('moduleFunction'));
        
    }
    public function assignModuleFunction(Request $request)
    {
        $function = ModuleFunction::where('_id',$request->id)->first();
        if(! empty($function)){
            $functionName = $function->name;
            $functionId = $function->_id;
        }
        $data=[
            'id'=>$functionId,
            'name'=>$functionName,
        ];
        return json_encode($data);
    }
    public function addModuleFunction(Request $request)
    {
        $function = ModuleFunction::where('_id',$request->name_id)->first();
        $function->name = $request->name;
        $function->update();
    }
}