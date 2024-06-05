<?php 

use App\Models\Submodule;
?>
                              
@foreach ($roles->module as $module)
      <h6>
      	<label class="subHead">{{ ucwords(str_replace('_', ' ', $module->name)) }}</label>
      </h6>
    <div class="form-group mt-0 mb-4 ">
        @foreach ($module->submodule as $submodule)                                        
            <div class="checkboxOuter mb-2">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                            onClick="subModuleClick('<?=$submodule->_id?>','<?=$roles->_id?>',2)" {{(Submodule::moduleValue($submodule->_id,$roles->_id,2)?'checked':'')}}
                            id="createBankInfo">  
                            <label class="subHead">{{ ucwords(str_replace('_', ' ', $submodule->name)) }}</label>
                        </div>
                    </div>
                    @foreach ($submodule->functions as $function)
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="form-check">
                            <input class="form-check-input" 
                            type="checkbox" value="" id="subModuleCheck" onClick="funModuleClick('<?=$function->_id?>','<?=$roles->_id?>',3)" {{(Submodule::moduleValue($function->_id,$roles->_id,3)?'checked':'')}}>
                            <label class="form-check-label" for="createBankInfo">
                                {{ucfirst(str_replace('_', ' ', $function->name)) }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                
               
                
                
            </div>
        @endforeach
    </div>
@endforeach