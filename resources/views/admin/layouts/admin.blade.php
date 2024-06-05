<?php

use App\Models\Permission;
use App\Models\RolesPermission;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;
use App\Models\NotificationRead;
use App\Models\User;
?>
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no" />
  <!-- Styles -->
{{-- Tailwid link --}}
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
<!-- Favicon -->
<link rel="icon" href="{{asset('images/mini-logo-green.svg')}}" sizes="any" type="image/svg+xml">

<title>Softuvo-Workplace</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
 <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Permanent+Marker&display=swap"
        rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lemon&family=Permanent+Marker&display=swap" rel="stylesheet">
@livewireStyles
</head>
<body>
<main class="main-wrapper">
    <header class="header">
		<!-- End of Topbar -->
        <div class="header-left">
            <div class="miniLogo">
                <a href="{{ url('/dashboard')}}">
                    <img src="{{asset('images/mini-logo.svg')}}" alt="mini-logo" />
                </a>
            </div>
        </div>
        <div class="header-center">
            <h1>Softuvo Solutions</h1>
        </div>
        <a id="toggle_btn" href="javascript:void(0);">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>
        <ul class="header-new-menu">
            @if(Auth::user()->user_role==0)
          
            <li>
              <!--   <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Clients</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);">Clients</a>
                </div> -->
            </li>
            <li>
                <!-- <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Projects</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);">Projects</a>
                    <a class="dropdown-item" href="javascript:void(0);">Tasks</a>
                    <a class="dropdown-item" href="javascript:void(0);">Task Board</a>
                </div> -->
            </li>
            <li>
                <!-- <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Leads</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);">Leads</a>
                </div> -->
            </li>
            <li>
             <!--    <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Tickets</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);">Tickets</a>
                </div> -->
            </li>
            {{-- @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
            <li>
                <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> {{ Auth::user()->currentTeam->name }}</a>
                <div class="dropdown-menu">
                    <h6 class="dropdown-header">{{ __('Manage Team') }}</h6>
                    <a class="dropdown-item" href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">Team Settings</a>
                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                    <a class="dropdown-item" href="{{ route('teams.create') }}">Create New Team</a>
                    @endcan
                </div>
            </li>
            @endif --}}
            @endif
        </ul>
        <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa-solid fa-bars"></i></a>
       
       <?php 
       $notifications = Notification::orderBy('_id','desc')->paginate(5);
       $role = Role::where('_id', Auth::user()->user_role)->first();
       if (! empty($role) && ($role->name == 'Management')) {
          $userManager = User::where('reporting_manager', Auth::user()->_id)->get()->pluck('_id')->toArray();
          $notifications = Notification::whereIn('created_by',$userManager)->paginate(5);
          $totalNotifcation = Notification::whereIn('created_by',$userManager)->get();
      }
       $totalNotifcation = Notification::get();
       $readNotification = NotificationRead::where('created_by',Auth::user()->id)->get();
       ?>
       
       
       
        <div class="user-menu">
      
            <div class="searchbar">
               <!--  <input class="searchbar__field" type="search" placeholder="Search here">
                <button class="searchbar__button" type="button"><i class="fa-solid fa-magnifying-glass"></i></button> -->
            </div>
            <!-- <div class="headerIcons">
                <ul>
                    <li class="headerIcons__icon"><button type="button"><img src="{{ asset('/images/header/check-icon.svg')}}" alt=""> <span class="counter">2</span></button></li>
                   
                    <li class="headerIcons__icon"><button type="button"><img src="{{ asset('/images/header/time-icon.svg')}}" alt=""> <span class="counter">5</span></button></li>
                    <li class="headerIcons__icon"><button type="button"><img src="{{ asset('/images/header/add-icon.svg')}}" alt=""> <span class="counter">2</span></button></li>
                    <li class="headerIcons__icon"><button type="button"><img src="{{ asset('/images/header/bell-icon.svg')}}" alt=""> <span class="counter">12</span></button></li>
                </ul>
            </div> -->
            <?php 
            if((! empty($role) && ($role->name == 'Management')) || (Auth::user()->user_role == '0') || (! empty($role) && ($role->name == 'HR'))){
            
            ?>
            <div class="notifications" id="onbellclick">
          
           <i class="fa-solid fa-bell fa-2x read-message"></i><span class="notificationcount">{{count($totalNotifcation) - count($readNotification) }}</span></div>
           <?php }?>
            <div class="notificationbox">
                <div class="notificationheader">
                <h4>Notifications</h4>
                <span class="totalCount">{{count($totalNotifcation) - count($readNotification)}}</span>
                </div>
                <div class="allnotifications">
               
