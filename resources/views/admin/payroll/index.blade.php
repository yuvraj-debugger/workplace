<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Payroll Items</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Policy</li>
				</ol>
			</nav>
		</div>
			   @if(session('success'))
                    <div class="alert alert-success" id="success">
                        {{ session('success') }}
                    </div>
				@endif
				   @if(session('info'))
                    <div class="alert alert-success" id="danger">
                        {{ session('info')}}
                    </div>
				@endif
		<div class="dashboardSection__body commonBoxShadow rounded-1">
			<ul class="nav nav-pills commonTabs" id="pills-tab" role="tablist">
				<li class="nav-item" role="presentation">
					<button
						class="nav-link  <?=($tabs == 'addition') ? 'active' : ''?> "
						id="pills-addition-tab" data-bs-toggle="pill"
						data-bs-target="#pills-addition" type="button" role="tab"
						aria-controls="pills-addition" aria-selected="true">Additonal</button>
				</li>
<!-- 				<li class="nav-item" role="presentation"> -->
<!-- 					<button -->
<!-- 						class="nav-link" -->
<!-- 						id="pills-overtime-tab" data-bs-toggle="pill" -->
<!-- 						data-bs-target="#pills-overtime" type="button" role="tab" -->
<!-- 						aria-controls="pills-overtime" aria-selected="false">Overtime</button> -->
<!-- 				</li> -->
				<li class="nav-item" role="presentation">
					<button
						class="nav-link <?=($tabs == 'deductions') ? 'active' : ''?>"
						id="pills-deductions-tab" data-bs-toggle="pill"
						data-bs-target="#pills-deductions" type="button" role="tab"
						aria-controls="pills-deductions" aria-selected="false">Deductions</button>
				</li>

			</ul>
		</div>
		<div class="tab-content mt-5" id="pills-tabContent">
			<div
				class="tab-pane fade <?=($tabs == 'addition') ? 'active show' : ''?>"
				id="pills-addition" role="tabpanel"
				aria-labelledby="pills-addition-tab" tabindex="0">

				<div class="text-end mb-4 clearfix">
					<button class="commonButton add-btn" type="button"
						data-bs-toggle="modal" data-bs-target="#add_addition">
						<i class="fa-solid fa-plus"></i> Add Addition
					</button>
				</div>
        <div class="dashboardSection__body">
        <div class="commonDataTable">
        <div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
								    <th></th>
									<th>Name</th>
									<th>Category</th>
									<th>Formula</th>
									<th>Employee's Name</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@foreach($payrollAddition as $key=>$addition)
								<tr>
								    <td>{{++$key}}</td>
									<td>{{$addition->name}}</td>
									<td><?php if($addition->category == '1'){
									    echo "Monthly remuneration";
									}else{
									    echo "Fixed remuneration";
									}?></td>
									<td>{{$addition->formula}}</td>
									
									<td>{{$addition->getEmployeeName()}}</td>
									<td><?php 
									if($addition->status == '1'){
									    
									    echo "<span style='color:green';>Active</span>";
									}else{
									    echo "<span style='color:red';>Inactive</span>";
									}
									?></td>
