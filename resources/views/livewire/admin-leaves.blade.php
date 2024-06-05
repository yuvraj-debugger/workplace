<?php

use App\Models\Permission;
use App\Models\RolesPermission;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
?><div>
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

            <div class="pageFilter mb-3">
                <div class="row">
                    <div class="col-xl-4">
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('filters',2, 'leaves')|| RolesPermission::userpermissions('filters',2, 'leaves')) )
                            <div class="leftFilters">
                                <div class="form-floating" wire:ignore>
                                    <select class="form-select employee_id"  wire:model="user_id" aria-label="Floating label  select example">
                                        <option value="all">All</option>
                                        @foreach($employees as $emp)
                                        <option value="{{$emp['_id']}}">{{$emp['first_name']}} {{$emp['last_name']}}</option>
                                        @endforeach
                                        
                                    </select>
                                    <label for="floatingSelect">Employee</label>
                                </div>
                                <!-- <button class="btn btn-search"><img src="{{ asset('/images/iconSearch.svg')}}" /> Search here</button> -->
                            </div>
                        @endif
                    </div>
        
                    <!-- <div class="col-xl-5">
                        <div class="rightFilter">
                            
                        <div class="rightFilter">
                            <a class="addBtn" wire:click="addform()"  data-bs-toggle="modal" data-bs-target="#leaveModal" href="javascript:void(0);"><i class="fa-solid fa-plus"></i> Add Leave</a>
                        </div>
                        </div>
                   
   
                    </div> -->
                </div>
            </div>
            <?php 
            $role=Role::where('_id',Auth::user()->user_role)->first();
            if((! empty(Auth::user()->user_role == 0)) || (!empty($role)&&($role->name=="HR") && (empty($this->created_id)))   ||  (!empty($role)&&($role->name=="Management") && (empty($this->created_id)))) {
            ?>
          
            <div class="commonCards">
                <div class="row">
                    <!-- <div class="col-lg-3 col-md-3 col-6">
                        <div class="commonCards__content">
                            <h4>{{$count}}/{{$employeecounting}}</h4>
                            <p>Today Presents</p>
                        </div>
                    </div> -->

                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="commonCards__content">
                            <h4>{{$planned_leaves}}</h4>
                            <p>Casual Leaves</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="commonCards__content">
                            <h4>{{$unplanned_leaves}}</h4>
                            <p>Sick Leaves</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="commonCards__content">
                            <h4>{{$loss_pay}}</h4>
                            <p>Loss of pay</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="commonCards__content">
                            <h4>{{$pending}}</h4>
                            <p>Pending Requests</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>

            <div class="pageFilter mb-3">
                <div class="row">
                    @if((Auth::user()->user_role==0)||(Permission::userpermissions('filters',2, 'admin_leaves')&&RolesPermission::userpermissions('filters',2, 'admin_leaves')) )
                    <!-- <div class="col-xl-7"> -->
                    <div class="col">
                        <div class="leftFilters">
                            <div class="form-group" wire:ignore>
                                <label for="floatingSelect">Leave Type</label>
                                <select class="form-select leave_type" id="floatingSelect" wire:model="search_leave_type" aria-label="Floating label  select example">
                                    <option value="">All</option>
                                    <option value="1">Casual Leave</option>
                                    <option value="2">Sick Leave</option>
                                    <option value="3">Earned Leave</option>
                                    <option value="4">Loss Of Pay</option>
                                </select>
                            </div>
        
                            <div class="form-group" wire:ignore>
                                <label for="floatingSelect">Leave Status</label>
                                <select class="form-select leave_status" id="floatingSelect"  wire:model="search_status"  aria-label="Floating label select example">
                                  <option  value="" selected>All</option>
                                  <option value="1">Pending </option>
                                  <option value="2">  Approved</option>
                                  <option value="3"> Rejected</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="floatingInput">From</label>
                                <input type="date" class="form-control " wire:model="fromsearch_date">
                                <span class="form-control-icon">
                                    {{-- <img src="images/calenderIcon.svg" /> --}}
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="floatingInput">To</label>
                                <input type="date" class="form-control " wire:model="tosearch_date">
                                <span class="form-control-icon">
                                    {{-- <img src="images/calenderIcon.svg" /> --}}
                                </span>
                            </div>
        
                            <!-- <button class="btn btn-search"><img src="images/iconSearch.svg" /> Search here</button> -->
                        </div>
                    </div>
                    @endif
                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2, 'leaves') || RolesPermission::userpermissions('create',2, 'leaves')) && ( ! empty($this->created_id)))
                    <!-- <div class="col-xl-5"> -->
                    <div class="col">
                        <div class="rightFilter">
                            <a class="addBtn" wire:click="addform()" data-bs-toggle="modal" data-bs-target="#leaveModal" href="javascript:void(0);"><i class="fa-solid fa-plus"></i> Add Leave</a>
                        </div>
                   
   
                    </div>
                    @endif
                </div>
            </div>
            <div class="dashboardSection">
              @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'leaves') || RolesPermission::userpermissions('delete',2, 'leaves')) )
                @if ($checked)
                    <div class="btn-group">
                         <button type="button" class="btn btn-secondary modalcanceleffect" style="background-color:red;" onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()"
                         wire:click="deleteRecords()">
                            Delete ({{ count($checked) }})
                        </button>
                    </div>
                @endif
                @if ($selectPage)
                <div class="col-md-10 mb-2">
                    @if ($selectAll)
                    <div>
                        You have selected all <strong>{{ $leaves->total() }}</strong> items.
                    </div>
                    @else
                    <div>
                        You have selected <strong>{{ count($checked) }}</strong> items, Do
                        you want to Select All <strong>{{ $leaves->total() }}</strong>? <button type="button" class="btn btn-secondary ml-2" wire:click="selectAll">Select All</button>
                    </div>
                    @endif
                </div>
                @endif
                @endif
                
                
                <div class="dashboardSection__body">
                    <div class="commonDataTable">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                          @php
                                                  $role = Role::where('_id', Auth::user()->user_role)->first();
                                                 @endphp
                                  @if(!empty($role)&&($role->name!='Employee') || (Auth::user()->user_role==0) || (!empty($role)&&($role->name=='HR')))
                                        <th>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" wire:model="selectPage" type="checkbox" value="" id="flexCheckDefault"> 
                                              </div>
                                        </th>
                                        @endif
                                        <th>Employee ID</th>
                                        <th>Employee</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Leave Type</th>
                                        <th>Reason</th>
                                        <th>Leave Status</th>
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
                                        <tr > 
                                    @if(!empty($role)&&($role->name!='Employee') || (Auth::user()->user_role==0) || (!empty($role)&&($role->name=='HR')))
                                            <td>
                                                <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" value="{{$employ->_id}}" wire:model="checked" id="flexCheckDefault">
                                                </div>
                                            </td>
                                            @endif
                                             <td>{{@$employ->getleaveemployee_name()->employee_id}}</td>
                                            <td>
                                                <div class="user-name">
                                                    <div class="user-image">
                                                        <img src="{{@$employ->getleaveemployee_name()->photo}}" alt="user-img" />
                                                    </div>
                                                    {{-- <span class="green">{{($employ->getleaveemployee_name())?$employ->getleaveemployee_name()->first_name:''}}</span> --}}
                                                    <span class="green">{{@$employ->getleaveemployee_name()->first_name}}</span>
                                                </div>
                                                <td>{{date('d M Y',strtotime($employ->from_date))}}</td>
                                                <td>{{date('d M Y',strtotime($employ->to_date))}}</td>
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
                                         @endphp
                                            <td>{{($employ->leave_type)}}</td>
                                            <td>{{$employ->reason}}</td>
                                        </td>
                                       
                                        @php
                                        if($employ->status==1){
                                         $employ->status='Pending';
                                        } 
                                        if($employ->status==2){
                                        $employ->status='Approved';
                                        }
                                        if($employ->status==3){
                                         $employ->status='Rejected';
                                         }
                                     @endphp 
                                     
                                     <td><span class="tags approve">{{($employ->status)}}</span></td>
                                     @if(((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'leaves')|| RolesPermission::userpermissions('update',2, 'leaves')) ) || ((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'leaves') || RolesPermission::userpermissions('delete',2, 'leaves')) ))
                                     <td>
                                         <div class="actionIcons">
                                             <ul>
                                                 @php
                                                  $role = Role::where('_id', Auth::user()->user_role)->first();
                                                 @endphp
                                                @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'leaves')|| RolesPermission::userpermissions('update',2, 'leaves')) ) 

                                                    <li><a class="edit" data-bs-toggle="modal" data-bs-target="#leaveModal"  wire:click="edit('{{ $employ->id }}')" href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li>
                                                 @endif
                                                 @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'leaves') || RolesPermission::userpermissions('delete',2, 'leaves')) )
                                                 
                                                    
          							 			 @if(!empty($role)&&($role->name!='Employee') || (Auth::user()->user_role==0) || (!empty($role)&&($role->name=='HR')))
                                                 <li><button class="bin policyDelete" type="button "  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" wire:click="delete('{{$employ->id}}')"><i class="fa-regular fa-trash-can"></i></button></li>
                                                 @endif
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
        </div>
    </div>  
    <!-- holiday modal starts -->