<!--                     <img src="{{ asset('/images/notificationbadge.png')}}" alt=""> -->
                    <?php 
foreach ($notifications as $notification){
?>                     
<!-- add latestnotification class on new notifications -->
                         <div class="notificationbody latestnotification">
                        <div class="notificationmessage">
                        <h5>{{$notification->getData()}}</h5>
                        </div>
                        </div>
                         <?php }?>
                   
                   
                
                </div>
                <div class="notificationfooter"><a href="/read-message">View All</a></div>
            </div>
            
            <div class="avatar">
                <div class="dropdown">
                    <button class="avatar__button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                        @if(Auth::user()->photo  != '')

                    <img class="avatar__image" src="{{ Auth::user()->photo}}" alt="user-img" />
                    @else
                    <!-- <img class="avatar__image" src="{{ asset('/images/user-img.jpg')}}" alt="user-img" /> -->

                    @endif
                        <span>{{ucwords(Auth::user()->first_name)}} {{ucwords(Auth::user()->last_name)}}</span>

                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if(Auth::user()->user_role  == 0)  
                        <li><a href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                            {{ __('Profile') }} </a></li>
                        @endif
                        @if(Auth::user()->user_role  != 0)  
                        <li><a href="{{url('/employee-profile')}}/{{Auth::user()->_id}}">My Profile</a></li>
                        @endif
                       
                   
                        <li>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <a href="{{ route('logout') }}"
                            @click.prevent="$root.submit();" data-toggle="modal"
                            data-target="#logoutModal">Logout</a>
                        </form>
                    </li>
                    </ul>
                </div>
            </div>
        </div> 
    </header><!--Header End-->
    <div class="sidebar" id="sidebar">
        <div class="slimScrollDiv">
            <div class="sidebar-left slimscroll">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link  @if(Route::is('dashboard')) active show  @endif" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><span data-bs-delay='{"show":"100", "hide":"0"}' data-bs-offset="0,10" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Dashboard"><img src="{{ asset('/images/navbar/home-icon.svg')}}" alt="" /></span></a>
                    </li>     
                                            @if((Auth::user()->user_role==0)|| (! empty($role) &&  $role->name=="HR") ||(Permission::userpermissions('employees',1)))
                    <li class="nav-item role">
                        <a href="javascript:void(0);" class="nav-link @if(Route::is('admin.employee')||Route::is('admin.employee-list')||Route::is('admin.employee-designation')||Route::is('admin.employee-department') ||Route::is('employee-seperate-out') ||Route::is('reporting-structure')||Route::is('mass-communication') ||Route::is('admin.roles-permissions')|| Route::is('admin.employeeShift') || Route::is('admin.employeeSchedule') || (\Request::segment(1) == 'user' && \Request::segment(2) == 'profile')||(\Request::segment(1) == 'user' ) || \Request::segment(1) == 'profile-permissions'|| \Request::segment(1) == 'profile')) active show  @endif" id="employees-tab" data-bs-toggle="tab" data-bs-target="#employees" type="button" role="tab" aria-controls="employees">
                            <span data-bs-delay='{"show":"100", "hide":"0"}'  data-bs-offset="0,10" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Employees "><img src="{{ asset('/images/navbar/employees-icon.svg')}}" alt="" /></span>
                        </a>
                    </li>
                    @endif
                    
                  
                    <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link @if(Route::is('admin.holidays')||Route::is('admin.leavesetting')) active show  @endif" id="leaves-tab" data-bs-toggle="tab" data-bs-target="#leaves" type="button" role="tab" aria-controls="leaves" aria-selected="false"><span data-bs-delay='{"show":"100", "hide":"0"}' data-bs-offset="0,10" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Holidays"><img src="{{ asset('/images/navbar/iconCalendar.svg')}}" alt="" /></span></a>
                    </li>
        
                    <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link @if(Route::is('admin.adminattendance')  ||  Route::is('leaves')||Route::is('admin.employeeleaves') ||  Route::is('admin.employeeattendance')) active show  @endif" id="clients-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="clients" aria-selected="false"><span data-bs-delay='{"show":"100", "hide":"0"}' data-bs-offset="0,10" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Report"><img src="{{ asset('/images/navbar/attendanceIcon.svg')}}" alt="" /></span></a>
                    </li>
                    <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        ?>
                    @if((Auth::user()->user_role==0) || (! empty($role) &&  $role->name=="HR"))
                        <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link @if(Route::is('admin.bloodGroupAdd')||Route::is('admin.documentIndex')) active show  @endif" id="setting-tab" data-bs-toggle="tab" data-bs-target="#setting" type="button" role="tab" aria-controls="setting" aria-selected="false"><span data-bs-delay='{"show":"100", "hide":"0"}' data-bs-offset="0,10" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Setting"><i class="fa fa-cog" aria-hidden="true"></i></span></a>
                    </li>
                    @endif
                    @if((Auth::user()->user_role==0) || (! empty($role) &&  $role->name=="HR"))
                     <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link @if(Route::is('admin.attendancereport')||Route::is('admin.leavereport')) active show  @endif" id="report-tab" data-bs-toggle="tab" data-bs-target="#report" type="button" role="tab" aria-controls="report" aria-selected="false"><span data-bs-delay='{"show":"100", "hide":"0"}' data-bs-offset="0,10" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Attendance Report"><i class="fa fa-file" aria-hidden="true"></i></span></a>
                    </li>
                    @endif
                      <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link @if(Route::is('admin.policymanagement') || Route::is('addPolicy')) active show  @endif" id="policy-tab" data-bs-toggle="tab" data-bs-target="#policy" type="button" role="tab" aria-controls="policy" aria-selected="false"><span data-bs-delay='{"show":"100", "hide":"0"}' data-bs-offset="0,10" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Policy"><i class="fa fa-shield" aria-hidden="true"></i></span></a>
                    </li>
                     @if((Auth::user()->user_role==0) || (! empty($role) &&  $role->name=="HR"))
                     <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link @if(Route::is('admin.masterLeaves')) active show  @endif" id="master-leaves-tab" data-bs-toggle="tab" data-bs-target="#masterleave" type="button" role="tab" aria-controls="masterleaves" aria-selected="false"><span data-bs-delay='{"show":"100", "hide":"0"}' data-bs-offset="0,10" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Master Leaves"><img src="{{asset ('images/trace.svg')}}" alt=""></span></a>
                    </li>
                    @endif
                    
                     @if((Auth::user()->user_role==0) || (! empty($role) &&  $role->name=="HR"))
                     <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link @if(Route::is('admin.userActivities')) active show  @endif" id="user-activities-tab" data-bs-toggle="tab" data-bs-target="#userActivities" type="button" role="tab" aria-controls="userActivities" aria-selected="false"><span data-bs-delay='{"show":"100", "hide":"0"}' data-bs-offset="0,10" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="User Activities"><i class="fa fa-tasks" aria-hidden="true"></i></span></a>
                    </li>
                    @endif
                    
                </ul>                
            </div>
        </div>
        <div class="sidebar-right">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show @if(Request::is('dashboard')) active show @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <!-- <p>App</p> -->
                    <ul>
                        <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <!-- <li><a href="javascript:void(0);">Employee Dashboard</a></li> -->
                    </ul>
                </div>
                <div class="tab-pane fade" id="app" role="tabpanel" aria-labelledby="app-tab">
                    <!-- <p>App</p> -->
                    <ul>
                        <li><a href="javascript:void(0);">Admin Dashboard</a></li>
                        <li><a href="javascript:void(0);">Employees Dashboard</a></li>
                    </ul>
                </div>

                <div class="tab-pane fade @if(Route::is('admin.employee')||Route::is('admin.employee')||Route::is('admin.employee-list')||Route::is('addEmployee') ||Route::is('admin.employee-designation')|| Route::is('employeeUpdate') || Route::is('admin.probationEmployee') || Route::is('employeeProfile')|| Route::is('bankStatutory') ||  Route::is('personalInformation') || Route::is('editExperience')|| Route::is('experienceInformation') || Route::is('admin.employeeShift') || Route::is('admin.employeeSchedule') ||Route::is('admin.employee-department') ||Route::is('admin.roles-permissions') ||Route::is('employee-seperate-out') ||Route::is('reporting-structure')||Route::is('mass-communication') || (\Request::segment(1) == 'user' && \Request::segment(2) == 'profile')  || \Request::segment(1) == 'profile-permissions'|| \Request::segment(1) == 'profile') active show  @endif" id="employees" role="tabpanel" aria-labelledby="employees-tab">
                    <!-- <p>HR</p> -->
                    <ul>
                        @if((Auth::user()->user_role==0)|| (! empty($role) &&  $role->name=="HR") ||(Permission::userpermissions('employees',1)))
                        <li><a  class="@if(Route::is('admin.employee')) active   @endif" href="{{route('admin.employee')}}?search_status=1"  > Employees</a></li>
                        @endif
                        @if((Auth::user()->user_role==0)|| (! empty($role) &&  $role->name=="HR") || (Permission::userpermissions('employee_designation',1)))
                        <li><a  class="@if(Route::is('admin.employee-designation')) active   @endif" href="{{route('admin.employee-designation')}}"  >Employees Designation</a></li>
                        @endif
                        @if((Auth::user()->user_role==0)||(! empty($role) &&  $role->name=="HR") || (Permission::userpermissions('employee_department',1)))
                        <li><a class="@if(Route::is('admin.employee-department')) active   @endif"href="{{route('admin.employee-department')}}">Employees Department</a></li>
                        @endif
                         @if((Auth::user()->user_role==0) || (! empty($role) &&  $role->name=="HR"))
                            <li><a class="@if(Route::is('admin.employeeShift')) active   @endif"href="{{route('admin.employeeShift')}}">Employees Shift</a></li>
                            <li><a class="@if(Route::is('admin.employeeSchedule')) active   @endif"href="{{route('admin.employeeSchedule')}}">Employees Schedule</a></li>
                          @endif
                          @if((Auth::user()->user_role==0) || (! empty($role) &&  $role->name=="HR") || (! empty($role) &&  $role->name=="Management"))
                          <li><a class="@if(Route::is('admin.probationEmployee')) active   @endif" href="{{route('admin.probationEmployee')}}">Employees Probation</a></li>
                          @endif
                        @if((Auth::user()->user_role==0) )
                            <li><a class="@if(Route::is('admin.roles-permissions')) active   @endif" href="{{route('admin.roles-permissions')}}">Roles and Permissions</a></li>
                        @endif
                    </ul>
                </div>
                <div class="tab-pane fade @if(Route::is('admin.holidays') ||Route::is('admin.leavesetting')) active show  @endif"  id="leaves" role="tabpanel" aria-labelledby="leaves-tab">
                    <!-- <p>HR</p> -->
                    <ul>
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('holidays',1)|| RolesPermission::userpermissions('holidays',1)))     
                        <li><a class="@if(Route::is('admin.holidays')) active   @endif" href="{{route('admin.holidays')}}">Holidays</a></li>
                        @endif
                           
                    
                        
                        
                        <!-- @if((Auth::user()->user_role==0)||(Permission::userpermissions('employee_leaves',0)&&RolesPermission::userpermissions('employee_leaves',0))) 

                        <li><a class="@if(Route::is('admin.employeeleaves')) active   @endif" href="{{route('admin.employeeleaves')}}">Leaves (Employee)</a></li> 
                        @endif -->
                        <!-- @if((Auth::user()->user_role==0)||(Permission::userpermissions('admin_leaves',0)&&RolesPermission::userpermissions('admin_leaves',0))) 
                        <li><a  class="@if(Route::is('admin.leavesetting')) active   @endif" href="{{route('admin.leavesetting')}}">Leave Setting</a></li>
                        @endif -->
                       
                    </ul>
                </div>
              
                <div class="tab-pane fade" id="clients" role="tabpanel" aria-labelledby="clients-tab">
                    <p>Clients</p>
                    <ul>
                        <li><a href="javascript:void(0);">Admin Dashboard</a></li>
                        <li><a href="javascript:void(0);">Employees Dashboard</a></li>
                    </ul>
                </div>

                <div class="tab-pane fade @if(Route::is('admin.adminattendance') || Route::is('management-attendance') ||Route::is('leaves')|| Route::is('myleaves') || Route::is('admin.myAttendance') || Route::is('leaveBalances') || Route::is('compOff') || Route::is('MyemployeeCompoff') || Route::is('employeeCompoff') || Route::is('admin.whoisin')) ||Route::is('admin.employeeleaves') || Route::is('admin.managementattendance')||  Route::is('admin.whoisin')||Route::is('admin.employeeattendance')) active show  @endif" id="attendance" role="tabpanel" aria-labelledby="clients-tab">