<?php 
									
									if($addition->status == '1'){
									?>
									<td>
                    <div class="actionIcons">
                      <ul>
                        <li><a class="edit"  onclick="editAddition('{{$addition->_id}}')" ><i class="fa-solid fa-pen"></i></a></li>
                        <li class="ms-0"><a data-bs-toggle="tooltip" data-bs-placement="top"  class="bin deleteAddition policyDelete"  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$addition->_id}}"><i class="fa-regular fa-trash-can"></i></a></li>
                      </ul>
                    </div>
									</td>
									<?php }else{
									    ?>
									    		<td>
									    <div class="actionIcons">
                      <ul>
                        <li><i class="fa-solid fa-pen edit disabled"></i></li>
                        <li class="ms-0 "><i class="fa-regular fa-trash-can bin policyDelete disabled"></i></li>
                      </ul>
                    </div>
								</td>	    
								<?php	}?>
								</tr>
								@endforeach
							</tbody>
						</table>
						{{$payrollAddition->appends(['activetab' => 'addition'])->links('pagination::bootstrap-4')}}
					</div>
        </div>
        </div>
			</div>
		</div>
		<div class="modal fade" id="add_addition" tabindex="-1" aria-labelledby="add_additionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="bloodModalLabel">Add Addition</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="add_payroll_addition">
					@csrf
					<div class="col-lg-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="addition_name" class="form-control" value="" name="name">
                                     <span class="text-danger error" id="add_error_name"></span> 
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category" id="addition_category" class="form-control">
                                           <option value="">Select a category</option>
											<option value="1">Monthly remuneration</option>
											<option value="2">Fixed remuneration</option>
                                </select>
                                     <span class="text-danger error" id="add_error_category"></span> 
                            </div>
                             <div class="form-group" id="addition_number_label" style="display:none">  
                                <label>Additon Number</label>
                                <input type="text" id="additon_number" class="form-control" value="" name="additon_number">
                                     <span class="text-danger error" id="add_error_additon_number"></span>  
                            </div>
                            <div class="form-group">
                                <label>Parameter</label>
                                <input type="text" id="addtion_parameter" class="form-control" value="" name=parameter>
                                     <span class="text-danger error" id="add_error_parameter"></span> 
                            </div>
                             <div class="form-group">
                                <label>Formula</label>
                                <input type="text" id="addtion_formula" class="form-control" value="" name=formula>
                                     <span class="text-danger error" id="add_error_formula"></span> 
                            </div>
                            <div class="form-group">
                              <input class="form-check-input" type="checkbox" name="addition_bonus" value="1" id="addition_bonus">
                              <label class="form-check-label" for="addition_bonus">
                                Addition Bonus
                              </label>
                            </div>
                            <div class="form-group">
                              <input class="form-check-input" type="checkbox" name="fixed_value" value="1" id="fixed_value">
                              <label class="form-check-label" for="flexCheckChecked">
                                Fixed Value
                              </label>
                            </div>
                            <div class="form-group">
                              <input class="form-check-input" type="checkbox" name="type" value="1" id="flexCheckChecked" checked>
                              <label class="form-check-label" for="flexCheckChecked">
                                All
                              </label>
                            </div>
                            <div class="form-group">
                                <label>Employees</label>
                                <select name="employee_id[]" id="addition_employee" class="form-control" multiple="multiple">
                                      @foreach($employees as $user)
                                        <option value='{{$user->_id}}' data-src="http://placehold.it/45x45">{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}} ({{$user->employee_id}})</option>
                                    @endforeach
                                </select>
                                     <span class="text-danger error" id="add_error_employee_id"></span> 
                            </div>
                        </div>
                         <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>


