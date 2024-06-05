<?php

namespace App\View\Components;

use App\Models\Module;
use App\Models\ModuleFunction;
use App\Models\Role;
use App\Models\Submodule;
use Illuminate\View\Component;
use App\Models\Permission;

class RolePermission extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
       
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
   
    public function render()
    {
        $roles = Role::orderBy('order','ASC')->get();
        return view('components.role-permission',compact( 'roles'));
    }
}
