<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\RolesPermission;
use App\Models\Role;
?>
<x-admin-layout>
<style>
 /* #deleteAll {  
     color: #0d6efd;
    text-decoration: underline;
} */

</style>
<div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-head-box">
                <h3>Leaves</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Leaves</li>
                    </ol>
                </nav>
            </div>
            
            
             @if(session('success'))
                    <div class="alert alert-success" id="success">
                        {{ session('success') }}
                    </div>
				@endif
           
				   <?php                     $role=Role::where('_id',Auth::user()->user_role)->first();
                    ?>
                                            @if((Auth::user()->user_role==0)|| (!empty($role)&&($role->name!="Management")) || (Permission::userpermissions('filters',2, 'leaves')|| RolesPermission::userpermissions('filters',2, 'leaves')) )
                    
            <div class="pageFilter mb-3">
                <div class="row">
                    <div class="col-xxl-4 col-xl-6">
                 
                        <form  method="get" action="">
                            <div class="leftFilters">
                                <div class="col-lg-4 col-md-6 col-sm-6 form-group mt-0">
                                <label for="floatingSelect">Employee</label>
                                    <select class="form-select employee_id js-select2"  name="user_id" aria-label="Floating label  select example">
                                        <option value="all">All</option>
                                        @foreach($employees as $emp)
                                        <option value="{{$emp['_id']}}" {{ ($searchEmployee == $emp['_id']) ? 'selected' : '' }}>{{$emp['first_name']}} {{$emp['last_name']}}(#{{$emp['employee_id']}}) </option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <!-- <button class="btn btn-search"><img src="{{ asset('/images/iconSearch.svg')}}" /> Search here</button> -->
                                <div class="col-lg-8 col-md-6 col-sm-6">
                                    <div class="buttons leavedBtns">
                                         <button type="submit" value="Submit" class="btn btn-search topLeaves me-2"><img src="images/iconSearch.svg" /> Search here</button>
                                         <button type="button" value="reset" class="btn btn-search topLeaves" onclick="window.location='{{ url("leaves") }}'">Reset</button>

                                    </div>
                                    <!-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5">
                                    	<button type="button" value="reset" class="btn btn-search topLeaves" onclick="window.location='{{ url("leaves") }}'">Reset</button>
                                    </div> -->
                                </div>    
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
                                    @endif
            <?php 
            $role=Role::where('_id',Auth::user()->user_role)->first();
            if((! empty(Auth::user()->user_role == 0)) || (!empty($role)&&($role->name=="HR"))   ||  (!empty($role)&&($role->name=="Management"))) {
            ?>
          
<!--             <div class="commonCards"> -->
<!--                 <div class="row"> -->
                    <!-- <div class="col-lg-3 col-md-3 col-6">
<!--                         <div class="commonCards__content"> -->
<!--                             <h4>{{$count}}/{{$employeecounting}}</h4> -->
<!--                             <p>Today Presents</p> -->
<!--                         </div> -->
<!--                     </div> -->

<!--                     <div class="col-lg-3 col-md-3 col-6"> -->
<!--                         <div class="commonCards__content"> -->
<!--                             <h4>{{$planned_leaves}}</h4> -->
<!--                             <p>Casual Leaves</p> -->
<!--                         </div> -->
<!--                     </div> -->

<!--                     <div class="col-lg-3 col-md-3 col-6"> -->
<!--                         <div class="commonCards__content"> -->
<!--                             <h4>{{$unplanned_leaves}}</h4> -->
<!--                             <p>Sick Leaves</p> -->
<!--                         </div> -->
<!--                     </div> -->
<!--                     <div class="col-lg-3 col-md-3 col-6"> -->
<!--                         <div class="commonCards__content"> -->
<!--                             <h4>{{$loss_pay}}</h4> -->
<!--                             <p>Loss of pay</p> -->
<!--                         </div> -->
<!--                     </div> -->
<!--                     <div class="col-lg-3 col-md-3 col-6"> -->
<!--                         <div class="commonCards__content"> -->
<!--                             <h4>{{$pending}}</h4> -->
<!--                             <p>Pending Requests</p> -->
<!--                         </div> -->
<!--                     </div> -->
<!--                 </div> -->
<!--             </div> -->
            <?php }?>

            <div class="pageFilter mb-3">
                <div class="row leaves">
                    <div class="col-xl-9 col-lg-10 col-md-12">
                      <form  method="get" action="">
                        <div class="leftFilters">
                            <div class="col-xl-2 col-lg-2 form-group mt-0">
                            <!-- <div class="col-xl-3 col-lg-3 col-sm form-group leaves"> -->
                            <label for="floatingSelect">Leave Type</label>
                                <select class="form-select leave_type js-select2" id="floatingSelect" name="search_leave_type" aria-label="Floating label  select example">
                                    <option value="">All</option>
                                    <option value="1" {{ ($searchLeave == '1') ? 'selected' : '' }}>Casual Leave</option>
                                    <option value="2" {{ ($searchLeave == '2') ? 'selected' : '' }} >Sick Leave</option>
                                    <option value="3" {{ ($searchLeave == '3') ? 'selected' : '' }}>Earned Leave</option>
                                    <option value="4" {{ ($searchLeave == '4') ? 'selected' : '' }}>Loss Of Pay</option>
                                    <option value="5" {{ ($searchLeave == '5') ? 'selected' : '' }}>Comp - Off</option>
                                    <option value="6" {{ ($searchLeave == '6') ? 'selected' : '' }}>Bereavement Leave</option>
                                    <option value="7" {{ ($searchLeave == '7') ? 'selected' : '' }}>Maternity Leave</option>
                                    <option value="8" {{ ($searchLeave == '8') ? 'selected' : '' }}>Paternity Leave</option>
                                </select>
                                
                            </div>
        
                            <div class="col-xl-2 col-lg-2 form-group mt-0">
                            <!-- <div class="col-xl-3 col-lg-3 col-sm form-group leaves"> -->
                            <label for="floatingSelect">Leave Status</label>
                                <select class="form-select leave_status js-select2" id="floatingSelect"  name="search_status"  aria-label="Floating label select example">
                                  <option  value="" selected>All</option>
                                  <option value="1" {{ ($searchStatus == '1') ? 'selected' : '' }}>Pending </option>
                                  <option value="2" {{ ($searchStatus == '2') ? 'selected' : '' }}>  Approved</option>
                                  <option value="3" {{ ($searchStatus == '3') ? 'selected' : '' }}> Rejected</option>
                                </select>
                               
                            </div>

                            <div class="col-xl-2 col-lg-2 form-group mt-0">
                            <!-- <div class="col-xl-3 col-lg-2 col-sm form-group"> -->
                            <label for="floatingInput">From</label>
                                <input type="date" class="form-control leaves" name="fromsearch_date" value="{{$searchFromDate}}">
                                
                            </div>

                            <div class="col-xl-2 col-lg-2 form-group mt-0">
                            <!-- <div class="col-xl-3 col-lg-2 col-sm form-group"> -->
                            <label for="floatingInput">To</label>
                                <input type="date" class="form-control leaves" name="tosearch_date" value="{{$searchToDate}}">
                                
                            </div>
 							<div class="col-xl-2 col-lg-2 col-sm buttons leavedBtns">
                             <!-- <div class="col-xl col-lg-2 col-sm"> -->
                                <button type="submit" value="Submit" class="btn btn-search leaves me-2"><img src="images/iconSearch.svg" /> Search here</button>
                                <button type="button" value="reset" class="btn btn-search topLeaves" onclick="window.location='{{ url("leaves") }}'" style="cursor:pointer">Reset</button>
                                 
                            </div>
                            <!-- <div class="col-xl-2 col-lg-2 col-sm">
                             <div class="col-xl col-lg-2 col-sm"> -->
                            	<!-- <button type="button" value="reset" id='btnleaves' class="btn btn-search leaves" onclick="window.location='{{ url("leaves") }}'">Reset</button>
                            </div> --> 
                            </div>
                        </form>
                    
                         </div>
                        <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        
                        ?>
                         @if((Auth::user()->user_role==0) || (!empty($role)&&($role->name!="Management")))
                        <div class="col-xl-3">
                            <div class="rightFilter empLeaves">
                                <a class="addBtn leaves"  data-bs-toggle="modal" data-bs-target="#leaveModal" onclick="$('.error').html('')"><i class="fa-solid fa-plus"></i> Add Leave</a>
                            </div>
                    </div>
                    @endif
                            
                    </div>
                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2, 'leaves') || RolesPermission::userpermissions('create',2, 'leaves')))
                    <!-- <div class="col-xl-5"> -->
                   
                    @endif
                </div>
            </div>
            <div class="dashboardSection">
              @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'leaves') || RolesPermission::userpermissions('delete',2, 'leaves')) )
                
                @endif
                
                
                <div class="dashboardSection__body">
                    <div class="commonDataTable leavedTable">
                        <div class="table-responsive">
                        
                        
                            <div class="deleteSelection">
                                <a href="javascript:void(0);" id="deleteAll"  style="display: none;">Delete</a>
                            </div>
                        
                            <table class="table">
                            
                                <thead>
                                    <tr>
                                          @php
                                                  $role = Role::where('_id', Auth::user()->user_role)->first();
                                                 @endphp
                                  @if(!empty($role)&&($role->name!='Employee') || (Auth::user()->user_role==0) || (!empty($role)&&($role->name=='HR')))
                                        <th>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input select_all_ids"  type="checkbox" value="" id="flexCheckDefault"> 
                                              </div>
                                        </th>
                                        @endif
                                        <th>Employee ID</th>
                                        <th>Employee</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>No. of Days</th>
                                        <th>Leave Type</th>
                                        <th>Leave Status</th>
                                        <th>Updated By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(empty($leaves) || count($leaves) <= 0)
                                        <tr><td class="text-center" colspan="9">No Data Found</td></tr>
                                    @else
                                        @php
                                                  $role = Role::where('_id', Auth::user()->user_role)->first();
                                                 @endphp
                                    @foreach($leaves as $employ)
                                        <tr> 
                                    @if(!empty($role)&&($role->name!='Employee') || (Auth::user()->user_role==0) || (!empty($role)&&($role->name=='HR')))
                                            <td>
                                                <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input userDelete"  name="single_ids" type="checkbox" value="{{$employ->_id}}" id="flexCheckDefault">
                                                </div>
                                            </td>
                                            @endif
                                             <td>{{@$employ->getleaveemployee_name()->employee_id}}</td>
                                            <td>
                                                <div class="user-name">
                                                    <div class="user-image">
                                                        <img src="{{! empty($employ->getleaveemployee_name()) ? $employ->getleaveemployee_name()->photo : asset('/images/user.png')}}" alt="user-img" />
                                                    </div>
                                                    <span class="green"><a href="employee-profile/{{! empty($employ->getleaveemployee_name()) ? $employ->getleaveemployee_name()->_id: '';}}">{{! empty($employ->getleaveemployee_name()) ? $employ->getleaveemployee_name()->first_name :'';}} {{$employ->getleaveemployee_name() ? $employ->getleaveemployee_name()->last_name : ''}}
                                                    <?php 
                                                    if($employ->getleaveemployee_name()->status == '2'){
                                                        echo "<span class='empinactive'>(Inactive)</span>";
                                                    }elseif ($employ->getleaveemployee_name()->status == '3'){
                                                        echo "<span class='empdeleted'>(Deleted)</span>";
                                                    }
                                                    ?></a></span>
                                                </div>
                                                <td>{{date('d M Y',strtotime($employ->from_date))}}</td>
                                                <td>{{date('d M Y',strtotime($employ->to_date))}}</td>
                                                <td>{{$employ->getLeavesDay()}}</td>
                                            </td>
                                            @php
                                            if($employ->leave_type==1){
                                                $employ->leave_type='Casual leave';
                                            } 
                                            if($employ->leave_type==2){
                                                $employ->leave_type='Sick leave';
                                            }
                                            if($employ->leave_type==3){
                                                $employ->leave_type='Earned leave';
                                            }
                                            if($employ->leave_type==4){
                                                $employ->leave_type='LOP leave';
                                            }
                                            if($employ->leave_type =='5'){
                                                $employ->leave_type='Comp Off';
                                            }
                                            if($employ->leave_type =='6'){
                                                $employ->leave_type='Bereavement';
                                            }
                                             if($employ->leave_type =='7'){
                                                $employ->leave_type='Maternity Leave';
                                            }
                                              if($employ->leave_type =='8'){
                                                $employ->leave_type='Paternity Leave';
                                            }
                                            if($employ->leave_type =='9'){
                                                $employ->leave_type='Emergency Leave';
                                            }
                                         @endphp
                                            <td>{{($employ->leave_type)}}</td>
                                        </td>
                                       
                                        @php
                                               
                                        if($employ->status==1){
                                         $status='Pending';
                                        } 
                                        if($employ->status==2){
                                        $status='Approved';
                                        }
                                        if($employ->status==3){
                                         $status='Rejected';
                                         }
                                         if($employ->status==4){
                                         $status='Withdraw';
                                         }
                                     @endphp 
                                     
                                     <td><span class="tags approve">{{($status)}}</span></td>
                                     <td>
                                        @if($employ->updatedBy()) 
                                            <a style="color:#8dc542; font-weight:700"; href="{{url('/employee-profile')}}/{{$employ->updatedBy()->_id}}">{{$employ->updatedBy()->first_name.' '.$employ->updatedBy()->last_name}}</a>
                                        @else
                                        No Action
                                        @endif
                                     </td>
                                     @if(((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'leaves')|| RolesPermission::userpermissions('update',2, 'leaves')) ) || ((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'leaves') || RolesPermission::userpermissions('delete',2, 'leaves')) ))
                                     <td>
                                         <div class="actionIcons">
                                             <ul>
                                                 @php
                                                  $role = Role::where('_id', Auth::user()->user_role)->first();
                                                 @endphp
                                                 @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'leaves')|| RolesPermission::userpermissions('update',2, 'leaves')) ) 
                                                 @if(($employ->status == '1'))
                                                 
                                                  <li><a class="greentickcontainer" title="Approve" href="{{url('/updateLeave')}}/{{$employ->_id}}/{{$employ->name}}"><i class="fa fa-check greenshadetick" aria-hidden="true"></i></a></li>
                                                 @endif
                                                 @if(($employ->status == '1	'))
                                                   <li><a class="redcolorclose" title="Reject"  href="{{url('/rejectLeave')}}/{{$employ->_id}}/{{$employ->name}}"><i class="fa fa-close redshadeclose"></i></a></li>
                                                 @endif
                                                 
                                                 @endif
                                                 @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'leaves') || RolesPermission::userpermissions('delete',2, 'leaves')) )
                                                 <li><button class="bin eyeButtons edit ms-0" type="button" data-bs-toggle="modal" onclick="reasonView('{{$employ->id}}')"><i class="fa fa-eye" aria-hidden="true"></i></button></li>
                                                 
                                                 @endif
                                                 
                                                 
                                                 
                                             </ul>
                                         </div>
                                     </td>
                                     @endif
                                 </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{$leaves->links('pagination::bootstrap-4')}}

                        </div>
                    </div>
                </div>
            </div>  
            
            