<div class="modal fade" id="update_addition" tabindex="-1" aria-labelledby="update_additionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="update_additionLabel">Edit Addition</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="update_payroll_addition">
					@csrf
					<input type="hidden" name="addition_id" id="addition_id" value=""/>
					<div class="col-lg-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="edit_addition_name" class="form-control" value="" name="name">
                                     <span class="text-danger error" id="edit_error_name"></span> 
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category" id="edit_addition_category" class="form-control">
                                           <option value="">Select a category</option>
											<option value="1" >Monthly remuneration</option>
											<option value="2">Fixed remuneration</option>
                                </select>
                                     <span class="text-danger error" id="edit_error_category"></span> 
                            </div>
                              <div class="form-group" id="edit_addition_number_label" style="display:none">
                                <label>Additon Number</label>
                                <input type="text" id="edit_additon_number" class="form-control" value="" name="additon_number">
                                     <span class="text-danger error" id="edit_error_additon_number"></span>  
                            </div>
                            <div class="form-group">
                                <label>Parameter</label>
                                <input type="text" id="edit_addtion_parameter" class="form-control" value="" name=parameter>
                                     <span class="text-danger error" id="edit_error_parameter"></span> 
                            </div>
                             <div class="form-group">
                                <label>Formula</label>
                                <input type="text" id="edit_addtion_formula" class="form-control" value="" name=formula>
                                     <span class="text-danger error" id="edit_error_formula"></span> 
                            </div>
                               <div class="form-group">
                              <input class="form-check-input" type="checkbox" name="addition_bonus" value="1" id="edit_addition_bonus">
                              <label class="form-check-label" for="edit_addition_bonus">
                                Addition Bonus
                              </label>
                            </div>
                            <div class="form-group">
                              <input class="form-check-input" type="checkbox" name="fixed_value" value="1" id="edit_fixed_value">
                              <label class="form-check-label" for="flexCheckChecked">
                                Fixed Value
                              </label>
                            </div>
                            <div class="form-group">
                              <input class="form-check-input" type="checkbox" name="type" value="" id="edit_type">
                              <label>All </label>
                            </div>
                            <div class="form-group">
                                <label>Employees</label>
                                <select name="employee_id[]" id="edit_addition_employee_id" class="form-control" multiple="multiple">
                                     @foreach($employees as $user)
                                        <option value='{{$user->_id}}' data-src="http://placehold.it/45x45">{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}} ({{$user->employee_id}})</option>
                                    @endforeach
                                </select>
                                     <span class="text-danger error" id="edit_error_employee_id"></span> 
                            </div>
                        </div>
                         <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>
		
		<div class="tab-content mt-5" id="pills-tabContent">

			<div
				class="tab-pane fade <?=($tabs == 'overtime') ? 'active show' : ''?>"
				id="pills-overtime" role="tabpanel"
				aria-labelledby="pills-overtime-tab" tabindex="0">
				
				<div class="text-end mb-4 clearfix">
					<button class="commonButton add-btn" type="button"
						data-bs-toggle="modal" data-bs-target="#add_overtimeModal">
						<i class="fa-solid fa-plus"></i> Add Overtime
					</button>
				</div>
        <div class="commonDataTable">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th></th>
									<th>Name</th>
									<th>Rate Type</th>
									<th>Rate</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@foreach($payrollOvertime as $key=>$overtime)
								<tr>
									<td>{{++$key}}</td>
									<td>{{$overtime->name}}</td>
									<td><?php if($overtime->rate_type == '1'){
									    echo "Daily Rate";
									}else{
									        echo "Hourly Rate";
									    }?></td>
									<td>{{$overtime->rate}}</td>
									<td><?php 
									if($overtime->status == '1'){
									    echo "<span style='color:green';>Active</span>";
									}else{
									   echo  "<span style='color:red';>Inactive</span>";
									}?></td>
									<td class="">
                    <div class="actionIcons">
                      <ul>
                        <li><a data-bs-toggle="tooltip" onclick="editOvertime('{{$overtime->_id}}')"class="edit" title="Edit Overtime"><i class="fa-solid fa-pen"></i></a></li>
                        <li class="ms-0"><a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Overtime" class="bin overtimeDelete policyDelete"  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$overtime->_id}}"><i class="fa-regular fa-trash-can"></i></a></li>
                      </ul>
                    </div>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
          </div>
			</div>
		</div>
		<div class="modal fade" id="add_overtimeModal" tabindex="-1" aria-labelledby="add_overtimeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="add_overtimeModalLabel">Add Overtime</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="add_overtime">
					@csrf
					<div class="col-lg-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="addition_name" class="form-control" value="" name="name">
                                     <span class="text-danger error" id="errors_overtime_name"></span> 
                            </div>
                            <div class="form-group">
                                <label>Rate Type</label>
                                <select name="rate_type" id="overtime_rate_type" class="form-control">
                                    <option value="">Select a category</option>
											<option value="1">Daily Rate</option>
											<option value="2">Hourly Rate</option>
                                </select>
                                     <span class="text-danger error" id="errors_overtime_rate_type"></span> 
                            </div>
                            <div class="form-group">
                                <label>Rate</label>
                                <input type="text" id="addtion_unit_name" class="form-control" value="" name=rate>
                                     <span class="text-danger error" id="errors_overtime_rate"></span> 
                            </div>
                        </div>
                         <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>