<div class="modal fade personalInfo" wire:ignore.self  id="leaveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($hideaddtitle)
                <h3 class="text-center">Add Leave</h3>
                @endif
                @if($hideedittitle)
                <h3 class="text-center">Edit Leave</h3>
               @endif
                <form class="px-3" wire:submit.prevent="submit" enctype="multipart/form-data">
                    <div class="row">
                     <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        
                        ?>
                        @if(Auth::user()->user_role==0)
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Choose Member</label>
                                <select class="form-control" wire:model="name">
                                    <option value="">Choose Member</option>
                                    @foreach($employees as $user)
                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                    @endforeach
                                </select>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Leave Type</label>
                                <select class="form-control" wire:model="leave_type" >
                                    <option value="">Select Leave</option>
                                    <option value="1">Casual Leave</option>
                                    <option value="2">Sick Leave</option>
                                    <option value="3">Earned Leave</option>
                                    <option value="4">Loss Of Pay</option>
                                </select>
                                @error('leave_type') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>From</label>
                                <input   type="date" wire:model="from_date" class="form-control " placeholder="Choose Date" />
                                <span class="form-control-icon">
                                    {{-- <img src="images/calenderIcon.svg" /> --}}
                                </span>
                                @error('from_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>To</label>
                                <input type="date"  wire:model="to_date" class="form-control"  id="txtDate" placeholder="Choose Date"  min="<?=date('Y-m-d')?>" />
                                <span class="form-control-icon">
                                    {{-- <img src="images/calenderIcon.svg" /> --}}
                                </span>
                            </div>
                            @error('to_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-lg-6">
                        <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        ?>
                            @if(((Auth::user()->user_role==0) || ($role->name=='HR'))  && (empty($this->created_id)) )
                            <div class="form-group">
                                <label>Status </label>
                                <select class="form-control" wire:model="status" >
                                    <option value="" selected>Select Status</option>
                                    <option value="2">Approve</option>
                                    <option value="3">Reject</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endif
                        </div>
                        @if(((Auth::user()->user_role==0))  || ! empty($this->created_id) )
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" wire:model="reason" placeholder="Enter Reason"></textarea>
                                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="form-group mt-4">
                                <button class="btn commonButton modalsubmiteffect">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- holidy modal ends --> 

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
@livewireScripts
<script type="text/javascript">
        window.livewire.on('userStore', (id) => {
            console.log(id);
            $('#'+id).modal('hide');
        });
</script>
<script>
    $(document).ready(function () {
        $('.leave_type').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('search_leave_type', $(this).val());
            

        });  $('.employee_id').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('user_id', $(this).val());
            

        });
    });
</script>
<script>



    $(document).ready(function () {
        $('.leave_status').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('search_status', $(this).val());
            

        });
    });
</script>
<script>

  $(function() {
    });
</script>