<!-- Modal -->
<div class="modal fade commonModalNew" id="viewReason" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Reason</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     <div>
  		<span class="leavReason"></span>
	</div>
        </div>
      </div>
    </div>
  </div>
</div>

            
<div class="modal fade commonModalNew" id="leaveModal" tabindex="-1" aria-labelledby="leaveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="updateModalLabel">Add leave</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <span class="text-danger error" id="casual_error"></span>
           <form method="post" class="px-3" enctype="multipart/form-data" id="addLeave"> 
           
                    <div class="row">
                     <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        
                        ?>
                        @if((Auth::user()->user_role==0) || ($role->name=='HR'))
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Member</label>
                                <select class="form-control" name="name" id="all_members">
                                    <option value="">Choose Member</option>
                                    @foreach($employees as $user)
                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}} ({{$user->employee_id}})</option>
                                    @endforeach
                                </select>
                                 <span class="text-danger error" id="error_name"></span> 
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Leave Type</label>
                                <select class="form-control" name="leave_type" id="leave_types" >
                                    <option value="">Select Leave</option>
                                    <option value="1">Casual Leave</option>
                                    <option value="2">Sick Leave</option>
                                    <option value="3">Earned Leave</option>
                                    <option value="4">Loss Of Pay</option>
                                    <option value="5">Comp - Off</option>
									<option value="6">Bereavement Leave</option>
                                    <option value="7">Maternity Leave</option>
                                    <option value="8">Paternity Leave</option>
                                     <option value="9">Emergency Leave</option>
                                </select>
                                      <span class="text-danger error" id="error_leave_type"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>From</label>
                                <input   type="date" name="from_date" class="form-control " placeholder="Choose Date" />
                                 <span class="text-danger error" id="error_from_date"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
							<div class="form-group">
								<label>Sessions</label> 
								<select class="form-control"
									name="from_sessions" id="from_sessions">
									<option value="">Select Session</option>
									<option value="1">Session 1</option>
									<option value="2">Session 2</option>
								</select> <span
									class="text-danger error" id="error_from_sessions"></span>
							</div>
						</div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>To</label>
                                <input type="date"  name="to_date" class="form-control"  id="txtDate" placeholder="Choose Date" />
                            </div>
                                 <span class="text-danger error" id="error_to_date"></span> 
                        </div>
                        <div class="col-lg-6">
							<div class="form-group">
								<label>Sessions</label> 
								<select class="form-control"
									name="to_sessions" id="to_sessions">
									<option value="">Select Session</option>
									<option value="1">Session 1</option>
									<option value="2">Session 2</option>
								</select> <span
									class="text-danger error" id="error_to_sessions"></span>
							</div>
						</div>
                        <div class="col-lg-6">
                        <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        ?>
                            @if(((Auth::user()->user_role==0) || ($role->name=='HR')))
                            <div class="form-group">
                                <label>Status </label>
                                <select class="form-control" name="status" id="status">
                                    <option value="" selected >Select Status</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Approve</option>
                                    <option value="3">Reject</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endif
                        </div>
                        @if(((Auth::user()->user_role==0) || ($role->name=='HR')) )
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" name="reason" placeholder="Enter Reason"></textarea>
                                <span class="text-danger error" id="error_reason"></span> 
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="form-group mt-4 text-end">
                                
                                        <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>
                                        <button class="btn commonButton modalsubmiteffect">Submit</button>
                                
                            </div>
                        </div>
                    </div>
                </form>
      </div>
    </div>
  </div>