<div class="modal fade" id="edit_overtimeModal" tabindex="-1" aria-labelledby="edit_overtimeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="edit_overtimeModalLabel">Edit Overtime</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="update_overtime">
					@csrf
					<input type="hidden" name="overtime_id" id="overtime_id" />
					<div class="col-lg-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="edit_overtime_name" class="form-control" value="" name="name">
                                     <span class="text-danger error" id="errors_overtime_name"></span> 
                            </div>
                            <div class="form-group">
                                <label>Rate Type</label>
                                <select name="rate_type" id="edit_overtime_rate_type" class="form-control">
                                    <option value="">Select a category</option>
											<option value="1">Daily Rate</option>
											<option value="2" >Hourly Rate</option>
                                </select>
                                     <span class="text-danger error" id="errors_overtime_rate_type"></span> 
                            </div>
                            <div class="form-group">
                                <label>Rate</label>
                                <input type="text" id="edit_overtime_rate" class="form-control" value="" name=rate>
                                     <span class="text-danger error" id="errors_overtime_rate"></span> 
                            </div>
                        </div>
                         <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>

		<div class="tab-content mt-5" id="pills-tabContent">
			<div
				class="tab-pane fade <?=($tabs == 'deductions') ? 'active show' : ''?>"
				id="pills-deductions" role="tabpanel"
				aria-labelledby="pills-deductions-tab" tabindex="0">
				
				<div class="text-end mb-4 clearfix">
					<button class="commonButton add-btn" type="button"
						data-bs-toggle="modal" data-bs-target="#add_deductionsmodal">
						<i class="fa-solid fa-plus"></i> Add Deduction
					</button>
				</div>
        <div class="dashboardSection__body">
          <div class="commonDataTable">
            <div class="table-responsive">
              <table class="table table-hover table-radius">
                <thead>
                  <tr>
                      <th></th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Employee's Name</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($payrollDeduction as $key=>$deduction)
                  <tr>
                      <td>{{++$key}}</td>
                      <td>{{$deduction->name}}</td>
                    <td><?php if($deduction->category == '1'){
                        echo "Monthly remuneration";
                    }else{
                        echo "Fixed remuneration";
                    }?></td>
                    <td>{{$deduction->getEmployeeName()}}</td>
                    <td><?php 
                    if($deduction->status == '1'){
                        
                        echo "<span style='color:green';>Active</span>";
                    }else{
                        echo "<span style='color:red';>Inactive</span>";
                    }
                    
                    
                    ?></td>
                    <?php 
                    if($deduction->status == '1'){
                    ?>
                    <td>
                      <div class="actionIcons">
                        <ul>
                          <li><a class="edit"  onclick="editDeduction('{{$deduction->_id}}')" ><i class="fa-solid fa-pen"></i></a></li>
                          <li class="ms-0"><a data-bs-toggle="tooltip" data-bs-placement="top"  class="bin deductionDelete policyDelete"  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$deduction->_id}}"><i class="fa-regular fa-trash-can"></i></a></li>
                        </ul>
                      </div>
                    </td>
                    <?php }else{
              ?>
              <td>
                      <div class="actionIcons">
                        <ul>
                          <li><i class="fa-solid fa-pen edit disabled"></i></li>
                          <li class="ms-0"><i class="fa-regular fa-trash-can bin policyDelete disabled"></i></li>
                        </ul>
                      </div>
                    </td>
                    <?php }?>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
			</div>
		</div>
		<div class="modal fade" id="add_deductionsmodal" tabindex="-1" aria-labelledby="add_deductionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="add_deductionLabel">Add Deductions</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form method="post" enctype="multipart/form-data" id="addDeductions">
					@csrf
					<div class="col-lg-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="deduction_name" class="form-control" value="" name="name">
                                     <span class="text-danger error" id="errors_degree_name"></span> 
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category" id="deduction_category" class="form-control">
                                    <option>Select a category</option>
											<option value="1">Monthly remuneration</option>
											<option value="2" >Fixed remuneration</option>
                                </select>
                                     <span class="text-danger error" id="errors_degree_name"></span> 
                            </div>
                            <div class="form-group" id="deduction_number_label" style="display:none">  
                                <label>Deduction Number</label>
                                <input type="text" id="deduction_number" class="form-control" value="" name="deduction_number">
                                     <span class="text-danger error" id="add_error_deduction_number"></span>  
                            </div>
                            
                            <div class="form-group">
                                <label>Parameter</label>
                                <input type="text" id="deduction_parameter" class="form-control" value="" name=parameter>
                                     <span class="text-danger error" id="errors_parameter"></span> 
                            </div>
                             <div class="form-group">
                                <label>Formula</label>
                                <input type="text" id="deduction_formula" class="form-control" value="" name=formula>
                                     <span class="text-danger error" id="errors_formula"></span> 
                            </div>
                            <div class="form-group">
                              <input class="form-check-input" type="checkbox" name="fixed_value" value="1" id="deduct_fixed_value">
                              <label class="form-check-label" for="deduct_fixed_value">
                                Fixed value
                              </label>
                            </div>
                            
                            <div class="form-group">
                              <input class="form-check-input" type="checkbox" name="type" value="1" id="flexCheckChecked" checked>
                              <label class="form-check-label" for="flexCheckChecked">
                                All
                              </label>
                            </div>
                            <div class="form-group">
                                <label>Employees</label>
                                <select name="employee_id[]" id="deduction_employee" class="form-control" multiple="multiple">
	                                      @foreach($employees as $user)
                                        <option value='{{$user->_id}}' data-src="http://placehold.it/45x45">{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}} ({{$user->employee_id}})</option>
                                    @endforeach
                                </select>
                                     <span class="text-danger error" id="errors_degree_name"></span> 
                            </div>
                        </div>
                         <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>



