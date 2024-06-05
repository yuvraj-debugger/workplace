<?php

use App\Models\Permission;
use App\Models\RolesPermission;
?><div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-head-box">
                <h3>Employees</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Employees</li>
                    </ol>
                </nav>
            </div>
            <div class="pageFilter mb-3">
                <div class="row">
                    <div class="col-xl-7">
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('filters',1, 'employees')&&RolesPermission::userpermissions('filters',1, 'employees')) ) 
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group mt-0">
                                        
                                        <label for="floatingSelect">Employees</label>
                                        <div wire:ignore><select class="form-control" name="search_name[]" id="search_name" multiple="multiple" id="search_name" aria-label="Floating label select example">
                                            @foreach($employee as $user)
                                                <option value="{{$user->_id}}">{{$user->first_name}} {{$user->last_name}} ({{$user->employee_id}})</option>
                                            @endforeach
                                        </select>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mt-0" wire:ignore>
                                        <label for="floatingSelect">Designation</label>
                                        <select class="form-select user_designation" id="floatingSelect" wire:model="search_designation"  aria-label="Floating label select example">
                                        <option value="" selected>All</option>
                                        @foreach($designations as $designation)
                                                <option value="{{$designation->_id}}">{{$designation->title}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group mt-0" wire:ignore>
                                        <label for="floatingSelect " >Employment Status</label>
                                        <select class="form-select  user_status" wire:model="search_status"  id="floatingSelect" aria-label="Floating label select example">
                                        <option value='all' selected>All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mt-0" wire:ignore>
                                        <label for="floatingSelect">Roles</label>
                                        <select class="form-select user_role" wire:model="search_role"  id="floatingSelect" aria-label="Floating label select example">
                                            <option value='' selected>All</option>
                                            <option value='0' >Admin</option>
                                            @foreach($roles as $user)
                                                <option value="{{$user->_id}}">{{ucfirst(str_replace('_',' ',$user->name))}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>
                               <div class="col-lg-3">
                                    <div class="form-group mt-0" wire:ignore>
                                                <label for="floatingSelect">Gender</label>
                                                 <select class="form-select search_gender " wire:model="search_gender" id="floatingSelect" aria-label="Floating label select example">
                                                <option value='all' selected>All</option>
                                                <option value="male">Male</option>
                                                <option value="female" >Female</option>
                                                <option value="other">Other</option>
                                                </select>
                                     </div>
                               </div>
                                
                                
                                <!-- <button class="btn btn-search"><img src="images/iconSearch.svg" /> Search here</button>  -->
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-5">
                        <div class="rightFilter employeeRightFilter mt-1">
                            @if((Auth::user()->user_role==0)||(Permission::userpermissions('export',1, 'employees')&&RolesPermission::userpermissions('export',1, 'employees')) ) 

                            <button class="" wire:click="exportData()" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Export">
                                <svg width="30" height="27" viewBox="0 0 30 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 3.375C0 1.51348 1.49479 0 3.33333 0H11.6667V6.75C11.6667 7.6834 12.4115 8.4375 13.3333 8.4375H20V15.1875H11.25C10.5573 15.1875 10 15.7518 10 16.4531C10 17.1545 10.5573 17.7188 11.25 17.7188H20V23.625C20 25.4865 18.5052 27 16.6667 27H3.33333C1.49479 27 0 25.4865 0 23.625V3.375ZM20 17.7188V15.1875H25.7344L23.7031 13.1309C23.2135 12.6352 23.2135 11.8336 23.7031 11.3432C24.1927 10.8527 24.9844 10.8475 25.4688 11.3432L29.6354 15.5619C30.125 16.0576 30.125 16.8592 29.6354 17.3496L25.4688 21.5684C24.9792 22.0641 24.1875 22.0641 23.7031 21.5684C23.2188 21.0727 23.2135 20.2711 23.7031 19.7807L25.7344 17.724H20V17.7188ZM20 6.75H13.3333V0L20 6.75Z" fill="#1F1F1F"/>
                                </svg>
                            </button>
                            @endif
                            @if((Auth::user()->user_role==0)||(Permission::userpermissions('import',1, 'employees')&&RolesPermission::userpermissions('import',1, 'employees')) ) 

        
<!--                             <a href="" data-bs-toggle="modal" data-bs-target="#import_info"  ><button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Import" class=""> -->
<!--                                 <svg width="22" height="26" viewBox="0 0 22 26" fill="none" xmlns="http://www.w3.org/2000/svg"> -->
<!--                                     <path d="M11.9375 10.2498H10.0625V4.07515L6.97578 7.16304C6.79987 7.33896 6.56128 7.43778 6.3125 7.43778C6.06372 7.43778 5.82513 7.33895 5.64922 7.16304C5.47331 6.98713 5.37448 6.74854 5.37448 6.49976C5.37448 6.25098 5.47331 6.01239 5.64922 5.83648L10.3367 1.14898C10.4238 1.06181 10.5272 0.992665 10.641 0.945486C10.7548 0.898307 10.8768 0.874023 11 0.874023C11.1232 0.874023 11.2452 0.898307 11.359 0.945486C11.4728 0.992665 11.5762 1.06181 11.6633 1.14898L16.3508 5.83648C16.5267 6.01239 16.6255 6.25098 16.6255 6.49976C16.6255 6.74854 16.5267 6.98713 16.3508 7.16304C16.1749 7.33896 15.9363 7.43778 15.6875 7.43778C15.4387 7.43778 15.2001 7.33896 15.0242 7.16304L11.9375 4.07515V10.2498ZM19.4375 10.2498H11.9375V14.9373C11.9375 15.1859 11.8387 15.4244 11.6629 15.6002C11.4871 15.776 11.2486 15.8748 11 15.8748C10.7514 15.8748 10.5129 15.776 10.3371 15.6002C10.1613 15.4244 10.0625 15.1859 10.0625 14.9373V10.2498H2.5625C2.06522 10.2498 1.58831 10.4473 1.23667 10.7989C0.885044 11.1506 0.6875 11.6275 0.6875 12.1248V23.3748C0.6875 23.872 0.885044 24.349 1.23667 24.7006C1.58831 25.0522 2.06522 25.2498 2.5625 25.2498H19.4375C19.9348 25.2498 20.4117 25.0522 20.7633 24.7006C21.115 24.349 21.3125 23.872 21.3125 23.3748V12.1248C21.3125 11.6275 21.115 11.1506 20.7633 10.7989C20.4117 10.4473 19.9348 10.2498 19.4375 10.2498Z" fill="#1F1F1F"/> -->
<!--                                 </svg> -->
<!--                             </button> -->
<!--                             </a> -->
                            @endif
                            <a href="{{url('/employee?search_status=1')}}">
                            <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Grid View" class="">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.6875 10.1251C1.43886 10.1251 1.2004 10.0263 1.02459 9.85049C0.848772 9.67468 0.75 9.43622 0.75 9.18758V1.68945C0.75 1.44081 0.848772 1.20236 1.02459 1.02654C1.2004 0.850725 1.43886 0.751953 1.6875 0.751953H9.1875C9.43614 0.751953 9.6746 0.850725 9.85041 1.02654C10.0262 1.20236 10.125 1.44081 10.125 1.68945V9.18758C10.125 9.43622 10.0262 9.67468 9.85041 9.85049C9.6746 10.0263 9.43614 10.1251 9.1875 10.1251H1.6875ZM14.8125 10.1251C14.5639 10.1251 14.3254 10.0263 14.1496 9.85049C13.9738 9.67468 13.875 9.43622 13.875 9.18758V1.68945C13.875 1.44081 13.9738 1.20236 14.1496 1.02654C14.3254 0.850725 14.5639 0.751953 14.8125 0.751953H22.3106C22.5593 0.751953 22.7977 0.850725 22.9735 1.02654C23.1494 1.20236 23.2481 1.44081 23.2481 1.68945V9.18758C23.2481 9.43622 23.1494 9.67468 22.9735 9.85049C22.7977 10.0263 22.5593 10.1251 22.3106 10.1251H14.8125ZM1.6875 23.2501C1.43886 23.2501 1.2004 23.1513 1.02459 22.9755C0.848772 22.7997 0.75 22.5612 0.75 22.3126V14.8126C0.75 14.5639 0.848772 14.3255 1.02459 14.1497C1.2004 13.9739 1.43886 13.8751 1.6875 13.8751H9.1875C9.43614 13.8751 9.6746 13.9739 9.85041 14.1497C10.0262 14.3255 10.125 14.5639 10.125 14.8126V22.3126C10.125 22.5612 10.0262 22.7997 9.85041 22.9755C9.6746 23.1513 9.43614 23.2501 9.1875 23.2501H1.6875ZM14.8125 23.2501C14.5639 23.2501 14.3254 23.1513 14.1496 22.9755C13.9738 22.7997 13.875 22.5612 13.875 22.3126V14.8126C13.875 14.5639 13.9738 14.3255 14.1496 14.1497C14.3254 13.9739 14.5639 13.8751 14.8125 13.8751H22.3106C22.5593 13.8751 22.7977 13.9739 22.9735 14.1497C23.1494 14.3255 23.2481 14.5639 23.2481 14.8126V22.3126C23.2481 22.5612 23.1494 22.7997 22.9735 22.9755C22.7977 23.1513 22.5593 23.2501 22.3106 23.2501H14.8125Z" fill="#1F1F1F"/>
                                </svg>
                            </button>
                            </a>
                          
                           <!--  <a  href="{{route('admin.employee-list')}}"> <button class="">
                                <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 17.875C22.4815 17.8752 22.9445 18.0607 23.293 18.393C23.6415 18.7253 23.8488 19.1789 23.8719 19.6599C23.895 20.1409 23.7323 20.6123 23.4173 20.9765C23.1023 21.3407 22.6593 21.5698 22.18 21.6162L22 21.625H2C1.51848 21.6248 1.05551 21.4393 0.707017 21.107C0.358527 20.7747 0.151235 20.3211 0.128095 19.8401C0.104954 19.3591 0.26774 18.8877 0.582719 18.5235C0.897699 18.1593 1.34073 17.9302 1.82 17.8838L2 17.875H22ZM22 9.125C22.4973 9.125 22.9742 9.32254 23.3258 9.67417C23.6775 10.0258 23.875 10.5027 23.875 11C23.875 11.4973 23.6775 11.9742 23.3258 12.3258C22.9742 12.6775 22.4973 12.875 22 12.875H2C1.50272 12.875 1.02581 12.6775 0.674175 12.3258C0.322544 11.9742 0.125 11.4973 0.125 11C0.125 10.5027 0.322544 10.0258 0.674175 9.67417C1.02581 9.32254 1.50272 9.125 2 9.125H22ZM22 0.375C22.4973 0.375 22.9742 0.572544 23.3258 0.924175C23.6775 1.27581 23.875 1.75272 23.875 2.25C23.875 2.74728 23.6775 3.22419 23.3258 3.57583C22.9742 3.92746 22.4973 4.125 22 4.125H2C1.50272 4.125 1.02581 3.92746 0.674175 3.57583C0.322544 3.22419 0.125 2.74728 0.125 2.25C0.125 1.75272 0.322544 1.27581 0.674175 0.924175C1.02581 0.572544 1.50272 0.375 2 0.375H22Z" fill="#1F1F1F"/>
                                </svg>
                            </button>
                        </a> -->
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',1, 'employees')&&RolesPermission::userpermissions('create',1, 'employees')) )
        
                            <a class="addBtn"  href="{{route('addEmployee')}}?route={{Route::currentRouteName()}}"><i class="fa-solid fa-plus"></i> Add Employee</a>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dashboardSection">
                <div class="dashboardSection__body pt-0 px-0">
                    <div class="commonDataTable">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Email</th>
                                        <th>Joining Date</th>
                                        <th>Phone</th>
                                        <th>User Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($users) > 0)

                                    @foreach($users as $employ)
                                    <tr>
                                        <td>{{$employ->employee_id}}</td>
                                        <td>
                                            <a href="{{url('/profile')}}/{{$employ->_id}}">
                                            <div class="user-name">
                                                <div class="user-image">
                                                    @if($employ->photo != '')
                                                    <img src="{{ $employ->photo}}" alt="user-img" />
                                                    @else

                                                        <img src="{{asset('/images/user-default-image.jpg')}}" alt="user-img">
                                                    @endif
                                                </div>
                                                <span class="green">{{$employ->first_name}} {{$employ->last_name}}<br/><span style="color:#FF7849" class="ps-0">{{$employ->departMentAll()}}</span></span>
                                            </div>
                                            </a>
                                        </td>
                                        <td>{{$employ->email}}</td>
                                        <td>{{date('d M Y',strtotime($employ->joining_date))}}</td>
                                        <td><span>{{$employ->contact}}</span></td>
                                        <td>
                                            @if(!empty($employ-> get_userrole())||$employ->user_role==0)
                                            <span>{{(ucfirst(str_replace('_',' ',$employ->get_userrole())?$employ-> get_userrole()->name:'Admin'))}}</span>
                                        @endif</td>
                                        <td><span><?php 
                                        if($employ->status==1){
                                            echo "Active";
                                        }elseif ($employ->status==2){
                                            echo "Inactive";
                                        }else{
                                            echo "Deleted";
                                        }
                                        
                                        ?></span></td>
                                        <td>
                                        <div class="actionIcons">
                                                <ul>
                                                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',1, 'employees')&&RolesPermission::userpermissions('update',1, 'employees')))
                                                    <li><a class="edit"href="/employee/update/{{$employ->_id}}"><i class="fa-solid fa-pen"></i></a></li>
                                                    @endif
                                                    
                                                        @if($employ->status != '3')
                                                         @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',1, 'employees')&&RolesPermission::userpermissions('delete',1, 'employees'))) 
                                                            @if(Auth::user()->_id != $employ->id && $employ->user_role != 0)
                                                   
                                                            <li><button class="bin policyDelete ms-0"  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" wire:click="delete('{{$employ->_id}}')" type="button"><i class="fa-regular fa-trash-can"></i></button></li>
                                                        @endif
                                                        @endif
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="11">No Data Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                             {{$users->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- personal info modal starts -->
<div class="modal fade personalInfo"  wire:ignore.self id="personalInfo" data-bs-backdrop="static" data-bs-keyboard="false"  
aria-labelledby="staticBackdropLabel" aria-hidden="true" >
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="mymodal">
            @if($hideaddtitle)
            <h3 class="text-center">Add Employee</h3>
            @endif
            @if($hideedittitle)
            <h3 class="text-center">Edit Employee</h3>
           @endif
      <form wire:submit.prevent="submit" enctype="multipart/form-data" autocomplete="false">
            <div class="userProfileSection">
                @if($photo)
                <img src="{{$photo->temporaryUrl()}}" />
                @else
                <img src="{{$image}}"/>
                @endif
                <span>
                    edit
              <input title="Upload Image"  type="file" wire:model="photo"  />
              <img id="preview" src="#" alt="your image" class="mt-3" style="display:none;"/>
              @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                </span>
            </div>
            @if($hideid)
            <h3 class="text-center green mt-4">{{$employee_id}}</h3>
            @endif
            <input type="hidden" wire:model="User_id">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name">First Name<sup>*</sup></label>
                            <input name="name" type="text" class="form-control" wire:model="first_name" placeholder="First Name" />
                            @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Last Name<sup>*</sup></label>
                            <input type="text" class="form-control" wire:model="last_name" placeholder="Last Name" />
                            @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Email<sup>*</sup></label>
                            <input name="email" type="email"  wire:model="email" class="form-control" placeholder="Enter Email" />
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label> Password<sup>*</sup></label>
                            <input type="password" class="form-control"  wire:model="password" placeholder="Enter Password" autocomplete="new-password"/>
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Birth Date<sup>*</sup></label>
                            <input type="date" class="form-control " wire:model="date_of_birth" placeholder="Birth Date" />
                            <span class="form-control-icon">
                                {{-- <img src="images/calenderIcon.svg" /> --}}
                            </span>
                            @error('date_of_birth') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="date">Joining Date<sup>*</sup></label>
                            <input name="date" type="date"  class="form-control " wire:model="joining_date"    placeholder="Joining Date" />
                            <span class="form-control-icon">
                                {{-- <img src="images/calenderIcon.svg" /> --}}
                            </span>
                            @error('joining_date') <span class="text-danger">{{ $message }}</span> @enderror

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Phone<sup>*</sup></label>
                            <input type="number" class="form-control" wire:model="contact" placeholder="Enter Phone" />
                            @error('contact') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="dapartment">Select Department<sup>*</sup></label>
                            <select name="dapartment"  id="department" class="form-control js-select2"  wire:model="department">
                                <option selected value="">Select Department</option>
                                @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->title}}</option>
                                {{-- <option value="2">DevOps</option> --}}
                                @endforeach
                            </select>
                            @error('department') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="designation">Select Designation<sup>*</sup></label>
                            <select name="designation" id="designation" class="form-control js-select2" wire:model="designation" >
                                <option selected value="">Select Designation</option>
                                @foreach($designations as $designation)
                                <option value="{{$designation->id}}">{{$designation->title}}</option>
                                {{-- <option value="2">DevOps</option> --}}
                                @endforeach
                            </select>
                            @error('designation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6" wire:ignore.self>
                        <div class="form-group"  >
                            <label class="d-block">Select Reporting Manager</label>
                            <select class="form-control manager js-select2" wire:model="reporting_manager"  id="reporting_manager">
                                <option value='option-1' data-src="images/userImg.png">Reporting Manager</option>
                                @foreach($employee as $user)
                                <option value='{{$user->_id}}' data-src="http://placehold.it/45x45">{{$user->first_name}}</option>
                            @endforeach
                            </select>
                            @error('reporting_manager') <span class="text-danger">{{ $message }}</span>@enderror 
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group"  wire:ignore.self>
                            <label>Can this user login to the app?<sup>*</sup></label>
                            <select class="form-control js-select2" id="app_login"  wire:model="app_login">
                                <option selected>Select </option>
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                            @error('app_login') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group"  wire:ignore.self>
                            <label>Can this user receive email noification?<sup>*</sup></label>
                            <select class="form-control js-select2" id="email_notification" wire:model="email_notification">
                                <option selected>Select </option>
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                            @error('email_notification') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group"  wire:ignore.self>
                            <label>Workplace<sup>*</sup></label>
                            <select class="form-control js-select2" id="workplace" wire:model="workplace">
                                <option selected>Select Workplace</option>
                                <option value="0">WFH</option>
                                <option value="1">WFO</option>
                            </select>
                            @error('workplace') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                       
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group"  wire:ignore.self>
                            <label>Status<sup>*</sup></label>
                            <select class="form-control js-select2"  id="user_status" wire:model="status">
                                <option  value="" selected>Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                          
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" wire:ignore.self >
                            <label>User Role<sup>*</sup></label>
                            <select class="form-control js-select2"  id="user_role" wire:model="user_role">
                                <option  value="" selected>Select User Role</option>
                                @foreach($roles as $user)
                                <option value="{{$user->id}}" > {{$user->name}}</option>
                                @endforeach
                            </select>
                  @error('user_role') <span class="text-danger">{{ $message }}</span> @enderror
                  
                          
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
<!-- personal info modal ends -->
<!-- Import info modal starts -->
<div class="modal fade personalInfo"  wire:ignore.self id="import_info" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form wire:submit.prevent="import" enctype="multipart/form-data" >
                <div class="form-group">
                    <label for="name">Upload data<sup>*</sup></label>
                    <input  type="file"  wire:model="upload_data" class="form-control"     />
                      @error('upload_data') <span class="text-danger">{{ $message }}</span> @enderror

                </div>
                <div class="col-lg-12">
                    <div class="form-group mt-4">
                        <button class="btn commonButton modalsubmiteffect">Submit</button>
                    </div>
                </div>
            </form>
           
        </div>
    </div>
</div>
</div>
<!-- Import info modal ends -->
</div>


@livewireScripts
    <script type="text/javascript">
        window.livewire.on('userStore', (id) => {
            console.log(id);
            $('#'+id).modal('hide');
        });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $('.user_designation').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('search_designation', $(this).val());
            // livewire.emit('render', e.target.value)

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.search_gender').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('search_gender', $(this).val());

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.user_status').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('search_status', $(this).val());
            // livewire.emit('render', e.target.value)

        });
        $('#search_name').select2({
				placeholder: "Select user"
			});
			$('#search_name').on('change', function(e) {
				var data = $('#search_name').select2("val");
				@this.set('search_name', data);
			});
    });