</div>     



<div class="modal fade commonModalNew" id="updateleaveModal" tabindex="-1" aria-labelledby="updateleaveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="updateModalLabel">Edit leave</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" class="px-3" enctype="multipart/form-data" id="editLeave"> 
                                 			<input type="hidden" name="employee_id" id="employee_id" value="">
           
                    <div class="row">
                     <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        
                        ?>
                        @if((Auth::user()->user_role==0)|| ($role->name=='HR'))
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Choose Member</label>
                                 <input type="text" id="single_employee" class="form-control" value="" disabled>
                                 <span class="text-danger error" id="error_name"></span> 
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Leave Type</label>
                                <select class="form-control" name="leave_type" id="edit_leave_types" disabled >
                                    <option value="">Select Leave</option>
                                    <option value="1">Casual Leave</option>
                                    <option value="2">Sick Leave</option>
                                    <option value="3">Earned Leave</option>
                                    <option value="4">Loss Of Pay</option>
                                    <option value="5">Comp Off</option>
                                    <option value="6">Bereavement Leave</option>
                                    <option value="7">Maternity Leave</option>
                                    <option value="8">Paternity Leave</option>
                                    <option value="9">Emergency Leave</option>
                                </select>
                                      <span class="text-danger error" id="errors_leave_type"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>From</label>
                                <input   type="date" name="from_date" id="editDate" class="form-control " value="" placeholder="Choose Date" disabled/>
                                 <span class="text-danger error" id="errors_from_date"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>To</label>
                                <input type="date"  name="to_date" class="form-control"  id="toDate" value="" placeholder="Choose Date" disabled/>
                                  <span class="text-danger error" id="errors_to_date"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6" id="statusCheck">
                        <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        ?>
                            @if(((Auth::user()->user_role==0) || ($role->name=='HR') || ($role->name=='Management') ))
                            <div class="form-group">
                                <label>Status </label>
                                <select class="form-control" name="status" id="edit_status">
                                    <option value="" selected>Select Status</option>
                                     <option value="1">Pending</option>
                                    <option value="2">Approve</option>
                                    <option value="3">Reject</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endif
                        </div>
                        @if(((Auth::user()->user_role==0)))
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" name="reason" placeholder="Enter Reason" id="editReason" disabled></textarea>
                                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @else
                         <div class="col-lg-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" name="reason" placeholder="Enter Reason" id="editReason" disabled></textarea>
                                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="form-group mt-4 addoffmodalfoot" >
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                <button class="btn commonButton ml-1">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
function reasonView(id)
{

  $('#viewReason').modal('show');
  
      $.ajax({
                type: 'post',
                url: "{{ route('reasonView')}}",
                data: "id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('.leavReason').text(data.reason)
                
                },
            });

}



 $(function(){
  $('#edit_leave_types').select2({
    dropdownParent: $('#updateleaveModal')
  });
}); 


 $(function(){
  $('#edit_status').select2({
    dropdownParent: $('#updateleaveModal')
  });
}); 


 $(function(){
  $('#all_members').select2({
    dropdownParent: $('#leaveModal')
  });
}); 

 $(function(){
  $('#from_sessions').select2({
    dropdownParent: $('#leaveModal')
  });
});

 $(function(){
  $('#to_sessions').select2({
    dropdownParent: $('#leaveModal')
  });
});

 $(function(){
  $('#leave_types').select2({
    dropdownParent: $('#leaveModal')
  });
}); 
 $(function(){
  $('#status').select2({
    dropdownParent: $('#leaveModal')
  });
}); 
function editLeave(id)
{

  $('#updateleaveModal').modal('show');
  $('#employee_id').val(id);
  var id_ = $('#employee').val();
  
  

      $.ajax({
                type: 'post',
                url: "{{ route('editLeave')}}",
                data: "id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                console.log(data.id);
                console.log('{{Auth::user()->_id}}');
                  if(data.id==='{{Auth::user()->_id}}')
                  {
                  console.log(true)
                  	$('#statusCheck').hide();
                  }else
                  {
                  	$('#statusCheck').show();
                  }
                $('#single_employee').val(data.employeeName);
                $('#edit_leave_types').val(data.leave_type).trigger('change');
                $('#editDate').val(data.from_date);
                $('#toDate').val(data.to_date);
                $('#edit_status').val(data.status).trigger('change');
                $('#editReason').val(data.reason);
                $('.error').html('')
                
                },
            });
}