<div class="modal fade" id="edit_deductionsmodal" tabindex="-1" aria-labelledby="edit_deductionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="edit_deductionLabel">Edit Deductions</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form method="post" enctype="multipart/form-data" id="editDeductions">
					@csrf
					<input type="hidden" name="deduction_id" id="deduction_id" />
					<div class="col-lg-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="edit_deduction_name" class="form-control" value="" name="name">
                                     <span class="text-danger error" id="errors_degree_name"></span> 
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category" id="edit_deduction_category" class="form-control">
                                    <option>Select a category</option>
											<option value="1">Monthly remuneration</option>
											<option value="2" >Fixed remuneration</option>
                                </select>
                                     <span class="text-danger error" id="errors_degree_name"></span> 
                            </div>
                              <div class="form-group" id="edit_deduction_number_label" style="display:none">  
                                <label>Deduction Number</label>
                                <input type="text" id="edit_deduction_number" class="form-control" value="" name="deduction_number">
                                     <span class="text-danger error" id="add_error_deduction_number"></span>  
                            </div>
                             <div class="form-group">
                                <label>Parameter</label>
                                <input type="text" id="edit_deduction_parameter" class="form-control" value="" name=parameter>
                                     <span class="text-danger error" id="errors_parameter"></span> 
                            </div>
                             <div class="form-group">
                                <label>Formula</label>
                                <input type="text" id="edit_deduction_formula" class="form-control" value="" name=formula>
                                     <span class="text-danger error" id="errors_formula"></span> 
                            </div>
                             <div class="form-group">
                              <input class="form-check-input" type="checkbox" name="fixed_value" value="1" id="edit_deduct_fixed_value">
                              <label class="form-check-label" for="edit_deduct_fixed_value">
                                Fixed value
                              </label>
                            </div>
                            <div class="form-group">
                              <input class="form-check-input" type="checkbox" name="type" value="" id="deduction_edit_type">
                              <label class="form-check-label" for="flexCheckChecked">
                                All
                              </label>
                            </div>
                            <div class="form-group">
                                <label>Employees</label>
                                <select name="employee_id[]" id="edit_deduction_employee" class="form-control" multiple="multiple">
	                                      @foreach($employees as $user)
                                        <option value='{{$user->_id}}' data-src="http://placehold.it/45x45">{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}} ({{$user->employee_id}})</option>
                                    @endforeach
                                </select>
                                     <span class="text-danger error" id="errors_degree_name"></span> 
                            </div>
                        </div>
                         <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>

	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
 $(function(){
  $('#addition_category').select2({
    dropdownParent: $('#add_addition')
  }).on('change', function(e) {
   if(this.value == '1'){
    $('#addition_number_label').show();
   }else{
   	$('#addition_number_label').hide();
   }
  });
}); 


 $(function(){
  $('#edit_deduction_employee').select2({
    dropdownParent: $('#edit_deductionsmodal')
  });
}); 


 $(function(){
  $('#edit_deduction_category').select2({
    dropdownParent: $('#edit_deductionsmodal')
  }).on('change', function(e) {
   if(this.value == '1'){
    $('#edit_deduction_number_label').show();
   }else{
   	$('#edit_deduction_number_label').hide();
   }
  });;
}); 


 $(function(){
  $('#edit_unit_calculation_deduction').select2({
    dropdownParent: $('#edit_deductionsmodal')
  });
}); 





 $(function(){
  $('#unit_calculation').select2({
    dropdownParent: $('#add_addition')
  });
}); 



 $(function(){
  $('#addition_employee').select2({
    dropdownParent: $('#add_addition')
  });
}); 


 $(function(){
  $('#overtime_rate_type').select2({
    dropdownParent: $('#add_overtime')
  });
}); 

 $(function(){
  $('#deduction_category').select2({
    dropdownParent: $('#add_deductionsmodal')
  }).on('change', function(e) {
   if(this.value == '1'){
    $('#deduction_number_label').show();
   }else{
   	$('#deduction_number_label').hide();
   }
  });;
}); 


 $(function(){
  $('#unit_calculation_deduction').select2({
    dropdownParent: $('#add_deductionsmodal')
  });
}); 



 $(function(){
  $('#deduction_employee').select2({
    dropdownParent: $('#add_deductionsmodal')
  });
}); 

 $(function(){
  $('#edit_addition_category').select2({
    dropdownParent: $('#update_addition')
  }).on('change', function(e) {
   if(this.value == '1'){
    $('#edit_addition_number_label').show();
   }else{
   	$('#edit_addition_number_label').hide();
   }
  });;
}); 
 $(function(){
  $('#edit_addition_employee_id').select2({
    dropdownParent: $('#update_addition')
  });
}); 
 $(function(){
  $('#edit_unit_calcualtion').select2({
    dropdownParent: $('#update_addition')
  });
}); 

 $(function(){
  $('#edit_overtime_rate_type').select2({
    dropdownParent: $('#edit_overtimeModal')
  });
}); 




