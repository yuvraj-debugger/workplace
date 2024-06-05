<?php

use App\Models\Permission;
use App\Models\RolesPermission;
?><div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-head-box">
                <h3>Designation</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Designation</li>
                    </ol>
                </nav>
            </div>
            <div class="pageFilter mb-3">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('filters',2, 'employee_designation') || RolesPermission::userpermissions('filters',2, 'employee_designation')) )
                        <div class="">
                            <div class="form-group mt-0" wire:ignore> 
                            <label for="floatingSelect">Designation</label>
                                <select class="form-select user_designation"  wire:model="search_designation"  id="floatingSelect" aria-label="Floating label select example">
                                    <option value="all" selected>All</option>
                                @foreach($employee_designations as $designation )
                                  <option value="{{$designation->id}}">{{$designation->title}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                      
                    </div>
                           
                    <div class="col-xl-9 col-lg-8 col-md-8 col-sm">
                        <div class="rightFilter designationFilters">
                            <div>
                            @if((Auth::user()->user_role==0)||(Permission::userpermissions('export',2, 'employee_designation')|| RolesPermission::userpermissions('export',2, 'employee_designation')) ) 

                            <button class="" wire:click="exportData()">
                                <svg width="30" height="27" viewBox="0 0 30 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 3.375C0 1.51348 1.49479 0 3.33333 0H11.6667V6.75C11.6667 7.6834 12.4115 8.4375 13.3333 8.4375H20V15.1875H11.25C10.5573 15.1875 10 15.7518 10 16.4531C10 17.1545 10.5573 17.7188 11.25 17.7188H20V23.625C20 25.4865 18.5052 27 16.6667 27H3.33333C1.49479 27 0 25.4865 0 23.625V3.375ZM20 17.7188V15.1875H25.7344L23.7031 13.1309C23.2135 12.6352 23.2135 11.8336 23.7031 11.3432C24.1927 10.8527 24.9844 10.8475 25.4688 11.3432L29.6354 15.5619C30.125 16.0576 30.125 16.8592 29.6354 17.3496L25.4688 21.5684C24.9792 22.0641 24.1875 22.0641 23.7031 21.5684C23.2188 21.0727 23.2135 20.2711 23.7031 19.7807L25.7344 17.724H20V17.7188ZM20 6.75H13.3333V0L20 6.75Z" fill="#1F1F1F"/>
                                </svg>
                            </button>
                            @endif
                          
                            @if((Auth::user()->user_role==0)||Permission::userpermissions('create',2,'employee_designation')) 
                            
                            <a class="addBtn design mb-0"  wire:click="addform()"  data-bs-toggle="modal" data-bs-target="#holidayModal" href="javascript:void(0);" onclick="addform()"><i class="fa-solid fa-plus"></i> Add Designation</a>
                            
                            @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        
            <div class="dashboardSection">
                <div>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                <div class="dashboardSection__body">
                    <div class="commonDataTable">
                        <div class="table-responsive">
                                        @if ($checked)
                  <div class="btn-group ">
                    <button id="deleteAll" class="deleteSelection btn btn-danger"  wire:click="deleteRecords()">Delete</button>
                  </div>
                @endif
                        
                            <table class="table">
                                <thead>
                                    <tr>
                                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'employees_designation')|| RolesPermission::userpermissions('delete',2, 'employees_designation')) ) 
                                        <th>
                                             <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" wire:model="selectPage" type="checkbox" value="" id="flexCheckDefault">
                                               </div> 
                                        </th>
                                        @endif
                                        <th>Title</th>
                                        @if(((Auth::user()->user_role==0)||(Permission::userpermissions('update',1, 'employees_designation')&&RolesPermission::userpermissions('update',1, 'employees_designation')) ) ||((Auth::user()->user_role==0)||(Permission::userpermissions('delete',1, 'employees_designation')&&RolesPermission::userpermissions('delete',1, 'employees_designation')) ))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($designations) > 0)
                                    @foreach($designations as $designation )
                                    <tr>
                                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'employee_designation')|| RolesPermission::userpermissions('delete',2, 'employee_designation')) ) 
                                        <td>
                                            <div class="form-check d-flex justify-content-center">

                                                <input class="form-check-input" type="checkbox" value="{{$designation->_id}}" wire:model="checked" id="flexCheckDefault">

                                            </div>
                                        </td>
                                        @endif
                                        <td>{{$designation->title}}
                                        </td>
                            @if((Auth::user()->user_role==0)||Permission::userpermissions('update',2,'employee_designation')||RolesPermission::userpermissions('update',2,'employee_designation') || (Auth::user()->user_role==0)||Permission::userpermissions('delete',2,'employee_designation')||RolesPermission::userpermissions('delete',2,'employee_designation')) 
                                        <td>
                                        <div class="actionIcons">
                                                <ul>
                            @if((Auth::user()->user_role==0)||Permission::userpermissions('update',2,'employee_designation')||RolesPermission::userpermissions('update',2,'employee_designation')) 

                                                    <li><a class="edit" data-bs-toggle="modal" data-bs-target="#holidayModal" wire:click="edit('{{ $designation->id }}')" ><i class="fa-solid fa-pen"></i></a></li>
                                                    @endif
                           						 @if((Auth::user()->user_role==0)||Permission::userpermissions('delete',2,'employee_designation')||RolesPermission::userpermissions('delete',2,'employee_designation')) 

                                                    <li>
                                                        <button class="bin policyDelete ml-1" onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" wire:click="delete('{{$designation->id}}')" ><i class="fa-regular fa-trash-can"></i></button>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="11">No Data Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                             {{$designations->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <!--   Add modal starts -->
<div wire:ignore.self class="modal fade personalInfo"  id="holidayModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                @if($hideaddtitle)
                <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Add Designation</h1>
                @endif
                @if($hideedittitle)
                <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Edit Designation</h1>
                
               @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              
                <form wire:submit.prevent="submit" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Title <span class="text-red">*</span></label>
                                <input type="text" class="form-control" wire:model="title" placeholder="Enter Designation" />
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mt-4 text-right">
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- designation  add modal ends --> 

 <!-- edit designation  add modal ends --> 
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
 window.addEventListener('closeServiceModal',function(){
      $('.btn-close').click();
      @this.set('title','');
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
        $('.user_designation').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('search_designation', $(this).val());
           @this.set('selectPage', false);
            // livewire.emit('render', e.target.value)

        });
    });
    document.addEventListener('livewire:load', function (event) {
        @this.on('refreshDropdown', function () {
            let employee_designation = [];
            console.log(@this.employee_designationsArray);
            $.each(@this.employee_designationsArray, function(key, emp){
                employee_designation.push({
                    text: emp.title,
                    id: emp._id
                });
            });
            $('.user_designation').empty().append('<option value="all">All</option>').select2({
                data: employee_designation
            });


            if(@this.search_designation != '' && @this.search_designation != null){
               $(".user_designation").val(@this.search_designation).trigger("change");

           }else{
               $(".user_designation").val('all').trigger("change");

           }
        });
        // window.livewire.hook('afterDomUpdate', () => {
        //     @this.set('search_name', null)
        // });
    });
</script>