<!--                     <p>ATTENDANCE</p> -->
                    <ul>
                    
                            @if((Auth::user()->user_role==0)) 
                        <li><a class="@if(Route::is('leaves')) active   @endif" href="{{route('leaves')}}">Employees Leaves </a></li>
                        @endif
                           <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if(! empty($role) &&  $role->name!="Employee"){
                        ?>
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('leaves',1))) 
                        <li><a class="@if(Route::is('leaves')) active   @endif" href="{{route('leaves')}}">Employees Leaves </a></li>
                        @endif
                        <?php }?>
                             <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if(! empty($role) &&  $role->name=="Management"){
                        ?>
                               <li><a class="@if(Route::is('myleaves')) active   @endif" href="{{route('myleaves')}}">My Leaves </a></li>
                        <?php }?>
                        
                          <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if(! empty($role) &&  $role->name=="HR"){
                        ?>
                               <li><a class="@if(Route::is('myleaves')) active   @endif" href="{{route('myleaves')}}">My Leaves </a></li>
                        <?php }?>
                        
                           <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if(! empty($role) &&  $role->name=="Employee"){
                        ?>
                               <li><a class="@if(Route::is('myleaves')) active   @endif" href="{{route('myleaves')}}">My Leaves </a></li>
                        <?php }?>
                        
                             <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if(! empty($role) &&  $role->name=="Employee"){
                        ?>
                               <li><a class="@if(Route::is('leaveBalances')) active   @endif" href="{{route('leaveBalances')}}">Leave Balances </a></li>
                        <?php }?>
                                   <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if((! empty($role) &&  $role->name=="Management") || (! empty($role) &&  $role->name=="HR")){
                        ?>
                               <li><a class="@if(Route::is('leaveBalances')) active   @endif" href="{{route('leaveBalances')}}">Leaves Balances </a></li>
                        <?php }?>
                        
                                <?php 
                        if(Auth::user()->user_role == '0'){
                        ?>
                               <li><a class="@if(Route::is('leaveBalances')) active   @endif" href="{{route('leaveBalances')}}">Employees Leaves Balances </a></li>
                        <?php }?>
                        
                        
                              <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if(! empty($role) &&  $role->name=="Employee"){
                        ?>
                               <li><a class="@if(Route::is('compOff')) active   @endif" href="{{route('compOff')}}">Comp Off Grant </a></li>
                        <?php }?>
                                 <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if((! empty($role) &&  $role->name=="Management") || ! empty($role) &&  $role->name=="HR"){
                        ?>
                          <li><a class="@if(Route::is('MyemployeeCompoff')) active   @endif" href="{{route('MyemployeeCompoff')}}">Employee Comp Off Grant </a></li>
                               <li><a class="@if(Route::is('compOff')) active   @endif" href="{{route('compOff')}}">Comp Off Grant </a></li>
                        <?php }?>
                        
                        
                    <?php                         $role=Role::where('_id',Auth::user()->user_role)->first();
                    if((! empty($role) &&  (! $role->name=="Employee"))){
                        
                    ?>
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('attendance',1))) 
                            <li><a class="@if(Route::is('admin.adminattendance')) active   @endif" href="{{route('admin.adminattendance')}}">Employees Attendance</a></li>
                        @endif
                          
                        <?php }?>
                             <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if(! empty($role) &&  $role->name=="Employee"){
                            
                        ?>
                            <li><a class="@if(Route::is('admin.myAttendance')) active   @endif" href="{{route('admin.myAttendance')}}">My Attendance</a></li>
                            <?php }?>
                            
                         
                             <?php 
                            
                            if( Auth::user()->user_role==0){
                            
                            ?>
                                                                                <li><a class="@if(Route::is('admin.adminattendance')) active   @endif" href="{{route('admin.adminattendance')}}">Employees Attendance</a></li>
                                                                                
                            <?php }?>
                            
                        <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if((! empty($role) &&  $role->name=="HR")){
                        ?>
                                                    <li><a class="@if(Route::is('admin.adminattendance')) active   @endif" href="{{route('admin.adminattendance')}}">Employees Attendance</a></li>
                        
                          <li><a class="@if(Route::is('admin.hrattendance')) active   @endif" href="{{route('admin.hrattendance')}}">My Attendance</a></li>
                        <?php }?>
                        
                           <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if(! empty($role) &&  $role->name=="Management"){
                        ?>
                                                                            <li><a class="@if(Route::is('admin.adminattendance')) active   @endif" href="{{route('admin.adminattendance')}}">Employees Attendance</a></li>
                        
                          <li><a class="@if(Route::is('admin.managementattendance')) active   @endif" href="{{route('admin.managementattendance')}}">My Attendance</a></li>
                        <?php }?>
                        
                        
                        
                           @if((Auth::user()->user_role==0)||(Permission::userpermissions('admin_attendance',0)&&RolesPermission::userpermissions('admin_attendance',0))) 
                            <li><a class="@if(Route::is('admin.whoisin')) active   @endif" href="{{route('admin.whoisin')}}">Who Is In</a></li>
                        @endif
                           @if((Auth::user()->user_role==0)||(Permission::userpermissions('admin_attendance',0)&&RolesPermission::userpermissions('admin_attendance',0))) 
                            <li><a class="@if(Route::is('employeeCompoff')) active   @endif" href="{{route('employeeCompoff')}}">Employee Comp off</a></li>
                        @endif
                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('employee_attendance',0)&&RolesPermission::userpermissions('employee_attendance',0))) 
                            @if(Auth::user()->user_role != '0')
                            <li><a  class="@if(Route::is('admin.employeeattendance')) active   @endif" href="{{route('admin.employeeattendance')}}">Attendance (Employee)</a></li>
                            @endif
                        @endif
                    </ul>
                </div>

                @if((Auth::user()->user_role==0)||(Permission::userpermissions('employee_department',1)))
                <div class="tab-pane fade @if(Route::is('admin.bloodGroupAdd') || Route::is('admin.documentIndex') || Route::is('admin.degreeIndex'))  active show  @endif" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                    <ul><li><a class="@if(Route::is('admin.bloodGroupAdd')) active    @endif" href="{{route('admin.bloodGroupAdd')}}">Blood Group</a></li>
                    <li><a class="@if(Route::is('admin.documentIndex')) active    @endif" href="{{route('admin.documentIndex')}}">Document</a></li>
                    <li><a class="@if(Route::is('admin.degreeeIndex')) active    @endif" href="{{route('admin.degreeIndex')}}">Degree</a></li>
                    </ul>
                </div>
                
                
                <div class="tab-pane fade @if(Route::is('admin.attendancereport'))  active show  @endif" id="report" role="tabpanel" aria-labelledby="report-tab">
                <ul><li><a class="@if(Route::is('admin.attendancereport')) active   @endif" href="{{route('admin.attendancereport')}}">Attendance Report</a></li>
                </ul>
                </div>
                             @endif
                
                  <div class="tab-pane fade @if(Route::is('admin.policymanagement') || Route::is('addPolicy') || Route::is('updatePolicy') || Route::is('viewPolicy'))  active show  @endif" id="policy" role="tabpanel" aria-labelledby="policy-tab">
                <ul><li><a class="@if(Route::is('admin.policymanagement') || Route::is('addPolicy')) active   @endif" href="{{route('admin.policymanagement')}}">Policy</a></li>
                </ul>
                </div>
                
                  <div class="tab-pane fade @if(Route::is('admin.masterLeaves') || Route::is('masterallLeaves'))  active show  @endif" id="masterleave" role="tabpanel" aria-labelledby="master-leaves-tab">
                <ul><li><a class="@if(Route::is('admin.masterLeaves')) active   @endif" href="{{route('masterallLeaves')}}">Master Leaves</a></li>
                </ul>
                </div>
                <div class="tab-pane fade @if(Route::is('admin.userActivities') || Route::is('userActivities'))  active show  @endif" id="userActivities" role="tabpanel" aria-labelledby="user-activities-tab">
                <ul><li><a class="@if(Route::is('admin.userActivities')) active   @endif" href="{{route('userActivities')}}">User Activities</a></li>
                </ul>
                </div>