function editAddition(id)
{
  $('#update_addition').modal('show');
  $('#addition_id').val(id)
   $.ajax({
                type: 'post',
                url: "{{ route('editPayrollAddition')}}",
                data: "id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#edit_addition_name').val(data.name);
                $('#edit_addition_category').val(data.category).trigger('change');
                $('#edit_addtion_unit_name').val(data.unit_amount);
                $('#edit_addtion_parameter').val(data.parameter);
                $('#edit_addtion_formula').val(data.formula);
                $('#edit_additon_number').val(data.addition_number);
                $('#edit_unit_calculation').val(data.unit_calculation).trigger('change');
                $('#edit_addition_employee_id').select2('val',[data.employee_id]);
                
                
                if(data.type === '1'){
                $("#edit_type").prop("checked",true)
                }else{
                $("#edit_type").prop("checked",false)
                }
                if(data.addition_bonus === '1'){
                 $("#edit_addition_bonus").prop("checked",true)
                }else{
                $("#edit_addition_bonus").prop("checked",false)
                }
                  
                if(data.fixed_value === '1'){
                $("#edit_fixed_value").prop("checked",true)
                }else{
                $("#edit_fixed_value").prop("checked",false)
                }
                
                $('.error').html('')
                },
            });

}
  $('#add_payroll_addition').submit(function(e) {
            e.preventDefault(); 
  			var unit_calculation = $('#unit_calculation').val()	
  			var unit_amount = $('#addtion_unit_name').val()
  			if(unit_amount > 100 && unit_calculation == '1'){
  			  alert('Unit Amount must be smaller than 100');
  			  return false;
  			}	
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('addPayrollAddition')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/payroll-index?activetab=addition";
                }else{
                console.log(data.errors)
                	$.each(data.errors, function( key, value ) {
                		$('#add_error_'+key).html(value)
                	})
                }
                },
            });
        });
        
       
        
          $('#update_payroll_addition').submit(function(e) {
            e.preventDefault(); 
            var unit_calculation = $('#unit_calculation').val()	
  			var unit_amount = $('#addtion_unit_name').val()
  			if(unit_amount > 100 && unit_calculation == '1'){
  			  alert('Unit Amount must be smaller than 100');
  			  return false;
  			}	
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('updatePayrollAddition')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/payroll-index?activetab=addition";
                }else{
                console.log(data.errors)
                	$.each(data.errors, function( key, value ) {
                		$('#add_error_'+key).html(value)
                	})
                }
                },
            });
        });
        
   
        
        
        
         
          $('#add_overtime').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('addPayrollOvertime')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/payroll-index?activetab=overtime";
                }else{
                console.log(data.errors)
                	$.each(data.errors, function( key, value ) {
                		$('#errors_overtime_'+key).html(value)
                	})
                }
                },
            });
        });
        $('.deleteAddition').click(function(){
          var id = $(this).data("id");
        	$.ajax({
                type: 'post',
                url: "{{ route('additionDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                window.location = "/payroll-index?activetab=addition";
                },
            });
        })
        
           $('.overtimeDelete').click(function(){
          var id = $(this).data("id");
        	$.ajax({
                type: 'post',
                url: "{{ route('overtimeDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                window.location = "/payroll-index?activetab=overtime";
                },
            });
        })
        
 function editOvertime(id)
 {
   $('#edit_overtimeModal').modal('show');
   $('#overtime_id').val(id)
      $.ajax({
                type: 'post',
                url: "{{ route('editPayrollOvertime')}}",
                data: "id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#edit_overtime_name').val(data.name)
                $('#edit_overtime_rate_type').val(data.rate_type).trigger('change')
                $('#edit_overtime_rate').val(data.rate)
                $('.error').html('')
                },
            });
 
 }
 
        $('#update_overtime').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('updatePayrollOvertime')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/payroll-index?activetab=overtime";
                }else{
                console.log(data.errors)
                	$.each(data.errors, function( key, value ) {
                		$('#add_error_'+key).html(value)
                	})
                }
                },
            });
        });
        
        
          $('#addDeductions').submit(function(e) {
            e.preventDefault(); 
  			var unit_calculation = $('#unit_calculation_deduction').val()	
  			var unit_amount = $('#deduction_amount').val()
  			if(unit_amount > 100 && unit_calculation == '1'){
  			  alert('Unit Amount must be smaller than 100');
  			  return false;
  			}	
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('addPayrollDeductions')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/payroll-index?activetab=deductions";
                }else{
                console.log(data.errors)
                	$.each(data.errors, function( key, value ) {
                		$('#add_error_'+key).html(value)
                	})
                }
                },
            });
        });
        function editDeduction(id)
        {
          $('#edit_deductionsmodal').modal('show');
             $('#deduction_id').val(id)
               $.ajax({
                type: 'post',
                url: "{{ route('editPayrollDeduction')}}",
                data: "id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#edit_deduction_name').val(data.name);
                $('#edit_deduction_category').val(data.category).trigger('change');
                $('#edit_deduction_amount').val(data.unit_amount);
                $('#edit_deduction_parameter').val(data.parameter);
                $('#edit_deduction_formula').val(data.formula);
                $('#edit_deduction_number').val(data.deduction_number);
                $('#edit_unit_calculation_deduction').val(data.unit_calculation).trigger('change');
                $('#edit_deduction_employee').select2('val',[data.employee_id]);
                
                if(data.type === '1'){
                $("#deduction_edit_type").prop("checked",true)
                }else{
                $("#deduction_edit_type").prop("checked",false)
                }
                if(data.fixed_value === '1'){
                $("#edit_deduct_fixed_value").prop("checked",true)
                }else{
                $("#edit_deduct_fixed_value").prop("checked",false)
                }
                
                
                $('.error').html('')
                },
            });
        }
          $('#editDeductions').submit(function(e) {
            e.preventDefault(); 
            	var unit_calculation = $('#edit_unit_calculation_deduction').val()	
  			var unit_amount = $('#edit_deduction_amount').val()
  			if(unit_amount > 100 && unit_calculation == '1'){
  			  alert('Unit Amount must be smaller than 100');
  			  return false;
  			}	
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('updatePayrollDeduction')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/payroll-index?activetab=deductions";
                }else{
                console.log(data.errors)
                	$.each(data.errors, function( key, value ) {
                		$('#add_error_'+key).html(value)
                	})
                }
                },
            });
        });
        
        
          $('.deductionDelete').click(function(){
          var id = $(this).data("id");
        	$.ajax({
                type: 'post',
                url: "{{ route('deductionDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                window.location = "/payroll-index?activetab=deductions";
                },
            });
        })
        
        
       setTimeout(function() {
	$('#success').hide();
 }, 3000);
 
        setTimeout(function() {
	$('#danger').hide();
 }, 3000);

</script>
</x-admin-layout>
