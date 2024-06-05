<?php

use App\Models\Permission;
use App\Models\RolesPermission;
?><div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-head-box">
                <h3>Leaves (Employee)</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Leaves</li>
                    </ol>
                </nav>
            </div>

            <div class="commonCards">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="commonCards__content">
                            <h4>20</h4>
                            <p>Annual Leave</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="commonCards__content">
                            <h4>8</h4>
                            <p>Medical Leave</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="commonCards__content">
                            <h4>0</h4>
                            <p>Other Leave</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="commonCards__content">
                            <h4>10</h4>
                            <p>Remaining Leave</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pageFilter mb-3">
                <div class="row">
                    <div class="col-xl-8">
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('filters',1, 'employee_leaves')&&RolesPermission::userpermissions('filters',1, 'employee_leaves')) )
                        <div class="leftFilters">
                            <div class="form-floating" wire:ignore>
                                <select class="form-select leave_type" id="floatingSelect" wire:model="search_leave_type" aria-label="Floating label  select example">
                                    <option value="">All</option>
                                    <option value="1">Casual Leave</option>
                                    <option value="2">Sick Leave</option>
                                    <option value="3">Earned Leave</option>
                                    <option value="4">Loss Of Pay</option>
                                </select>
                                <label for="floatingSelect">Leave Type</label>
                            </div>
        
                            <div class="form-floating" wire:ignore>
                                 <select class="form-select leave_status" id="floatingSelect"  wire:model="search_status"  aria-label="Floating label select example">
                                  <option  value="" selected>All</option>
                                  <option value="1">Pending </option>
                                  <option value="2">  Approved</option>
                                  <option value="3"> Rejected</option>
                                </select>
                                <label for="floatingSelect">Leave Status</label>
                            </div>

                            <div class="form-floating">
                                <input type="date" class="form-control " wire:model="fromsearch_date">

                                <label for="floatingInput">From</label>
                                <span class="form-control-icon">
                                    <!-- <img src="images/calenderIcon.svg" /> -->
                                </span>
                            </div>

                            <div class="form-floating">
                                <input type="date" class="form-control " wire:model="tosearch_date">

                                <label for="floatingInput">To</label>
                                <span class="form-control-icon">
                                    <!-- <img src="images/calenderIcon.svg" /> -->
                                </span>
                            </div>
        
                            <!-- <button class="btn btn-search"><img src="images/iconSearch.svg" /> Search here</button> -->
                        </div>
                        @endif
                    </div>
        
                    <div class="col-xl-4">
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',1, 'employee_leaves')&&RolesPermission::userpermissions('create',1, 'employee_leaves')) )

                        <div class="rightFilter">
                            <a class="addBtn"  data-bs-toggle="modal" data-bs-target="#leaveModal" href="javascript:void(0);"><i class="fa-solid fa-plus"></i> Add Leave</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        
            <div class="dashboardSection">
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
                        you want to Select All <strong>{{ $leaves->total() }}</strong>? 
                    </div>
                    @endif
                </div>
                @endif
                <div class="dashboardSection__body">
                    <div class="commonDataTable">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                         @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',1, 'employee_leaves')&&RolesPermission::userpermissions('delete',1, 'employee_leaves')) )
                                        <th>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" wire:model="selectPage" type="checkbox" value="" id="flexCheckDefault">
                                              </div>
                                        </th>
                                        @endif
                                        <!-- <th>Employee ID</th> -->
                                        <!-- <th>Employee</th> -->
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Leave Type</th>
                                        <th>Reason</th>
                                        <th>Leave Status</th>
                                        @if(((Auth::user()->user_role==0)||(Permission::userpermissions('update',1, 'employee_leaves')&&RolesPermission::userpermissions('update',1, 'employee_leaves')) )|| ((Auth::user()->user_role==0)||(Permission::userpermissions('delete',1, 'employee_leaves')&&RolesPermission::userpermissions('delete',1, 'employee_leaves')) ))

                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(empty($leaves) || count($leaves) == 0)
                                        <tr><td class="text-center" colspan="9">No Data Found</td></tr>
                                    @else    
                                        @foreach($leaves as $employ)
                                            <tr> 
                                                @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',1, 'employee_leaves')&&RolesPermission::userpermissions('delete',1, 'employee_leaves')) )

                                                <td>
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="checkbox" value="{{$employ->_id}}" id="flexCheckDefault"  wire:model="checked">
                                                    </div>
                                                </td>
                                                @endif
                                              
                                                <td>{{date('d M Y',strtotime($employ->from_date))}}</td>
                                                <td>{{date('d M Y',strtotime($employ->to_date))}}</td>
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
                                            
                                           
                                                @php
                                                if($employ->status==1){
                                                $employ->status='Pending';
                                                } 
                                                if($employ->status==2){
                                                $employ->status='Approve';
                                                }
                                                if($employ->status==3){
                                                $employ->status='Rejected';
                                                }
                                                @endphp 
                                         
                                                <td><span class="tags approve">{{($employ->status)}}</span></td>
                                                @if(((Auth::user()->user_role==0)||(Permission::userpermissions('update',1, 'employee_leaves')&&RolesPermission::userpermissions('update',1, 'employee_leaves')) )|| ((Auth::user()->user_role==0)||(Permission::userpermissions('delete',1, 'employee_leaves')&&RolesPermission::userpermissions('delete',1, 'employee_leaves')) ))
                                                 <td>
                                                    <div class="actionIcons">
                                                        <ul>
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',1, 'employee_leaves')&&RolesPermission::userpermissions('update',1, 'employee_leaves')) )

                                                            <li><a class="edit" data-bs-toggle="modal" data-bs-target="#leaveModal"  wire:click="edit('{{ $employ->id }}')" href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li>
                                                            @endif
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',1, 'employee_leaves')&&RolesPermission::userpermissions('delete',1, 'employee_leaves')) )

                                                            <li><button class="bin policyDelete" type="button "  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" wire:click="delete('{{$employ->id}}')"><i class="fa-regular fa-trash-can"></i></button></li>
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
                        </div>
                    </div>
                    <!-- common pagination starts -->
                    {{$leaves->links()}}

                    <!-- common pagination ends -->
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
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Choose Member</label>
                                <input type="text" class="form-control " wire:model="name"  disabled>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                      
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" wire:model="leave_type" >
                                    <option></option>
                                    <option value="all">all</option>
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
                                <input type="date"  wire:model="to_date" class="form-control " placeholder="Choose Date" />
                                <span class="form-control-icon">
                                    {{-- <img src="images/calenderIcon.svg" /> --}}
                                </span>
                            </div>
                            @error('to_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Remaining Leaves</label>
                                <input type="text" wire:model="remaining_leaves" class="form-control" placeholder="Enter Remaining Leaves" />
                                @error('remaining_leaves') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- <div class="col-lg-6"> --}}
                            {{-- <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" wire:model="status" >
                                    <option value=""></option>
                                    
                                    <option value="1">Approved</option>
                                    <option value="2">Rejected</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div> --}}
                        {{-- </div> --}}
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" wire:model="reason" placeholder="Enter Reason"></textarea>
                                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
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