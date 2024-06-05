<?php
use Illuminate\Support\Facades\Session;
use App\Models\Permission;
use App\Models\RolesPermission;
use Illuminate\Http\Request;
?>
<x-admin-layout>
<div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-head-box">
                    <h3>Employees</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Employee</li>
                        </ol>
                    </nav>
                </div>
                 @if(session('success'))
                    <div class="alert alert-success" id="success">
                        {{ session('success') }}
                    </div>
				@endif
				    @if(session('info'))
                    <div class="alert alert-danger" id="danger">
                        {{ session('info') }}
                    </div>
				@endif
                <div class="pageFilter mb-3">
                    <div class="row">
                        <div class="col-xxl-9 col-xl-12">
                            <div>
                            @if((Auth::user()->user_role==0)||Permission::userpermissions('filters',2,'employees')||RolesPermission::userpermissions('filters',2,'employees'))  
                          <form  method="get" action="">
                            <div class="leftFilters check employeeLeftFilter inputscrollcont flex-wrap">
                                    <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-3 col-12 empform1">
                                        <div class="form-group mt-0">
                                            <label for="floatingSelect">Employees</label>
                                            <select class="form-select user_list js-select2-employee" name="search_name[]" multiple="multiple"  id="floatingSelect" aria-label="Floating label select example">
                                                
                                                 @foreach($employee as $key=>$user)
                                                  @if(! empty($employeeName))
                                                    <option value="{{$user->_id}}" {{in_array($user->_id,$employeeName)? 'selected':''}}>{{$user->first_name}} {{$user->last_name}} ({{$user->employee_id}})</option>
                                                    @else
                                                      <option value="{{$user->_id}}" >{{$user->first_name}} {{$user->last_name}} ({{$user->employee_id}})</option>
                                                  @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-1 col-xl-2 col-lg-3 col-md-3 col-sm-3 col-12 empform2">
                                        <div class="form-group mt-0">
                                            <label for="floatingSelect">Designation</label>
                                            <select class="form-select  user_designation js-select2" id="floatingSelect" name="search_designation"  aria-label="Floating label select example">
                                            <option value="">All</option>
                                            @foreach($designations as $designation)
                                                    <option value="{{$designation->_id}}" {{ ($desigantionName == $designation->_id) ? 'selected' : '' }}>{{$designation->title}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-1 col-xl-2 col-lg-3 col-md-3 col-sm-3 col-12 empform3">
                                        <div class="form-group mt-0">
                                            <label for="floatingSelect">Employment Status</label>
                                            <select class="form-select  user_status js-select2" name="search_status"  id="floatingSelect" aria-label="Floating label select example">
                                            <option value='all'>All</option>
                                            <option value="1" {{ ($status == '1') ? 'selected' : '' }}>Active</option>
                                            <option value="2" {{ ($status == '2') ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-1 col-xl-2 col-lg-3 col-md-3 col-sm-3 col-12 empform4">
                                        <div class="form-group mt-0">
                                            <label for="floatingSelect">Roles</label>
                                            <select class="form-select user_role js-select2" name="search_role"  id="floatingSelect" aria-label="Floating label select example">
                                                <option value='' selected>All</option>
                                                @foreach($roles as $user)
                                                    <option value="{{$user->_id}}" {{ ($roleName == $user->_id) ? 'selected' : '' }}>{{! empty($user->name) ? ucfirst(str_replace('_',' ',$user->name)) : ''}}</option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="col-xxl-1 col-xl-2 col-lg-3 col-md-3 col-sm-3 col-12 empform5">
                                        <div class="form-group mt-0">
                                            <label for="floatingSelect">Gender</label>
                                             <select class="form-select  user_status js-select2" name="search_gender"  id="floatingSelect" aria-label="Floating label select example">
                                            <option value='all'>All</option>
                                            <option value="male"{{ ($gender == 'male') ? 'selected' : '' }}  >Male</option>
                                            <option value="female" {{ ($gender == 'female') ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ ($gender == 'other') ? 'selected' : '' }} >Other</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg col-md col-sm buttons employee allempformbtn">
                                         <button type="submit" value="Submit" class="btn btn-search"><img src="images/iconSearch.svg" /> Search here</button>
                                         <button type="button" value="reset" class="btn btn-search" onclick="window.location='{{ url("employee?search_status=1") }}'">Reset</button>
                                    </div>
                                    <!-- <div class="col">
                                    	<button type="button" value="reset" class="btn btn-search" onclick="window.location='{{ url("employee") }}'">Reset</button>
                                    </div> -->
                            	</div>
                            </form>
                        </div>
                            @endif
                        </div>
                        <?php 
                        $html='?';
                        if(!empty($_GET['search_name']))
                        {
                            foreach($_GET['search_name'] as $search_name)
                            {
                                $html.='&search_name='.$search_name;   
                            }
                        }
                        if(!empty($_GET['search_designation']))
                        {
                            $html.='&search_designation='.$_GET['search_designation'];
                        }
                        if(!empty($_GET['search_status']))
                        {
                            $html.='&search_status='.$_GET['search_status'];
                        }
                        if(!empty($_GET['search_role']))
                        {
                            $html.='&search_role='.$_GET['search_role'];
                        }
                        ?>
                        <div class="col-xxl-3 col-xl-12">
                            <div class="rightFilter employeeRightFilter mt-0 resemployeeRightFilter">
                                <div>
                            @if((Auth::user()->user_role==0)||Permission::userpermissions('export',2,'employees')||RolesPermission::userpermissions('export',2,'employees'))  
                                <a class="" href="{{url('/employee/export/'.$html)}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Export">
                                    <svg width="30" height="27" viewBox="0 0 30 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 3.375C0 1.51348 1.49479 0 3.33333 0H11.6667V6.75C11.6667 7.6834 12.4115 8.4375 13.3333 8.4375H20V15.1875H11.25C10.5573 15.1875 10 15.7518 10 16.4531C10 17.1545 10.5573 17.7188 11.25 17.7188H20V23.625C20 25.4865 18.5052 27 16.6667 27H3.33333C1.49479 27 0 25.4865 0 23.625V3.375ZM20 17.7188V15.1875H25.7344L23.7031 13.1309C23.2135 12.6352 23.2135 11.8336 23.7031 11.3432C24.1927 10.8527 24.9844 10.8475 25.4688 11.3432L29.6354 15.5619C30.125 16.0576 30.125 16.8592 29.6354 17.3496L25.4688 21.5684C24.9792 22.0641 24.1875 22.0641 23.7031 21.5684C23.2188 21.0727 23.2135 20.2711 23.7031 19.7807L25.7344 17.724H20V17.7188ZM20 6.75H13.3333V0L20 6.75Z" fill="#1F1F1F"/>
                                    </svg>
                                </a>  
                                @endif
                            @if((Auth::user()->user_role==0)||Permission::userpermissions('import',2,'employees')||RolesPermission::userpermissions('import',2,'employees'))  
                             
<!--                                 <a href="" data-bs-toggle="modal" data-bs-target="#import_info"  ><button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Import" class=""> -->
<!--                                     <svg width="22" height="26" viewBox="0 0 22 26" fill="none" xmlns="http://www.w3.org/2000/svg"> -->
<!--                                         <path d="M11.9375 10.2498H10.0625V4.07515L6.97578 7.16304C6.79987 7.33896 6.56128 7.43778 6.3125 7.43778C6.06372 7.43778 5.82513 7.33895 5.64922 7.16304C5.47331 6.98713 5.37448 6.74854 5.37448 6.49976C5.37448 6.25098 5.47331 6.01239 5.64922 5.83648L10.3367 1.14898C10.4238 1.06181 10.5272 0.992665 10.641 0.945486C10.7548 0.898307 10.8768 0.874023 11 0.874023C11.1232 0.874023 11.2452 0.898307 11.359 0.945486C11.4728 0.992665 11.5762 1.06181 11.6633 1.14898L16.3508 5.83648C16.5267 6.01239 16.6255 6.25098 16.6255 6.49976C16.6255 6.74854 16.5267 6.98713 16.3508 7.16304C16.1749 7.33896 15.9363 7.43778 15.6875 7.43778C15.4387 7.43778 15.2001 7.33896 15.0242 7.16304L11.9375 4.07515V10.2498ZM19.4375 10.2498H11.9375V14.9373C11.9375 15.1859 11.8387 15.4244 11.6629 15.6002C11.4871 15.776 11.2486 15.8748 11 15.8748C10.7514 15.8748 10.5129 15.776 10.3371 15.6002C10.1613 15.4244 10.0625 15.1859 10.0625 14.9373V10.2498H2.5625C2.06522 10.2498 1.58831 10.4473 1.23667 10.7989C0.885044 11.1506 0.6875 11.6275 0.6875 12.1248V23.3748C0.6875 23.872 0.885044 24.349 1.23667 24.7006C1.58831 25.0522 2.06522 25.2498 2.5625 25.2498H19.4375C19.9348 25.2498 20.4117 25.0522 20.7633 24.7006C21.115 24.349 21.3125 23.872 21.3125 23.3748V12.1248C21.3125 11.6275 21.115 11.1506 20.7633 10.7989C20.4117 10.4473 19.9348 10.2498 19.4375 10.2498Z" fill="#1F1F1F"/> -->
<!--                                     </svg> -->
<!--                                 </button> -->
<!--                             </a> -->
                            @endif    
    
                                    @if((Auth::user()->user_role==0)||Permission::userpermissions('grid_view',2,'employees')||RolesPermission::userpermissions('grid_view',2,'employees'))  
                                    {{-- <a  href="{{route('admin.employee')}}">
                                       
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.6875 10.1251C1.43886 10.1251 1.2004 10.0263 1.02459 9.85049C0.848772 9.67468 0.75 9.43622 0.75 9.18758V1.68945C0.75 1.44081 0.848772 1.20236 1.02459 1.02654C1.2004 0.850725 1.43886 0.751953 1.6875 0.751953H9.1875C9.43614 0.751953 9.6746 0.850725 9.85041 1.02654C10.0262 1.20236 10.125 1.44081 10.125 1.68945V9.18758C10.125 9.43622 10.0262 9.67468 9.85041 9.85049C9.6746 10.0263 9.43614 10.1251 9.1875 10.1251H1.6875ZM14.8125 10.1251C14.5639 10.1251 14.3254 10.0263 14.1496 9.85049C13.9738 9.67468 13.875 9.43622 13.875 9.18758V1.68945C13.875 1.44081 13.9738 1.20236 14.1496 1.02654C14.3254 0.850725 14.5639 0.751953 14.8125 0.751953H22.3106C22.5593 0.751953 22.7977 0.850725 22.9735 1.02654C23.1494 1.20236 23.2481 1.44081 23.2481 1.68945V9.18758C23.2481 9.43622 23.1494 9.67468 22.9735 9.85049C22.7977 10.0263 22.5593 10.1251 22.3106 10.1251H14.8125ZM1.6875 23.2501C1.43886 23.2501 1.2004 23.1513 1.02459 22.9755C0.848772 22.7997 0.75 22.5612 0.75 22.3126V14.8126C0.75 14.5639 0.848772 14.3255 1.02459 14.1497C1.2004 13.9739 1.43886 13.8751 1.6875 13.8751H9.1875C9.43614 13.8751 9.6746 13.9739 9.85041 14.1497C10.0262 14.3255 10.125 14.5639 10.125 14.8126V22.3126C10.125 22.5612 10.0262 22.7997 9.85041 22.9755C9.6746 23.1513 9.43614 23.2501 9.1875 23.2501H1.6875ZM14.8125 23.2501C14.5639 23.2501 14.3254 23.1513 14.1496 22.9755C13.9738 22.7997 13.875 22.5612 13.875 22.3126V14.8126C13.875 14.5639 13.9738 14.3255 14.1496 14.1497C14.3254 13.9739 14.5639 13.8751 14.8125 13.8751H22.3106C22.5593 13.8751 22.7977 13.9739 22.9735 14.1497C23.1494 14.3255 23.2481 14.5639 23.2481 14.8126V22.3126C23.2481 22.5612 23.1494 22.7997 22.9735 22.9755C22.7977 23.1513 22.5593 23.2501 22.3106 23.2501H14.8125Z" fill="#1F1F1F"/>
                                    </svg>
                                </a> --}}
                                @endif
                              
                                @if((Auth::user()->user_role==0)) 
                                    <a  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="List View" href="{{route('admin.employee-list')}}">
                                    <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 17.875C22.4815 17.8752 22.9445 18.0607 23.293 18.393C23.6415 18.7253 23.8488 19.1789 23.8719 19.6599C23.895 20.1409 23.7323 20.6123 23.4173 20.9765C23.1023 21.3407 22.6593 21.5698 22.18 21.6162L22 21.625H2C1.51848 21.6248 1.05551 21.4393 0.707017 21.107C0.358527 20.7747 0.151235 20.3211 0.128095 19.8401C0.104954 19.3591 0.26774 18.8877 0.582719 18.5235C0.897699 18.1593 1.34073 17.9302 1.82 17.8838L2 17.875H22ZM22 9.125C22.4973 9.125 22.9742 9.32254 23.3258 9.67417C23.6775 10.0258 23.875 10.5027 23.875 11C23.875 11.4973 23.6775 11.9742 23.3258 12.3258C22.9742 12.6775 22.4973 12.875 22 12.875H2C1.50272 12.875 1.02581 12.6775 0.674175 12.3258C0.322544 11.9742 0.125 11.4973 0.125 11C0.125 10.5027 0.322544 10.0258 0.674175 9.67417C1.02581 9.32254 1.50272 9.125 2 9.125H22ZM22 0.375C22.4973 0.375 22.9742 0.572544 23.3258 0.924175C23.6775 1.27581 23.875 1.75272 23.875 2.25C23.875 2.74728 23.6775 3.22419 23.3258 3.57583C22.9742 3.92746 22.4973 4.125 22 4.125H2C1.50272 4.125 1.02581 3.92746 0.674175 3.57583C0.322544 3.22419 0.125 2.74728 0.125 2.25C0.125 1.75272 0.322544 1.27581 0.674175 0.924175C1.02581 0.572544 1.50272 0.375 2 0.375H22Z" fill="#1F1F1F"/>
                                    </svg>
                            </a>
                            @endif
                            @if((Auth::user()->user_role==0)||Permission::userpermissions('create',2,'employees')) 
                            						<a href="{{route('addEmployee')}}?route={{Route::currentRouteName()}}" class="addBtn employee" role="button">Add Employee</a>
                            @endif
                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dashboardSection">
                    <div class="dashboardSection__body">
                        <div class="row">
                            @if(count($users) > 0)
                            @foreach($users as $user)
                            <div class="col-xxl-3 col-xl-4 col-lg-6 employeeCardMargin">
                                <div class="employeeCard">
                                    <div class="head justify-content-end">
                                        {{-- <img src="images/messageIcon.svg"  title="Message" alt="Message" /> --}}
                                        <div class="dropdown">
                                        @if((Auth::user()->user_role==0) || Permission::userpermissions('update',2,'employees') ||RolesPermission::userpermissions('delete',2,'employees'))
                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                              <img src="images/infoIcon.svg" title="More Info" alt="More Info" />
                                            </button>
                                           @endif
                                            <ul class="dropdown-menu">
                                                @if((Auth::user()->user_role==0)||Permission::userpermissions('update',2,'employees')||RolesPermission::userpermissions('update',2,'employees'))
                                                 
                                              <li>
		                          			<a class="dropdown-item" href="/employee/update/{{$user->_id}}" class="btn btn-success" role="button">Edit</a>
                                                
                                            </li>@endif
                                            @if((Auth::user()->user_role==0)||Permission::userpermissions('delete',2,'employees')||RolesPermission::userpermissions('delete',2,'employees')) 
                                              <li><a class="dropdown-item userDelete"  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$user->id}}" href="javascript:void(0);">Delete</a></li>
                                              @endif
                                              
                                              @if((Auth::user()->user_role==0)||Permission::userpermissions('delete',2,'employees')||RolesPermission::userpermissions('delete',2,'employees')) 
                                              <li><a class="dropdown-item userInactive"  onclick="confirm('Are you sure you want to inactive this Records?') || event.stopImmediatePropagation()" data-id="{{$user->id}}" href="javascript:void(0);">Inactive</a></li>
                                              @endif
                                            </ul>
                                          </div>
                                    </div>
                                    <div class="employeeBody">
    
                                    <div>
                                     <img src="{{ ($user->photo) ? $user->photo : url('images/user.png') }}" alt="Profile Image" title="Profile Image" />
                                   <h5>{{ ucfirst($user->first_name) }}&nbsp; {{ $user->last_name }}</h5>
                                <span class="designation mb-3">
                                        <?php
                                      if ($user->status == 1) {
                                        echo "Active";
                                          } elseif ($user->status == 2) {
                                         echo "Inactive";
                                      } else {
                                              echo "Deleted"; 
                                      }
                                              ?>
                                              </span>
                               <p>{{ $user->email }}</p>

                                    @if (!empty($user->get_userrole()) || $user->user_role == 0)
                            <span class="designation mt-3">{{ (!empty($user->get_userrole()) ? ucfirst(str_replace('_', ' ', $user->get_userrole()->name) ? $user->get_userrole()->name : 'Admin') : '') }}</span>
                                        @endif

                           <p class="my-3"><b>{{ $user->contact }}</b></p>
                                 @if ($user->getdesignation())
                               <span class="designationOut"><i class="fa-solid fa-briefcase"></i> {{ ($user->getdesignation()) ? $user->getdesignation()->title : '' }}</span>
                                  @endif
                                     </div>

    
                                           <div>
                                         @if ($user->status != 3)
                               @if ((Auth::user()->user_role == 0) || Permission::userpermissions('view_profile', 2, 'employees') || RolesPermission::userpermissions('view_profile', 2, 'employees'))
                                 <a class="detailLink" href="{{ url('/employee-profile') }}/{{ $user->_id }}">View Profile</a>
                                    @endif
                                       @endif
                                         </div>
                                       </div>

                                </div>
                            </div>
                            @endforeach
                            @else
                                <p class="text-center">No Data Found</p>
                            @endif
                        </div>
                        <div class="commonPagination">
                            {{$users->links('pagination::bootstrap-4')}}
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


  $(".userDelete").click(function(){
        var id = $(this).data("id");
        $.ajax({
                type: 'post',
                url: "{{ route('userDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
        });
        
          $(".userInactive").click(function(){
        var id = $(this).data("id");
        $.ajax({
                type: 'post',
                url: "{{ route('userInactive')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
        });
        
        


</script>
</x-admin-layout>