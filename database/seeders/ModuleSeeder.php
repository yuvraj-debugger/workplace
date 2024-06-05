<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\ModuleFunction;
use App\Models\Submodule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules= array('dashboard','employee_module', 'leaves','attendance','personal','accounts_and_statutory','employement_and_job','additional_details','payrolls','documents','profile_attendance','profile_leaves','salary_slips','awards_and_recognitions','payroll_history');
        foreach($modules as $module)
        {
            $module_data=Module::create(['name'=>$module]);
            if(!empty($module_data))
            {
                if($module=='dashboard')
                {
                    $submodules=array(
                        'dashboard',
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='dashboard')
                        {
                        }
                       
                    }
                }
                if($module=='employee_module')
                {
                    $submodules=array(
                        'employees',
                        'employee_designation',
                        'employee_department',
                        'employee_seperate_out',
                        'reporting_structure',
                        'mass_communication',
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='overview')
                        {
                        }
                        if($submodule=='employees')
                        {
                            $module_functionality=[
                                'create',
                                'update',
                                'delete',
                                'view_profile',
                                'export',
                                'import',
                                'grid_view',
                                'list_view',
                                'filters'
                            ];

                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='employee_designation')
                        {
                            $module_functionality=[
                                'create',
                                'update',
                                'delete',
                                'view_profile',
                                'export',
                                'filters'
                            ];  
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }

                        }
                        if($submodule=='employee_department')
                        {
                            $module_functionality=[
                                'create',
                                'update',
                                'delete',
                                'view_profile',
                                'export',
                                'filters'
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }

                        }
                        if($submodule=='employee_seperate_out')
                        {
                        }
                        if($submodule=='reporting_structure')
                        {
                        }
                        if($submodule=='mass_communication')
                        {
                        }
                    }
                }
                if($module=='leaves')
                {
                    $submodules=array(
                        'holidays',
                        'leaves',
                        'leaves_settings'
                    
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='holidays')
                        {
                            $module_functionality=[
                                'create',
                                'update',
                                'delete',
                                'view',
                                'filters'
                               
                            ];
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            } 

                        }
                        if($submodule=='leaves')
                        {
                            $module_functionality=[
                                'create',
                                'update',
                                'delete',
                               
                            ];
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }

                        }
                        if($submodule=='leavesettings')
                        {
                        
                        }
                        
                    }
                }
                if($module=='attendance')
                {
                    $submodules=array(
                        'admin_attendance',              
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='admin_attendance')
                        {
                            $module_functionality=[
                                'create',
                                'update',
                                'delete',
                                'view',
                                'filters'
                            ];
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        
                    }
                }
                if($module=='personal')
                {
                    $submodules=array(
                        'personal_information', 
                        'emergency_contact', 
                        'joining_details' ,
                        'official_contact_information' ,
                        'family_information',
                        'education_information'            
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='personal_information')
                        {
                           
                            $module_functionality=[
                                'update'
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='emergency_contact')
                        {
                           
                            $module_functionality=[
                               
                                'update',
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='joining_details')
                        {
                           
                            $module_functionality=[
                               
                                'update',
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='official_contact_information')
                        {
                           
                            $module_functionality=[
                               
                                'update'
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='family_information')
                        {
                            $module_functionality=[
                               
                                'create',
                                'update',
                                'delete'
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='education_information')
                        {
                            $module_functionality=[
                                'create',
                                'update',
                                'delete'
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                     
                        
                    }
                }
                if($module=='personal')
                {
                    $submodules=array(
                        'personal_information', 
                        'emergency_contact', 
                        'joining_details' ,
                        'official_contact_information' ,
                        'family_information',
                        'education_information'            
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='personal_information')
                        {
                           
                            $module_functionality=[
                                'update'
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='emergency_contact')
                        {
                           
                            $module_functionality=[
                               
                                'update',
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='joining_details')
                        {
                           
                            $module_functionality=[
                               
                                'update',
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='official_contact_information')
                        {
                           
                            $module_functionality=[
                               
                                'update'
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='family_information')
                        {
                            $module_functionality=[
                               
                                'create',
                                'update',
                                'delete'
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='education_information')
                        {
                            $module_functionality=[
                                'create',
                                'update',
                                'delete'
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                     
                        
                    }
                }
                if($module=='accounts_and_statutory')
                {
                    $submodules=array(
                        'bank_information',  
                        'account_statutory'        
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='bank_information')
                        {
                           
                            $module_functionality=[
                                'update'
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        if($submodule=='account_statutory')
                        {
                           
                            $module_functionality=[
                               
                                'update',
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                       
                       
                        
                     
                        
                    }
                }
               
                if($module=='employement_and_job')
                {
                    $submodules=array(
                        'experience_information',  
                                    
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='experience_information')
                        {
                            $module_functionality=[
                               
                                'create',
                                'update',
                                'delete'
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        
                    }
                }
                if($module=='additional_details')
                {
                    $submodules=array(
                        'additional_detail',  
                                    
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='additional_detail')
                        {
                            $module_functionality=[
                               
                                'update',
                               
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        
                    }
                }
                if($module=='payrolls')
                {
                    $submodules=array(
                        'payroll',  
                                    
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='payroll')
                        {
                            $module_functionality=[
                               
                                'update',
                               
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        
                    }
                }
                if($module=='documents')
                {
                    $submodules=array(
                        'documents',  
                                    
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='documents')
                        {
                            $module_functionality=[
                                'create',
                                'update',
                                'delete',
                                'download'
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        
                    }
                }
                if($module=='profile_attendance')
                {
                    $submodules=array(
                        'attendance',  
                                    
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='attendance')
                        {
                            $module_functionality=[
                               
                                'create',
                                'update',
                                'view'
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        
                    }
                }
                if($module=='profile_leaves')
                {
                    $submodules=array(
                        'profile_leaves',  
                                    
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='profile_leaves')
                        {
                            $module_functionality=[
                               
                                'create',
                                'update',
                                'view'
                                
                            ]; 
                            foreach($module_functionality as $functionality)
                            {
                                $function=ModuleFunction::create(['name'=>$functionality,'module_id'=>$module_data->_id,'sub_module_id'=>$submodule_data->_id]);
                            }
                        }
                        
                    }
                }
                if($module=='salary_slips')
                {
                    $submodules=array(
                        'salary_slips',  
                                    
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='salary_slips')
                        {
                           
                        }
                        
                    }
                }
                if($module=='awards_and_recognitions')
                {
                    $submodules=array(
                        'awards_and_recognitions',  
                                    
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='awards_and_recognitions')
                        {
                           
                        }
                        
                    }
                }
                if($module=='payroll_history')
                {
                    $submodules=array(
                        'payroll_history',  
                                    
                    );
                    foreach($submodules as $submodule)
                    {
                        $submodule_data=Submodule::create(['name'=>$submodule,'module_id'=>$module_data->_id]);
                        if($submodule=='payroll_history')
                        {
                            
                        }
                        
                    }
                }
            }
        }
    
    }
}