<!--                  <div class="tab-pane fade @if(Route::is('admin.payroll') || Route::is('admin.employeeSalary') || Route::is('addSalary') || Route::is('salaryEdit') || Route::is('salarySlip'))  active show  @endif" id="payroll" role="tabpanel" aria-labelledby="payroll-tab"> -->
<!--                 <ul><li><a class="@if(Route::is('admin.payroll')) active   @endif" href="{{route('admin.payroll')}}">Payroll Items</a></li> -->
<!--                 <li><a class="@if(Route::is('admin.employeeSalary')) active   @endif" href="{{route('admin.employeeSalary')}}">Employee Salary</a></li> -->
<!--                 </ul> -->
<!--                 </div> -->
            </div>
        </div>
    </div><!--Sidebar End-->
    <!-- Begin Page Content -->
    <div class="container-fluid">{{$slot}}</div>
    <!-- /.container-fluid -->
</main>
@stack('scripts')
<!-- JavaScript Libraries -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="{{asset('js/jquery.validate.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{asset('js/custom.js')}}"></script>


    <script>
    $(document).ready(function(){
        toastr.options ={
           "progressBar":true,
           "positionClass":"toast-top-right"
        }
    });
    
    window.addEventListener('success',event=>{
    	toastr.success(event.detail.message);
    });
     window.addEventListener('warning', event => {
    	toastr.warning(event.detail.message);
    });
     window.addEventListener('error',event => {
    	toastr.error(event.detail.message)
    });
             $(document).ready(function() {
             $('.read-message').click(function(){
                $.ajax({
                type: 'post',
                url: "{{ route('getNotification')}}",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                $('.notificationcount').text(response.data);
                $('.totalCount').text(response.data);
//                 console.log(response.data)
                 
                },
            });
             
             })
             });
     </script>
     
@stack('scripts')

@stack('modals')

@livewireScripts

<script>
    $(document).ready(function() {
        $(".js-select2").select2();
    });
</script>
<script>
    $(document).ready(function() {
        $(".js-select2-employee").select2();
    });
</script>
</body>

</html>