$('#deleteAll').hide();
$('.select_all_ids').click(function(){
    $('.userDelete').prop('checked',$(this).prop('checked'));
});
$('input[type=checkbox]').click(function(){
    var check=0;
    $('input[type=checkbox]').each(function () {
        checked=$(this).is(":checked");
        console.log(checked);
        if(checked)
        {
        	check=1
        }
    });
    
    
    if(check)
    {
    	$('#deleteAll').show();
    }
    else
    {
    	$('#deleteAll').hide();
    }
});

$('#deleteAll').click(function(e){
		e.preventDefault();
		var all_ids = [];
        $('input:checkbox[name="single_ids"]:checked').each(function(){
        	all_ids.push($(this).val());
       });

   		 $.ajax({
                type: 'post',
                url: "{{ route('leaveDelete')}}",
                data: "all_ids="+all_ids+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                   location.reload(true);
                }
            });
});
 $('.error').html('');
 $(document).ready(function() {
                  $('.error').html('');
 
  $('#addLeave').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $(".commonButton").attr("disabled", true);
            $.ajax({
                type: 'post',
                url: "{{ route('addLeave')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                 $('.error').html('');
      			if($.isEmptyObject(data.errors)){
     			window.location = "/leaves";
     		    $(".commonButton").attr("disabled", false);
                }else{
                	$.each( data.errors, function( key, value ) {
                	$('#casual_error').html(data.errors.message);
                		$('#error_'+key).html(value)
                	})
                }
                },
            });
        });
});


 $(".leaveDelete").click(function(){
        var id = $(this).data("id");
        $.ajax({
                type: 'post',
                url: "{{ route('singleDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
        });


    setTimeout(function() {
    	$('#danger').hide();
     }, 3000);
    
    setTimeout(function() {
    	$('#success').hide();
     }, 3000);
     
</script>    
</x-admin-layout>