</script>

<script>
    $(document).ready(function () {
        $('.user_designation').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('search_designation', $(this).val());
            // livewire.emit('render', e.target.value)

        });
    });
</script>
<script>

$(document).ready(function () {
    $('#status_check').select2();
       
    });

 
</script>
<script>

    $(document).ready(function () {
            $('.user_role').select2({
                tags: false,
                multiple: false
            }).on('change', function (e) {
               @this.set('search_role', $(this).val());
                // livewire.emit('render', e.target.value)
    
            });
        });
    
     
    </script>


<script>
    $(document).ready(function () {
        $('.user_status').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('search_status', $(this).val());
            // livewire.emit('render', e.target.value)

        });
    });
</script>

<script>
     $(document).ready(function () {
    $("#reporting_manager").select2();
    document.addEventListener('livewire:update', function (event) {
        $("#reporting_manager").select2({
            dropdownParent: $('#personalInfo')
        });
    });
     $("#reporting_manager").change(function(e) {
        @this.set('reporting_manager', $(this).val(), true)
     })
    });
</script>
<script>
    $(document).ready(function () {
   $("#designation").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#designation").select2({
           dropdownParent: $('#personalInfo')
       });
   });
    $("#designation").change(function(e) {
       @this.set('designation', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#department").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#department").select2({
           dropdownParent: $('#personalInfo')
       });
   });
    $("#department").change(function(e) {
       @this.set('department', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#email_notification").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#email_notification").select2({
           dropdownParent: $('#personalInfo')
       });
   });
    $("#email_notification").change(function(e) {
       @this.set('email_notification', $(this).val(), true)
    })
   });
</script>

<script>
    $(document).ready(function () {
   $("#user_status").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#user_status").select2({
           dropdownParent: $('#personalInfo')
       });
   });
    $("#user_status").change(function(e) {
       @this.set('status', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#app_login").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#app_login").select2({
           dropdownParent: $('#personalInfo')
       });
   });
    $("#app_login").change(function(e) {
       @this.set('app_login', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#user_role").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#user_role").select2({
           dropdownParent: $('#personalInfo')
       });
   });
    $("#user_role").change(function(e) {
       @this.set('user_role', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#workplace").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#workplace").select2({
           dropdownParent: $('#personalInfo')
       });
   });
    $("#workplace").change(function(e) {
       @this.set('workplace', $(this).val(), true)
    })
   });
</script>