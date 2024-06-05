<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Employee Salary</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Employee Salary</li>
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
                        {{ session('info') }}
                    </div>
				@endif
		      <div class="pageFilter mb-3">
                    <div class="row">
                        <div class="col-xl-8">
                          <form  method="get" action="">
                              <div class="leftFilters check employeeLeftFilter">
                                    <div class="col">
                                        <div class="form-group mt-0">
                                            <label for="floatingSelect">Employees</label>
                                            <select class="form-select user_list js-select2-employee" name="search_name"  id="floatingSelect" aria-label="Floating label select example">
                                                <option value='all' >All</option>
                                                     @foreach($employees as $emp)
                                        				<option value="{{$emp['_id']}}"  {{ ($employeeName == $emp['_id']) ? 'selected' : '' }}>{{$emp['first_name']}} {{$emp['last_name']}}(#{{$emp['employee_id']}}) </option>
                                        			@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mt-0">
                                            <label for="floatingSelect">Employment Status</label>
                                            <select class="form-select  user_status js-select2" name="search_status"  id="floatingSelect" aria-label="Floating label select example">
                                            <option value='all'>All</option>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl col-lg col-md col-sm buttons employee">
                                         <button type="submit" value="Submit" class="btn btn-search"><img src="images/iconSearch.svg" /> Search here</button>
                                         <button type="button" value="reset" class="btn btn-search" onclick="window.location='{{ url("employee-salary-index") }}'">Reset</button>
                                    </div>
                            	</div>
                            </form>
                        </div>
                        <div class="col-xl-4">
                            <div class="rightFilter employeeRightFilter mt-0">
                               <a href="{{route('addSalary')}}" class="addBtn employee" role="button">Add Salary</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dashboardSection__body">
                    <div class="commonDataTable">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                         <th>Employee</th>
                                         <th>Employee Id</th>
                                         <th>Joning Date</th>
                                         <th>Role</th>
                                         <th>Salary</th>
                                         <th>Generate Slip</th>
                                         <th>Status</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($employeeSalary as $salary)
                                        <tr> 
                                        <td>{{$salary->getEmployee()}}</td>
                                         <td>{{$salary->getEmployeeId()}}</td>
                                         <td>{{! empty($salary->getEmployeeJoiningDate()) ? date('F j, Y',strtotime($salary->getEmployeeJoiningDate())) : ''}}</td>
                                         <td>{{$salary->getEmployeeRole()}}</td>
                                         <td>{{$salary->net_salary}}</td>
                                         <td><a class="btn btn-sm btn-primary salary" href="/salary-slip/{{$salary->_id}}">Generate Slip</a></td>
                                         <?php 
                                         if($salary->status == '3'){
                                         ?>
                                          <td>
                                            <a class="edit" href="javascript:void();" >
                                                <!-- <i class="fas fa-check-circle"></i> -->
                                                <img class="approvedImg" src="{{asset ('images/checked.png')}}" />
                                            </a>
                                        </td>
                                         <?php }else{?>    
                                         <td><a class="edit approve" href="/salary/approve/{{$salary->_id}}" >Approve</a></td>
                                          <?php }?>
                                         
                                         
                                       <td>
                                          <?php 
                                          if(($salary->status == '1')){
                                         ?>
                                          <div class="actionIcons">
                                            <ul>
                                              <li><a class="edit" href="/salary/edit/{{$salary->_id}}" ><i class="fa-solid fa-pen"></i></a></li>
                                              
                                              <li><button class="bin bloodDelete salaryDelete ms-0 policyDelete"  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$salary->_id}}"><i class="fa-regular fa-trash-can"></i></button></li>
                                            </ul>
                                          </div>
                                           <?php }?>
                                         </td>
                                     
                                 </tr>
                                 @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
setTimeout(function() {
	$('#success').hide();
 }, 3000);
setTimeout(function() {
	$('#danger').hide();
 }, 3000);

  $(".salaryDelete").click(function(){
        var id = $(this).data("id");
        $.ajax({
                type: 'post',
                url: "{{ route('salaryDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                 window.location = "/employee-salary-index";                 
                },
            });
        });

</script>
</x-admin-layout>
