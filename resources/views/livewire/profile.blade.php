<?php

use App\Models\Permission;
use App\Models\RolesPermission;
?>
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-head-box">
                        <h3>Profile</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="dashboardSection">
                   <div class="dashboardSection__body commonBoxShadow rounded-1">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-md-6">
                                <div class="outerSection">
                                    @if(@$userData->photo != '')
                                    <div class="imgSection">
                                        <img src="{{@$userData->photo}}"/>
                                          
                                    </div>  
                                    @endif
                                    <div class="detailSection">
                                        <h6 class="mb-1">  {{@$userData['first_name']}}&nbsp;  {{@$userData['last_name']}}</h6>
                                        <small>{{@$userData->getdepartment()->title}}</small>
                                        <p class="mb-1">{{@$userData->getdesignation()->title}}</p>
                                        <p>Employee ID:<span>{{@$userData['employee_id']}}</span></p>
                                        <!-- <a href="javascript:void(0);">Send Message</a> -->
                                    </div>
                                </div>
                                {{-- <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" wire:model="checked" wire:change="processMark()" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Status
                                    </label>
                                </div> --}}
                            </div>
                            
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="commonDetail borderSection">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <p>Email:</p>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <p class="green"><b>{{@$userData['email']}}</b></p>
                                        </div>
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <p>Password:</p>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <p class="green"><b>Softuvo@123</b></p>
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <p>Birth Date:</p>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <p><b>{{@$userData['date_of_birth']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <p>Joining Date:</p>
                                        </div>
                                        <div class="col-lg-7 col-md-7">
                                            <p><b>{{@$userData['joining_date']}}</b></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <p>Phone:</p>
                                        </div>
                                        <div class="col-lg-7 col-md-7">
                                            <p><b>{{@$userData['contact']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <p>Reporting Manager:</p>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <p><b>{{@$userData->getReportingmanager()}}</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="commonDetail">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Can this user login to the app?:</p>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <p><strong>{{(@$userData->app_login==1)?'No':'Yes'}}</strong></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Can this user receive email notification?</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <p><strong>{{(@$userData->email_notification==1)?'No':'Yes'}}</strong></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Workplace:</p>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <p><strong>{{(@$userData->workplace==1)?'WFO':'WFH'}}</strong></p>
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>
                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'personal_information'))) 

                            <div class="col-xl-1 col-lg-1 col-md-1">
                                <div class="editProfile text-end">
                                    <a  href="/employee/update/{{$userData->_id}}" 
                                        ><img src="/images/editIcon.svg" /></a>
                                </div>
                            </div>
                            @endif
                            
                        </div>
                    </div>

                <div class="dashboardSection__body commonBoxShadow rounded-1 mt-5">
                
                  
                    <ul class="nav nav-pills commonTabs" id="pills-tab" role="tablist">
                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('personal_information',1)) ||(Permission::userpermissions('emergency_contact',1)) || (Permission::userpermissions('official_contact_information',1)) || (Permission::userpermissions('family_information',1)) || (Permission::userpermissions('education_information',1)) || (Permission::userpermissions('joining_details',1)) ) 
                        <li class="nav-item" role="presentation" wire:ignore>
                            <button wire:click="$emit('active')" class="nav-link {{$tab == 'personal'?'active':''}}" wire:click="$set('tab', 'personal')" id="pills-personal-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-personal" type="button" role="tab"
                                aria-controls="pills-personal" aria-selected="true" data-tab="personal">Personal</button>
                        </li>
                        @endif
                      @if((Auth::user()->user_role==0)||(Permission::userpermissions('bank_information',1)) ||(Permission::userpermissions('bank_and_statutory',1)) ) 
                        <li class="nav-item" role="presentation" wire:ignore>
                            <button class="nav-link {{$tab == 'account'?'active':''}}" wire:click="$set('tab', 'account')" wire:click="$emit('active')" id="pills-account-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-account" type="button" role="tab"
                                aria-controls="pills-account" aria-selected="false" data-tab="account">Accounts & Statutory</button>
                        </li>
                        @endif
                         @if((Auth::user()->user_role==0)||(Permission::userpermissions('employment_and_job',1)) ) 
                        <li class="nav-item" role="presentation" wire:ignore>
                            <button class="nav-link {{$tab == 'experience'?'active':''}}"  id="pills-employment-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-employment" type="button" role="tab"
                                aria-controls="pills-employment" aria-selected="false" data-tab="experience">Employment & Job</button>
                        </li>
                        @endif
                       @if((Auth::user()->user_role==0)||(Permission::userpermissions('additional_detail',1))) 
                        <li class="nav-item" role="presentation" wire:ignore>
                            <button class="nav-link {{$tab == 'additional'?'active':''}}" wire:click="$emit('active')"   wire:click="$set('tab', 'additional')" id="pills-additional-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-additional" type="button" role="tab"
                                aria-controls="pills-additional" aria-selected="false" data-tab="additional">Additional Details</button>
                        </li>
                        @endif
                       @if((Auth::user()->user_role==0)||(Permission::userpermissions('payroll',1)) ) 

                        <li class="nav-item" role="presentation" wire:ignore>
                            <button wire:click="$set('tab', 'payroll')" wire:click="$emit('active')"  class="nav-link {{$tab == 'payroll'?'active':''}}" id="pills-payroll-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-payroll" type="button" role="tab"
                                aria-controls="pills-payroll" aria-selected="false">Payroll</button>
                        </li>
                        @endif
                       @if((Auth::user()->user_role==0)||(Permission::userpermissions('documents',1)) ) 

                        <li class="nav-item" role="presentation" wire:ignore>
                            <button wire:click="$emit('active')" class="nav-link {{$tab == 'document'?'active':''}}" id="pills-documents-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-documents" type="button" role="tab"
                                aria-controls="pills-documents" aria-selected="false" data-tab="document">Documents</button>
                        </li>
                        @endif
                          @if((Auth::user()->user_role==0)||(Permission::userpermissions('profile_attendance',1)) ) 

                        <li class="nav-item" role="presentation" wire:ignore>
                            <button wire:click="$emit('active')" class="nav-link {{$tab == 'attendance'?'active':''}}" id="pills-attendance-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-attendance" type="button" role="tab"
                                aria-controls="pills-attendance" aria-selected="false" data-tab="attendance">Attendance</button>
                        </li>
                        @endif
                          @if((Auth::user()->user_role==0)||(Permission::userpermissions('profile_leaves',1)) ) 

                        <li class="nav-item" role="presentation" wire:ignore >
                            <button wire:click="$emit('active')" class="nav-link {{$tab == 'leaves'?'active':''}}" id="pills-leaves-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-leaves" type="button" role="tab" aria-controls="pills-leaves"
                                aria-selected="false" data-tab="leaves"> Leaves</button>
                        </li>
                        @endif

<!--                         <li class="nav-item" role="presentation" wire:ignore> -->
<!--                             <button class="nav-link" id="pills-salary-tab" data-bs-toggle="pill" -->
<!--                                 data-bs-target="#pills-salary" type="button" role="tab" aria-controls="pills-salary" -->
<!--                                 aria-selected="false">Salary Slips</button> -->
<!--                          </li> -->

<!--                         <li class="nav-item" role="presentation" wire:ignore> -->
<!--                             <button class="nav-link" id="pills-awards-tab" data-bs-toggle="pill" -->
<!--                                 data-bs-target="#pills-awards" type="button" role="tab" aria-controls="pills-awards" -->
<!--                                 aria-selected="false">Awards & Recognitions</button> -->
<!--                         </li> -->

<!--                         <li class="nav-item" role="presentation" wire:ignore> -->
<!--                             <button class="nav-link" id="pills-history-tab" data-bs-toggle="pill" -->
<!--                                 data-bs-target="#pills-history" type="button" role="tab" -->
<!--                                 aria-controls="pills-history" aria-selected="false">Payroll History</button> -->
<!--                         </li> -->
                    </ul>
                </div>

                <div class="tab-content mt-5" id="pills-tabContent">
                    <!-- personal tab starts -->
                     <div class="tab-pane {{$tab == 'personal'?'show active jj':'fade kk'}}" id="pills-personal" role="tabpanel"
                        aria-labelledby="pills-personal-tab" tabindex="0">
                        <div class="row">
                            <div class="col-lg-6">
        					@if((Auth::user()->user_role==0)||(Permission::userpermissions('personal_information', 1)|| RolesPermission::userpermissions('personal_information',1)) ) 
                                <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                    @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'personal_information')|| RolesPermission::userpermissions('update',2, 'personal_information')) ) 
                                    <a class="editIcon"  wire:click="$set('tab', 'personal')" data-bs-toggle="modal" data-bs-target="#personalInfo2" href="javascript:void(0);">
                                        <img src="/images/editIcon.svg" />
                                    </a>
                                    @endif
                                    <h3>Personal Information</h3>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Gender:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{ucwords(@$userData['gender'])}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Whatsapp:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['whatsapp']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Personal Email:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['email']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Current Address:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['address']['current_address']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Permanent Address:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['address']['permanent_address']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Nationality:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['nationality']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Religion:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['religion']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Blood Group:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['blood_group']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Marital Status:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{ucwords(@$userData['marital_status'])}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Employment of spouse:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@ucfirst($userData['spouse_employment'])}}</b></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>No. of Children:</p>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['children']}}</b></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Passport No:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['passport_number']}}</b></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Passport Expiry Date:</p>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['passport_expiry_date'] != ''?date('d M Y', (int)$userData['passport_expiry_date']):''}}</b></p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if((Auth::user()->user_role==0)||(Permission::userpermissions('emergency_contact',1)|| RolesPermission::userpermissions('emergency_contact',1))) 
                                <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                    @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'emergency_contact')||RolesPermission::userpermissions('update',2, 'emergency_contact'))) 
                                    <a class="editIcon"  data-bs-toggle="modal" data-bs-target="#contactInfo" href="javascript:void(0);"><img src="/images/editIcon.svg" /></a>
                                    @endif
                                    <h3>Emergency Contact</h3>
                                    @if(!empty($contactinputs))
                                    @foreach($contactinputs as $key => $emergencyContact)

                                    <p class="green">Primary Contact {{$key+1}}</p>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Name<span class="red">*</span>:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$emergencyContact['name']}}</b></p>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Relationship<span class="red">*</span>:
                                            </p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$emergencyContact['relationship']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Phone<span class="red">*</span>:
                                            </p>
                                        </div>
                                     <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$emergencyContact['phone']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Phone No. 2:
                                            </p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$emergencyContact['phone_two']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Email:
                                            </p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$emergencyContact['email']}}</b></p>
                                        </div>
                                    </div>

                                    <hr />
                                     @endforeach
                                     @endif

                                </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                               @if((Auth::user()->user_role==0)||(Permission::userpermissions('joining_details',1)|| RolesPermission::userpermissions('joining_details',1)) )
                                <div class="profileCard commonBoxShadow rounded-1  mb-3">
                                    @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'joining_details')|| RolesPermission::userpermissions('update',2, 'joining_details')) )
                                    <a class="editIcon" data-bs-toggle="modal" wire:click="$set('tab', 'personal')" data-bs-target="#joiningDetail" href="javascript:void(0);">
                                        <img src="{{ asset('/images/editIcon.svg')}}" />
                                    </a>
                                    @endif
                                    <h3>Joining Details</h3>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Confirmation Date:</p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['joiningDetail']['confirmation_date'] != ''?date('d M Y', $userData['joiningDetail']['confirmation_date']):''}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Notice Period:
                                            </p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['joiningDetail']['notice_period']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Probation Period:
                                            </p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['joiningDetail']['probation_period']}}</b></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <p>Other Terms:
                                            </p>
                                        </div>

                                        <div class="col-lg-8 col-md-8">
                                            <p><b>{{@$userData['joiningDetail']['other_terms']}}</b></p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                   @if((Auth::user()->user_role==0)||(Permission::userpermissions('official_contact_information',1)|| RolesPermission::userpermissions('official_contact_information',1)) )
                                    <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                         @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'official_contact_information')|| RolesPermission::userpermissions('update',2, 'official_contact_information')) )
                                        <a class="editIcon" data-bs-toggle="modal" data-bs-target="#officialContact" href="javascript:void(0);">
                                            <img src="{{ asset('/images/editIcon.svg')}}" />
                                        </a>
                                        @endif
                                        <h3>Official Contact Information</h3>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <p>Redmine Username:</p>
                                            </div>

                                            <div class="col-lg-8 col-md-8">
                                                <p><b>{{@$userData['officialContact']['redmine_username']}}</b></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <p>Discord Username:
                                                </p>
                                            </div>

                                            <div class="col-lg-8 col-md-8">
                                                <p><b>{{@$userData['officialContact']['discord_username']}}</b></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <p>Skype ID:
                                                </p>
                                            </div>

                                            <div class="col-lg-8 col-md-8">
                                                <p><b>{{@$userData['officialContact']['skype_id']}}</b></p>
                                            </div>
                                        </div>

                                    </div>
                                    @endif
                                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('family_information',1)|| RolesPermission::userpermissions('family_information',1))) 
                                    <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                         @if(!empty(@$userData['families'][0]))
                                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'family_information')|| RolesPermission::userpermissions('update',2, 'family_information'))) 
                                        <a class="editIcon" data-bs-toggle="modal" data-bs-target="#familyInfo" href="javascript:void(0);">
                                            <img src="{{ asset('/images/editIcon.svg')}}" />
                                        </a>
                                        @endif
                                        @endif
                                        <h3>Family Information</h3>
                                        <div class="commonTableResponsive familyInformation">
                                            <table class="table">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Relationship</th>
                                                    <th>Date of Birth</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                                @if(!empty($userData['families']))
                                                @foreach($userData['families'] as $family)
                                                <tr>
                                                    <td data-label="Name">{{$family['name']}}</td>
                                                    <td data-label="Relationship">{{ucfirst($family['relationship'])}}</td>
                                                    <td data-label="Date of Birth">{{$family['date_of_birth'] != ''?date('d M Y', (int)$family['date_of_birth']):''}}</td>
                                                    <td data-label="Phone">{{$family['phone']}}</td>
                                                    <td data-label="Address">{{$family['address']}}</td>
                                                    <td data-label="Action">
                                                        <div class="dropdown">
                                                            <a class="btn btn-secondary dropdown-toggle" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </a>
                                                                                                   @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2, 'family_information')|| RolesPermission::userpermissions('create',2, 'family_information'))) 
                                                            
                                                           <ul class="dropdown-menu">
                                                                <!-- <li><a class="dropdown-item" wire:click="editFamilyInfo('{{$family['_id']}}')" data-bs-toggle="modal" data-bs-target="#editFamilyInfo" href="javascript:void(0);">Edit</a></li> -->
                                                                <li><a class="dropdown-item" onclick="confirm('Are you sure you want to remove the family member from this group?') || event.stopImmediatePropagation()" wire:click="deleteFamilyInfo('{{@$family['_id']}}')" href="javascript:void(0);">Delete</a></li>
                                                            </ul> 
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </table>
                                        </div>
                                       @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2, 'family_information')|| RolesPermission::userpermissions('create',2, 'family_information'))) 
                                        <a class="addBtn" data-bs-toggle="modal" data-bs-target="#editFamilyInfo" href="javascript:void(0);">Add New <img src="{{ asset('/images/addIcon.svg')}}" /></a>
                                        @endif
                                    </div>
                                    @endif
                                    @if((Auth::user()->user_role==0)||(Permission::userpermissions('education_information',1)|| RolesPermission::userpermissions('education_information',1)) )
                                    <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                        @if(!empty(@$userData['educationDetails'][0]))
                                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'education_information')||RolesPermission::userpermissions('update',2, 'education_information')) )
                                        <a class="editIcon"    wire:click="$set('tab', 'personal')"  data-bs-toggle="modal"  data-bs-target="#eduInfo" href="javascript:void(0);">
                                            <img src="{{ asset('/images/editIcon.svg')}}" />
                                        </a> 
                                        @endif
                                        @endif
                                        <h3>Education Information</h3>

                                        <ul class="eduList">
                                            @foreach($userData['educationDetails'] as $educationDetail)
                                                <li>
                                                    <p><b>{{$educationDetail['institute']}}</b></p>
                                                    <p>{{$educationDetail['degree']}}</p>
                                                    <p>{{$educationDetail['starting_date'] != ''?date('d M Y', (int)$educationDetail['starting_date']):''}} {{$educationDetail['starting_date'] != '' && $educationDetail['completed_date'] != ''?'-':''}} {{$educationDetail['completed_date'] != ''?date('d M Y', (int)$educationDetail['completed_date']):''}} {{$educationDetail['starting_date'] != '' && $educationDetail['completed_date'] != '' && $educationDetail['grade'] != ''?'.':''}} {{$educationDetail['grade']}}</p>
                                                    
                                                    @if(!empty($educationDetail['document']))
                                                        @php $extArr = explode('.',$educationDetail['document']); 
                                                        $nameArr = explode('/',$educationDetail['document']);
                                                        $extension = $extArr[count($extArr) - 1]; 
                                                        $name = $nameArr[count($nameArr) - 1]; @endphp
                                                      
                                                        @if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg'|| $extension == 'svg')
                                               
                                                            <a href="{{url('/download')}}/{{$name}}"><img height="50" width="50" src="{{$educationDetail['document'] }}" /><small>{{$name}}</small> </a>
                                                        @elseif($extension == 'pdf')
                                                            <a href="{{url('/download')}}/{{$name}}"><img src="{{ asset('/images/pdfIcon.svg')}}"> <small>{{$name}}</small> </a>
                                                        @else
                                                        
                                                           <a href="{{url('/download')}}/{{$name}}"><img height="50" width="50" src="{{ asset('/images/docIcon.svg')}}"> <small>{{$name}}</small> </a>
                                                        @endif

                                                    @endif
                                                 
                                                

                                                        <div class="dropdown">
                                                            <a class="btn btn-secondary dropdown-toggle" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </a>
                                                           @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'education_information')|| RolesPermission::userpermissions('delete',1, 'education_information')) )
                                                           <ul class="dropdown-menu">
                                                               
                                                                <li><a class="dropdown-item" onclick="confirm('Are you sure you want to remove the Education info from this group?') || event.stopImmediatePropagation()" wire:click="deleteEduInfo('{{@$educationDetail['_id']}}')" href="javascript:void(0);">Delete</a></li>
                                                            </ul> 
                                                            @endif
                                                        </div>
                                                    </li>
                                            @endforeach
                                        </ul>
                                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2, 'education_information')||RolesPermission::userpermissions('create',2, 'education_information')) )
                                        <a class="addBtn mt-4"  data-bs-toggle="modal" data-bs-target="#addEduInfo" href="javascript:void(0);">Add New <img src="{{ asset('/images/addIcon.svg')}}" /></a>
                                        @endif

                                </div>
                                @endif
                              
                            </div>
                        </div>
                    </div>
                    <!-- personal ends -->

                    <!-- account tab starts -->
                    <div class="tab-pane {{$tab == 'account'?'show active':'fade'}}" id="pills-account" role="tabpanel"
                        aria-labelledby="pills-account-tab" tabindex="0">
                        <div class="row">
                            <div class="col-lg-6">
                                @if((Auth::user()->user_role==0)||(Permission::userpermissions('bank_information',1)|| RolesPermission::userpermissions('bank_information', 1)) )
                                <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                      @if((Auth::user()->user_role==0)||(Permission::userpermissions('update','2','bank_information')|| RolesPermission::userpermissions('bank_information', 1)) )
                                    <a class="editIcon" data-bs-toggle="modal" data-bs-target="#bankInfo" href="javascript:void(0);">
                                        <img src="{{ asset('/images/editIcon.svg')}}" />
                                    </a>
                                    @endif
                                    <h3>Bank Information</h3>
                               
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Name as per Bank Records:</p>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <p class="green"><strong>{{ucwords(@$userData['bankDetail']['username'])}}</strong></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Bank Name:</p>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <p class="green"><strong>{{@$userData['bankDetail']['bank_name']}}</strong></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Bank Account No:</p>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <p class=""><strong>{{@$userData['bankDetail']['account']}}</strong></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>IFSC Code:</p>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <p class=""><strong>{{@$userData['bankDetail']['ifsc']}}</strong></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>PAN No:</p>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <p class=""><strong>{{@$userData['bankDetail']['pan']}}</strong></p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                               @if((Auth::user()->user_role==0)||(Permission::userpermissions('bank_and_statutory',1)) )
                                <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                                                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'bank_and_statutory')) )
                                
                                    <a class="editIcon" data-bs-toggle="modal" data-bs-target="#statutoryInfo" href="javascript:void(0);">
                                        <img src="/images/editIcon.svg" />
                                    </a>
                                    @endif
                                    <h3>Bank & Statutory</h3>
                                    <p class="green"><strong>ESI Account:</strong></p>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" {{ @$userData['statutoryInfo']['esi'] == '1'?'checked':''}}  class="form-check-input" id="exampleCheck1" disabled>
                                        <label class="form-check-label" for="exampleCheck1">Employee is covered
                                            under ESI</label>
                                    </div>
                                    @if(@$userData['statutoryInfo']['esi'] != '1')
                                        <p class="warning"><span><img src="/images/warningIcon.svg" /> Not covered under ESI.</span></p>
                                    @endif

                                    <p class="green mt-5"><strong>PF Account:</strong></p>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" {{ @$userData['statutoryInfo']['pf'] == '1'?'checked':''}} class="form-check-input" id="exampleCheck2" disabled>
                                        <label class="form-check-label" for="exampleCheck1">Employee is covered
                                            under PF</label>
                                    </div>

                                    <p><small><strong>PF KYC Not Done !</strong></small></p>
                                    <p class="not-verify mt-3">
                                        <span>No verified employee identify found.</span>
                                    </p>
                                    @if(@$userData['statutoryInfo']['pf'] != '1')

                                        <p class="warning mt-3"><span><img src="/images/warningIcon.svg" /> Not covered under PF.</span></p>
                                    @endif
                                </div>
                               @endif
                            </div>
                        </div>
                    </div>
                     <!-- account tab ends -->
                   
                    <!-- employeement tab starts -->
                    <div class="tab-pane {{$tab == 'experience'?'show active':'fade'}}" id="pills-employment" role="tabpanel"
                        aria-labelledby="pills-employment-tab" tabindex="0">
                        <div class="row">
                            <div class="col-lg-6">
                                @if((Auth::user()->user_role==0)||(Permission::userpermissions('employment_and_job',1)|| RolesPermission::userpermissions('employment_and_job', 1)) )
                                <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                        @if(!empty(@$userData['experienceDetails'][0]))
                                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'employment_and_job')|| RolesPermission::userpermissions('update',2,'employment_and_job')) )

                                    <a data-bs-toggle="modal" wire:click="$set('tab', 'experience')" data-bs-target="#experienceInfo" class="editIcon" href="javascript:void(0);">
                                        <img src="{{ asset('/images/editIcon.svg')}}">
                                    </a>
                                    @endif

                                    @endif
                                    <h3>Experience Information</h3>

                                    <ul class="eduList">
                                        @if(!empty($userData['experienceDetails']))
                                            @foreach($userData['experienceDetails'] as $experienceDetail)
                                                <li>
                                                    <p><b>{{$experienceDetail['designation']}} at {{$experienceDetail['company_name']}}</b></p>
                                                    <p><b>{{$experienceDetail['period_from'] != ''?date('d M Y', (int)$experienceDetail['period_from']):''}} {{$experienceDetail['period_from'] != '' && $experienceDetail['period_to'] != ''?'-':''}} {{$experienceDetail['period_from'] != ''?date('d M Y', (int)$experienceDetail['period_to']):''}}
                                                    {{$experienceDetail['period_from'] != '' && $experienceDetail['period_to'] != '' && $experienceDetail['relevant_experience'] != '' ?'.':''}} {{$experienceDetail['relevant_experience'] != ''?'('.$experienceDetail['relevant_experience'].')':''}} {{$experienceDetail['net_pay'] != ''?'.':''}} {{$experienceDetail['net_pay']}}</b>
                                                    </p>
                                                    <p>{{$experienceDetail['company_city']}} {{$experienceDetail['company_state']}} {{$experienceDetail['country']}} {{$experienceDetail['company_pincode']}}</p>
                                                    <p>{{$experienceDetail['manager_name']}} {{$experienceDetail['manager_designation'] != ''?($experienceDetail['manager_designation']):''}} {{$experienceDetail['manager_contact'] != ''?'.':''}} {{$experienceDetail['manager_contact']}} {{$experienceDetail['manager_email'] != ''?'.':''}} {{$experienceDetail['manager_email']}}</p>

                                                     @if(!empty($experienceDetail['documents']))
                                                @php $extArr = explode('.',$experienceDetail['documents']); 
                                                $nameArr = explode('/',$experienceDetail['documents']);
                                                $extension = $extArr[count($extArr) - 1]; 
                                                $name = $nameArr[count($nameArr) - 1]; @endphp
                                              
                                                @if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg'|| $extension == 'svg')
                                       
                                                    <a href="{{url('/download')}}/{{$name}}"><img height="50" width="50" src="{{$experienceDetail['documents'] }}" /><small>{{$name}}</small> </a>
                                                @elseif($extension == 'pdf')
                                                    <a href="{{url('/download')}}/{{$name}}"><img src="{{ asset('/images/pdfIcon.svg')}}"> <small>{{$name}}</small> </a>
                                                @else
                                                
                                                   <a href="{{url('/download')}}/{{$name}}"><img height="50" width="50" src="{{ asset('/images/docIcon.svg')}}"> <small>{{$name}}</small> </a>
                                                @endif

                                        @endif
                                                </li>
                                            @endforeach
                                        @endif

                                   
                                    </ul>
                                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2,'employment_and_job')|| RolesPermission::userpermissions('create',2,'employment_and_job')) )
                                    <a  class="addBtn" data-bs-toggle="modal" data-bs-target="#addExperienceInfo" href="javascript:void(0);">Add New <img src="/images/addIcon.svg"></a>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!-- employeement tab ends -->

                        <!-- additionalm information starts -->
                               @if((Auth::user()->user_role==0)||(Permission::userpermissions('additional_detail',1)) )
                        <div class="tab-pane {{$tab == 'additional'?'show active':'fade'}}" id="pills-additional" role="tabpanel" aria-labelledby="pills-additional-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                                           @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'additional_detail')|| RolesPermission::userpermissions('update',2,'additional_detail')) ) 
                                    
                                        <a class="editIcon"   wire:click="$set('tab', 'additional')" data-bs-toggle="modal" data-bs-target="#additionalInfo" href="javascript:void(0);">
                                            <img src="{{ asset('/images/editIcon.svg')}}">
                                        </a>
                                        @endif
                                        <h3>Additional Details</h3>

                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <p>Allergies:</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <p><strong>{{ucwords(@$userData['additionalInfo']['allergies'])}}</strong></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <p>Smoke:</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <p><strong>{{ucwords(@$userData['additionalInfo']['smoke'])}}</strong></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <p>Drink:</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <p><strong>{{ucwords(@$userData['additionalInfo']['drink'])}}</strong></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <p>Diet:</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <p><strong>{{ucwords(@$userData['additionalInfo']['diet'])}}</strong></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <p>Hobbies:</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <p><strong>{{@$userData['additionalInfo']['hobbies']}}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- additional information ends -->
                    <!-- payroll tab starts -->
                    <div class="tab-pane {{$tab == 'payroll'?'show active':'fade'}}" id="pills-payroll" role="tabpanel"
                        aria-labelledby="pills-payroll-tab" tabindex="0">
                        <div class="row">
                            <div class="col-lg-5">
                              @if((Auth::user()->user_role==0)||(Permission::userpermissions('payroll',1)|| RolesPermission::userpermissions('payroll',1)) ) 
                                <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                   @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'payroll')|| RolesPermission::userpermissions('update',2,'payroll')) ) 
                                    <a class="editIcon" data-bs-toggle="modal" data-bs-target="#payrollInfo" href="javascript:void(0);">
                                        <img src="{{ asset('/images/editIcon.svg')}}">
                                    </a>
                                    @endif
                                    <h3>Payroll</h3>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Annual CTC:</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <p><strong>8,70,000</strong></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Basic Salary:</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <p class="green"><strong>----</strong></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Allowances:</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <p><strong>1500</strong></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Deductions:</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <p><strong>2500</strong></p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- payroll tab ends -->

                     <!-- document tab starts -->
                    @if((Auth::user()->user_role==0)||(Permission::userpermissions('documents',1)|| RolesPermission::userpermissions('documents',1)) ) 
                    <div class="tab-pane {{$tab == 'document'?'show active':'fade'}}" id="pills-documents" role="tabpanel"
                        aria-labelledby="pills-documents-tab" tabindex="0">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                    <h3>Documents</h3>
                                    @foreach($userData['documents'] as $userdocument)
                                        @php $extArr = explode('.',$userdocument['document']); 
                                                $nameArr = explode('/',$userdocument['document']);
                                                $extension = $extArr[count($extArr) - 1]; 
                                                $name = $nameArr[count($nameArr) - 1]; @endphp
                                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'documents')|| RolesPermission::userpermissions('update',2,'documents')) ) 
                                        <div class="cardActionBtns">
                                           @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'documents')|| RolesPermission::userpermissions('update',2,'documents')) ) 
                                            <a class="" wire:click="editDocument('{{$userdocument['_id']}}')" data-bs-toggle="modal" data-bs-target="#editDocumentInfo" href="javascript:void(0);">
                                                <img src="{{ asset('/images/editIcon.svg')}}">
                                            </a> 
                                            @endif
                                            @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2,'documents')|| RolesPermission::userpermissions('delete',2,'documents')) ) 
                                            <a class="" onclick="confirm('Are you sure you want to remove the document from this group?') || event.stopImmediatePropagation()" wire:click="deleteDocument('{{$userdocument['_id']}}')"  href="javascript:void(0);">
                                                <img src="{{ asset('/images/deleteIcon.svg')}}">
                                            </a>
                                            @endif
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <p>Document Name:</p>
                                            </div>
                                            <div class="col-lg-8 col-md-8">
                                                @if($userdocument['document'] != '')
                                                    @if($userdocument['type'] == 'pdf')
                                                               @if((Auth::user()->user_role==0)||(Permission::userpermissions('download',2,'documents')|| RolesPermission::userpermissions('download',2,'documents')) ) 
                                                            <a href="{{url('/download')}}/{{$name}}"><p><strong><img src="{{ asset('/images/pdfIcon.svg')}}" /> {{$userdocument['name']}}</strong></p></a>
                                                            @endif
                                                    @else
                                                            @if((Auth::user()->user_role==0)||(Permission::userpermissions('download',2,'documents')|| RolesPermission::userpermissions('download',2,'documents')) ) 
                                                            <a href="{{url('/download')}}/{{$name}}"><p><strong><img width="50" height="50" src="{{ asset('/images/docIcon.svg')}}" /> {{$userdocument['name']}}</strong></p></a>
                                                            @endif
                                                        

                                                    @endif
                                                @else
                                                    <p><strong>{{$userdocument['name']}}</strong></p>

                                                @endif
                                            
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <p>Document Type: </p>
                                            </div>
                                            <div class="col-lg-8 col-md-8">
                                                <p class="green"><strong>.{{$userdocument['type']}} File</strong></p>
                                            </div>
                                        </div>
                                    @endforeach
                                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2,'documents')|| RolesPermission::userpermissions('create',2,'documents')) ) 

                                    <a class="addBtn mt-5" data-bs-toggle="modal" data-bs-target="#documentInfo"  wire:click="resetDoc"  href="javascript:void(0);">Add New <img src="/images/addIcon.svg"></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- attendance tab starts -->
                    <div class="tab-pane {{$tab == 'attendance'?'show active':'fade'}}" id="pills-attendance" role="tabpanel"
                        aria-labelledby="pills-attendance-tab" tabindex="0">
                          @if((Auth::user()->user_role==0)||(Permission::userpermissions('profile_attendance',1)) ) 
                        <div class="profileCard commonBoxShadow rounded-1 mb-3">
                            <h3>Attendance</h3>

                            <div class="pageFilter mb-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="leftFilters">
                                            <div class="col-lg-3">
                                                <div class="form-group" wire:ignore>
                                                    <label for="">Month</label>
                                                    <select class="form-select month" wire:model="month" id="floatingSelect"
                                                        aria-label="Floating label select example">
                                                        @php $selected_month = date('m'); @endphp
                                                        @for ($i_month = 01; $i_month <= 12; $i_month++)
                                                        <option value="{{sprintf('%02d',$i_month)}}">{{date('F', mktime(0,0,0,$i_month))}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group" wire:ignore>
                                                    <label for="floatingSelect">Year</label>
                                                    <select class="form-select year" wire:model="year" id="floatingSelect"
                                                        aria-label="Floating label select example">
                                                        @php $selected_year = date('Y'); @endphp
                                                        @for ($i_year = $selected_year-5; $i_year <= $selected_year+1; $i_year++)
                                                            <option value="{{$i_year}}" {{ $selected_year == $i_year ?'selected':''}}>{{$i_year}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
<!--                                             <div class="col-lg-3"> -->
<!--                                                 <div class="attendanceSearchBtn"> -->
<!--                                                     <button class="btn btn-search"><img src="/images/iconSearch.svg" /> Search here</button> -->
<!--                                                 </div> -->
<!--                                             </div>     -->
                                        <div class="row">
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="commonDataTable">
                                <div class="table-responsive">
                                    <table class="table mt-5">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Punch In</th>
                                                <th>Punch Out</th>
                                                <th>Production</th>
                                                <th>Break</th>
                                                <th>Others</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($allAttendances as $k =>$allAttendance)

                                                @php
                                                    $hrs = '';
                                                    $mins = '';
                                                    if(@$allAttendance['details'][count($allAttendance['details'])-1]['punch_out'] != ''){
                                               
                                                        $time1 = new \DateTime(date('Y-m-d H:i', (int)$allAttendance['details'][0]['punch_in']));
                                                        $time2 = new \DateTime(date('Y-m-d H:i', $allAttendance['details'][count($allAttendance['details'])-1]['punch_out']));
                                                        $diff = $time1->diff($time2);
                                                        $hrs = $diff->h;
                                                        $mins = $diff->i;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $allAttendances->firstItem()+$k }}</td>
                                        
                                                    <td>{{ date('d M Y', (int)@$allAttendance['date']) }}</td>
                                                    
                                                    <td> {{ date('h:i A', (int)@$allAttendance['details'][0]['punch_in']) }} </td>
                                                    
                                                    <td> {{ $hrs != '' && $mins != '' ?date('h:i A',(int)$allAttendance['details'][count($allAttendance['details'])-1]['punch_out']):'-' }}</td>
                                                    
                                                    <td>{{ $allAttendance->productionTime() }}</td>
                                                    
                                                    <td>{{$allAttendance->breakTime()}}</td>
                                                    
                                                    <td>0</td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                                                                
                                    </table>
                                </div>
                            </div>
                            {{ $allAttendances->links() }}
                        </div>
                        @endif
                    </div>
                    <!-- attendance tab ends -->
                   
                    <!-- Leaves tabs starts -->
                    <div class="tab-pane {{$tab == 'leaves'?'show active':'fade'}}" id="pills-leaves" role="tabpanel" aria-labelledby="pills-leaves-tab" tabindex="0">
                    @if((Auth::user()->user_role==0)||(Permission::userpermissions('profile_leaves',1)|| RolesPermission::userpermissions('profile_leaves',1)) ) 
                        <div class="profileCard commonBoxShadow rounded-1 mb-3">

                            <h3>Leaves</h3>
                            <div class="pageFilter mb-3 mt-4 p-0">
                                <div class="row">
<!--                                     <div class="col-lg-5"> -->
<!--                                         <div class="leftFilters"> -->
<!--                                            <div class="form-floating"> -->
<!--                                                 <input type="date" class="form-control " wire:model="fromsearch_date"> -->

<!--                                                 <label for="floatingInput">From</label> -->
<!--                                                 <span class="form-control-icon"> -->
                                                    <!-- <img src="images/calenderIcon.svg" /> -->
<!--                                                 </span> -->
<!--                                             </div> -->

<!--                                             <div class="form-floating"> -->
<!--                                                 <input type="date" class="form-control " wire:model="tosearch_date"> -->

<!--                                                 <label for="floatingInput">To</label> -->
<!--                                                 <span class="form-control-icon"> -->
                                                    <!-- <img src="images/calenderIcon.svg" /> -->
<!--                                                 </span> -->
<!--                                             </div> -->
        

                                            <!-- <button class="btn btn-search"><img src="/images/iconSearch.svg" /> Search here</button> -->
<!--                                         </div> -->
<!--                                     </div> -->
                                </div>
                            </div>
                             @if ($check)
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary modalcanceleffect" style="background-color:red;" onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()"
                                 wire:click="deleteRecords()">
                                    Delete ({{ count($check) }})
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
                                    You have selected <strong>{{ count($check) }}</strong> items, Do
                                    you want to Select All <strong>{{ $leaves->total() }}</strong>? 
                                </div>
                                @endif
                            </div>
                            @endif

                            <div class="commonDataTable">
                                <div class="table-responsive">
                                    <table class="table mt-3">
                                        <thead>
                                            <tr>
<!--                                                 <th> -->
<!--                                                     <div class="form-check d-flex justify-content-center"> -->
<!--                                                     <input class="form-check-input" wire:model="selectPage" type="checkbox" value="" id="flexCheckDefault"> -->
<!--                                                   </div> -->
<!--                                               </th> -->
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Leave Type</th>
                                                <th>Reason</th>
                                                <th>Leave Status</th>
<!--                                                 <th>Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(empty($leaves) || count($leaves) == 0)
                                                <tr><td class="text-center" colspan="9">No Data Found</td></tr>
                                            @else    
                                                @foreach($leaves as $employ)
                                                    <tr> 
<!--                                                         <td> -->
<!--                                                             <div class="form-check d-flex justify-content-center"> -->
<!--                                                                 <input class="form-check-input" type="checkbox" value="{{$employ->_id}}" id="flexCheckDefault"  wire:model="che"> -->
<!--                                                             </div> -->
<!--                                                         </td> -->
                                                      
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
<!--                                                         <td> -->
<!--                                                             <div class="actionIcons"> -->
<!--                                                                 <ul> -->
<!--                                                                     <li><a class="edit" data-bs-toggle="modal" data-bs-target="#leaveModal"  wire:click="edit('{{ $employ->id }}')" href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li> -->
<!--                                                                 </ul> -->
<!--                                                             </div> -->
<!--                                                         </td> -->
                                                    </tr>
                                                @endforeach
                                            @endif   
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{$leaves->links()}}


                        </div>
                        @endif
                    </div>
                   
                    <!-- Salaryslip tab start -->
                    <div class="tab-pane fade" id="pills-salary" role="tabpanel" aria-labelledby="pills-salary-tab" tabindex="0">
                        <div class="profileCard commonBoxShadow rounded-1 mb-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>Salary Slips for the Month of March 2023</h3>
                                </div>

                                <div class="col-lg-6">
                                    <div class="text-end">
                                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                                            <button type="button" class="btn">CSV</button>
                                            <button type="button" class="btn">PDF</button>
                                            <button type="button" class="btn">
                                                <span><img src="/images/printIcon.svg" /></span> Print
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="company">
                                        <div class="company__logo">
                                            <img class="mini-logo" src="/images/mini-logo-green.svg" alt="mini-logo-green" />
                                        </div>
                                        <div class="company__name">
                                            <h4>Softuvo Solution Pvt. Ltd.</h4>
                                            <p>D-199, Industrial Area, Phase - 8B, Mohali</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="company justify-content-end">
                                        <div class="company__name company__name--right">
                                            <h4>PAYSLIP #49029</h4>
                                            <p>Salary Month: March, 2023</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="employeeDetail mb-5">
                                        <h5>Alex John</h5>
                                        <p><small>Designing Department</small></p>
                                        <p><b>UI Designer</b></p>
                                        <p>Employee ID: <b>SSPLO1</b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="salaryTable">
                                        <h3>Earnings</h3>
                                        <table class="table">
                                            <tr>
                                                <td>Basic Salary</td>
                                                <td class="text-end">25,200</td>
                                            </tr>

                                            <tr>
                                                <td>House Rent Allowance (H.R.A.)</td>
                                                <td class="text-end">9,408</td>
                                            </tr>

                                            <tr>
                                                <td>Conveyance</td>
                                                <td class="text-end">1,493</td>
                                            </tr>

                                            <tr>
                                                <td>Other Allowance</td>
                                                <td class="text-end">1,167</td>
                                            </tr>

                                            <tr>
                                                <td>Total Earnings</td>
                                                <td class="text-end">37,268</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="salaryTable">
                                        <h3>Deductions</h3>
                                        <table class="table">
                                            <tr>
                                                <td>Tax Deducted at Source (T.D.S.)</td>
                                                <td class="text-end">0</td>
                                            </tr>

                                            <tr>
                                                <td>Provident Fund</td>
                                                <td class="text-end">1,800</td>
                                            </tr>

                                            <tr>
                                                <td>ESI</td>
                                                <td class="text-end">500</td>
                                            </tr>

                                            <tr>
                                                <td>Loan</td>
                                                <td class="text-end">0</td>
                                            </tr>

                                            <tr>
                                                <td>Total Deductions</td>
                                                <td class="text-end">2,300</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <p class="mt-2"><b>Net Salary: 34968</b> (Thirty four thousand nine hundred and sixty eight only.)</p>
                        </div>
                    </div>
                    <!-- Salaryslip tab ends -->

                    <!-- Awards tab starts -->
                    <div class="tab-pane fade" id="pills-awards" role="tabpanel" aria-labelledby="pills-awards-tab" tabindex="0">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                    <a class="editIcon" href="javascript:void(0);">
                                        <img src="/images/editIcon.svg" />
                                    </a>
                                    <h3>Awards & Recognitions</h3>

                                    <ul class="eduList">
                                        <li>
                                            <p><b>Employee of the Month</b></p>
                                            <p class="grey pb-2">May 2023</p>
                                        </li>

                                        <li>
                                            <p><b>Employee of the Quarter</b></p>
                                            <p class="grey pb-2">Dec 2022</p>
                                        </li>

                                        <li>
                                            <p><b>General Appreciation of Achievement</b></p>
                                            <p class="grey pb-2">Oct 2022</p>
                                        </li>

                                        <li>
                                            <p><b>Employee of the Month</b></p>
                                            <p class="grey pb-2">Jan 2022</p>
                                        </li>
                                    </ul>
                                    <!-- <a class="addBtn" href="javascript:void(0);">Add New <img src="/images/addIcon.svg" /></a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Award tab ends -->

                    <!-- Payroll history starts -->
                    <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab" tabindex="0">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="profileCard commonBoxShadow rounded-1 mb-3">
                                    <a class="editIcon" href="javascript:void(0);">
                                        <img src="/images/editIcon.svg">
                                    </a>
                                    <h3>Payroll History</h3>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Annual CTC:</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <p><strong>8,70,000</strong></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Basic Salary:</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <p class="green"><strong>----</strong></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Allowances:</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <p><strong>1500</strong></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Deductions:</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <p><strong>2500</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Payroll history ends -->
                </div>
            </div>
        </div>
    </div>
   
<!-- personal info modal starts -->
<div class="modal fade personalInfo"  wire:ignore.self id="personalInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Profile Information</h3>
                {{-- <form wire:submit.prevent="updateProfile" enctype="multipart/form-data" > --}}
                    <form wire:submit.prevent="updateProfile" enctype="multipart/form-data" autocomplete="false">
                        <div x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-error="uploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress" class="userProfileSection">
                            @if($photo)
                                <img src="{{$photo->temporaryUrl()}}" />
                                <!-- Progress Bar -->
                                <div x-show="uploading">
                                    <progress max="100" x-bind:value="progress"></progress>
                                </div>
                            @else
                                <img src="{{$image}}"/>
                            @endif
                            <div wire:loading>
                                Processing...
                            </div>
                            <span>
                                edit
                              <input title="Upload Image"  type="file" wire:model="photo"  />
                              <img id="preview" src="#" alt="your image" class="mt-3" style="display:none;"/>
                              @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                            </span>
                        </div>
                        {{-- @if($hideid)
                        <h3 class="text-center green mt-4">{{$employee_id}}</h3>
                        @endif --}}
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
                                        <select name="dapartment"  id="department" class="form-control"  wire:model="department">
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
                                        <select name="designation" id="designation" class="form-control" wire:model="designation" >
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
                                        <select class="form-control manager" wire:model="reporting_manager"  id="reporting_manager">
                                            <option value='option-1' data-src="images/userImg.png">Reporting Manager</option>
                                            @foreach($employees as $user)
                                            <option value='{{$user->_id}}' data-src="http://placehold.it/45x45">{{$user->first_name}}</option>
                                        @endforeach
                                        </select>
                                        @error('reporting_manager') <span class="text-danger">{{ $message }}</span>@enderror 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group"  wire:ignore.self>
                                        <label>Can this user login to the app?<sup>*</sup></label>
                                        <select class="form-control" id="app_login"  wire:model="app_login">
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
                                        <select class="form-control" id="email_notification" wire:model="email_notification">
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
                                        <select class="form-control" id="workplace" wire:model="workplace">
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
                                        <select class="form-control"  id="user_status" wire:model="status">
                                            <option  value="" selected>Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                      
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group" wire:ignore.self >
                                        <label>User Role<sup>*</sup></label>
                                        <select class="form-control"  id="user_role" wire:model="user_role">
                                            <option  value="" selected>Select User Role</option>
                                            @foreach($roles as $user)
                                            <option value="{{$user->id}}" > {{$user->name}}</option>
                                            @endforeach
                                        </select>
                                      
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
    <!-- personal info2 modal starts -->
<div wire:ignore.self class="modal fade personalInfo" id="personalInfo2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Personal information</h1>
                <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <h3 class="text-center">Personal Information</h3> -->
                <form wire:submit.prevent="submitProfileInfo" enctype="multipart/form-data" class="px-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" wire:ignore.self>
                                <label for="gender">Gender</label>
                                <select wire:model="gender" name="gender" id="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>

                                @error("gender")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="WhatsApp">Whatsapp</label>
                                <input wire:model="whatsapp" type="phone" class="form-control" placeholder="Enter Whatsapp" />
                                @error("whatsapp")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Personal Email</label>
                                <input type="email" wire:model="email" class="form-control" placeholder="Enter Personal Email" />
                                @error("email")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nationality">Nationality<sup>*</sup></label>
                                <select wire:model="nationality"  class="form-control country">
                                    <option value="">Select Nationality</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <!-- <input wire:model="nationality" type="text" class="form-control" placeholder="Enter Nationality" /> -->
                                @error("nationality")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Religion</label>
                                <input type="text" wire:model="religion" class="form-control" placeholder="Enter Religion" />
                                @error("religion")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="bloodGroup">Blood Group</label>
                                 <select wire:model="blood_group" class="form-control js-select2">
                                    <option value="">Select Blood Group</option>
                                   @foreach($bloodGroup as $blood)
                                    <option value="{{$blood->_id}}">{{$blood->blood_group}}</option>
                                   @endforeach
                                </select>
                                

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="martialStatus">Martial Status<sup>*</sup></label>
                                <select wire:model="marital_status" class="form-control" id="marital_status">
                                    <option value="">Select Martial Status</option>
                                    <option value="married">Married</option>
                                    <option value="single">Single</option>
                                </select>
                                
                               @error("marital_status")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group" wire:ignore.self>
                                <label>Employment of Spouse</label>
                                <select wire:model="spouse_employment" class="form-control" id="spouse_employment">
                                    <option value="" selected>Select Spouse Employment</option>
                                    <option value="private">Private</option>
                                    <option value="public">Public</option>
                                </select>
                                 @error("spouse_employment")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group" wire:ignore.self>
                                <label>No. of Children</label>
                                    <input wire:model="children" type="text" class="form-control" placeholder="No. of Children" />  
                                {{-- <select wire:model="children"  id="children" class="form-control">
                                    <option value="" selected>Select children</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select> --}}
                                 @error("children")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Passport No.</label>
                                <input wire:model="passport_number" type="text" class="form-control" placeholder="Enter Passport No." />
                                 @error("passport_number")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Passport Expiry Date</label>
                                <input wire:model="passport_expiry_date" type="date" class="form-control" placeholder="Enter Date" />
                                 @error("passport_expiry_date")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                    </div>

                    <h3 class="my-4">Current Address</h3>

                    <div class="row">

                         <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="state">State</label>
                                {{--<select wire:model="selectedCurrentState"  class="form-control country">
                                    <option value="">Select State</option>
                                  
                                        @foreach($this->currentStates as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                   
                                </select> --}}
                                <input wire:model="current_state_id" type="text" class="form-control" placeholder="Enter State" /> 
                                  @error("current_state_id")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                               
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="city">City</label>
                                  {{-- <select wire:model="selectedCurrentCity"  class="form-control country">
                                    <option value="">Select City</option>
                                        @foreach($this->currentCities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                </select> --}}
                                 <input wire:model="current_city_id" type="text" class="form-control" placeholder="Enter City" /> @error("current_city_id")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country</label>
                                <select wire:model="selectedCurrentCountry" id="current-countries" class="form-control country">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->_id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error("selectedCurrentCountry")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Zipcode</label>
                                <input type="number" wire:model="currentzipcode" class="form-control" placeholder="Enter Zipcode" />
                                @error("currentzipcode")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input wire:model="currentaddress" type="text" class="form-control" placeholder="Enter Address" />
                                @error("currentaddress")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="1" wire:click="copyAddress" name="present" id="flexCheckDefault" {{ $disabled?'checked disabled':''}} {{ $present == '1'?'checked':''}}>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Same as Present
                                </label>
                            </div>
                        </div>

                        
                    </div>

                    <h3 class="my-4">Permanent Address</h3>

                    <div class="row">
                         <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="state">State</label>
                                {{-- <select wire:model="selectedPermanentState"  class="form-control country">
                                    <option value="">Select State</option>
                                  
                                        @foreach($this->permanentStates as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                   
                                </select> --}}
                                <input wire:model="permanent_state_id" type="text" class="form-control" placeholder="Enter State" /> 
                                   @error("permanent_state_id")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="city">City</label>
                                 {{-- <select wire:model="selectedPermanentCity"  class="form-control country">
                                    <option value="">Select City</option>
                                        @foreach($this->permanentCities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                </select> --}}
                               <input wire:model="permanent_city_id" type="text" class="form-control" placeholder="Enter City" /> @error("permanent_city_id")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>
                         <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country</label>
                                <select wire:model="selectedPermanentCountry" id="permanent-countries" class="form-control country">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->_id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error("selectedPermanentCountry")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Zipcode</label>
                                <input type="number" wire:model="permanentzipcode" class="form-control" placeholder="Enter Zipcode" />
                                @error("permanentzipcode")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" wire:model="permanentaddress" class="form-control" placeholder="Enter Address" />
                                @error("permanentaddress")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mt-4 addoffmodalfoot">
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>


                                <button class="btn commonButton ml-1" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- personal info2 modal ends -->


<!-- contact information modal starts -->
<div wire:ignore.self class="modal fade personalInfo" id="contactInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Emergency Contact Information</h1>
                <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <h3 class="text-center">Emergency Contact Information</h3> -->
                <form wire:submit.prevent="submitEmergencyContact" class="px-3">
                @for($i=0; $i< count($contactinputs) ; $i++)

                    <h3 class="mb-2 fs-5 d-flex justify-content-between align-items-center">Primary Contact {{$i+1}}
                    @if( count($contactinputs) > 1)
                    <a  class="refressData"  wire:click='removeContactInfo({{$i}})' href="javascript:void(0);">
                    <span><img src="{{ asset('/images/binIcon.svg')}}" /></span></a>
                    @endif
                  </h3>
                       
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="name">Name <sup>*</sup></label>
                                <input wire:model='contactinputs.{{$i}}.name' type="text" class="form-control" placeholder="Enter Name" />
                                @error("contactinputs.{$i}.name")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="relationship">Relationship <sup>*</sup></label>
                                <input wire:model='contactinputs.{{$i}}.relationship' type="text" class="form-control" placeholder="Enter Relationship" />
                                @error("contactinputs.{$i}.relationship")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="phone">Phone No. <sup>*</sup></label>
                                <input wire:model='contactinputs.{{$i}}.phone' type="number" class="form-control" placeholder="Enter Phone No." />
                                @error("contactinputs.{$i}.phone")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Phone No.2</label>
                                <input type="number" wire:model='contactinputs.{{$i}}.phone_two' class="form-control" placeholder="Enter Phone No." />
                                @error("contactinputs.{$i}.phone_two")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="email">Email </label>
                                <input wire:model='contactinputs.{{$i}}.email' type="text" class="form-control" placeholder="Enter email" />
                                @error("contactinputs.{$i}.email")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>  
                    </div>

                    @endfor

                    <a class="addBtn mt-3" wire:click="addNewContactInfo" href="javascript:void(0);">Add New <img src="{{ asset('/images/addIcon.svg')}}" /></a>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group mt-4 addoffmodalfoot">
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                <button class="btn commonButton ml-1 modalsubmiteffect" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>

                   
                </form>
            </div>
        </div>
    </div>
</div>
<!-- contact information modal ends -->


<!-- joining detail modal starts -->
<div wire:ignore.self class="modal fade personalInfo" id="joiningDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Joining Details</h1>
                <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <h3 class="text-center">Joining Details</h3> -->
                <form wire:submit.prevent="submitJoiningDetail" enctype="multipart/form-data" class="px-3">

                <form action="" class="px-3 joinForm">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="date">Confirmation Date</label>
                                <input wire:model="confirmation_date" type="date" class="form-control" placeholder="Enter Confirmation Date" />
                                  @error("confirmation_date")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="noticePeriod">Notice Period</label>
                                <input wire:model="notice_period" type="text" class="form-control" placeholder="Enter Notice Period" />
                                @error("notice_period")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="probationPeriod">Probation Period</label>
                                <input wire:model="probation_period" type="text" class="form-control" placeholder="Enter Probation Period" />
                                @error("probation_period")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Other Terms</label>
                                <textarea class="form-control" placeholder="Enter Terms" wire:model="other_terms"></textarea>
                              @error("other_terms")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError 
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mt-4 addoffmodalfoot">
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                <button class="btn commonButton ml-1" type="submit">Submit</button>
                            </div>
                        </div>

                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- joining detail modal ends -->

    <!-- official contact modal starts -->
<div wire:ignore.self class="modal fade personalInfo" id="officialContact" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Official Contact Information</h1>
                <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <h3 class="text-center">Official Contact Information</h3> -->
                <form wire:submit.prevent="submitOfficialContact" enctype="multipart/form-data" class="px-3">


                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="redmine">Redmine Username</label>
                                <input wire:model="redmine_username" type="text" class="form-control" placeholder="Enter Redmine Username" />
                                @error("redmine_username")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="discord">Discord Username</label>
                                <input wire:model="discord_username" type="text" class="form-control" placeholder="Enter Discord Username" />
                                @error("discord_username")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="skype">Skype ID</label>
                                <input wire:model="skype_id" type="text" class="form-control" placeholder="Enter Skype ID" />
                              @error("skype_id")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mt-4 addoffmodalfoot">
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                <button class="btn commonButton ml-1" type="submit">Submit</button>
                            </div>
                        </div>

                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- official contact modal ends -->

    <!-- family info modal starts -->
    <div wire:ignore.self class="modal fade personalInfo" id="familyInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Family Information</h3>
                    <form wire:submit.prevent="submitFamilyInfo" class="px-3">
                        @for($i=0; $i< count($familyinputs) ; $i++)

                        <h3 class="mt-4 mb-2 fs-5 d-flex justify-content-between align-items-center">Family Member {{$i+1}}
                          @if(count($familyinputs) >1)
                            <a wire:click='removeFamilyInfo({{$i}})' href="javascript:void(0);"><span><img src="{{ asset('/images/binIcon.svg')}}" /></span></a>
                          @endif</h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mt-0">
                                    <label for="name">Name <span class="text-red">*</span></label>
                                    <input wire:model='familyinputs.{{$i}}.name' type="text" class="form-control" placeholder="Enter Name" />
                                    @error("familyinputs.{$i}.name")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mt-0">
                                    <label for="relation">Relationship <span class="text-red">*</span></label>
                                    <input wire:model='familyinputs.{{$i}}.relationship' type="text" class="form-control" placeholder="Enter Relationship" />
                                    @error("familyinputs.{$i}.relationship")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" placeholder="Enter Date of Birth" wire:model='familyinputs.{{$i}}.date_of_birth' />
                                    @error("familyinputs.{$i}.date_of_birth")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                  <!--   <span class="form-control-icon">
                                        <img src="/images/calenderIcon.svg">
                                    </span> -->
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">Phone <span class="text-red">*</span></label>
                                    <input wire:model='familyinputs.{{$i}}.phone' type="number" class="form-control" placeholder="Enter Phone" />
                                    @error("familyinputs.{$i}.phone")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input wire:model='familyinputs.{{$i}}.address' type="text" class="form-control" placeholder="Enter Address" />
                                </div>

                            </div>
                        </div>
                        @endfor
                        <a class="addBtn mt-3" wire:click="addNewFamilyInfo" href="javascript:void(0);">Add New <img src="{{ asset('/images/addIcon.svg')}}"></a>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mt-4">
                                    <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div wire:ignore.self class="modal fade personalInfo" id="editFamilyInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Family Information</h1>
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <h3 class="text-center">Family Information</h3> -->
                    <form wire:submit.prevent="updateFamilyInfo" class="px-3">
                        <h3 class="mt-4 mb-2 fs-5 d-flex justify-content-between align-items-center">Family Member
                           </h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mt-0">
                                    <label for="name">Name <span class="text-red">*</span></label>
                                    <input wire:model='name' type="text" class="form-control" placeholder="Enter Name" />
                                     @error("name")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mt-0">
                                    <label for="relation">Relationship <span class="text-red">*</span></label>
                                    <input wire:model='relationship' type="text" class="form-control" placeholder="Enter Relationship" />
                                     @error("relationship")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" placeholder="Enter Date of Birth" wire:model='date_of_birth' />
                                    @error("date_of_birth")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                  <!--   <span class="form-control-icon">
                                        <img src="/images/calenderIcon.svg">
                                    </span> -->
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">Phone <span class="text-red">*</span></label>
                                    <input wire:model='phone' type="number" class="form-control" placeholder="Enter Phone" />
                                    @error("phone")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input wire:model='address' type="text" class="form-control" placeholder="Enter Address" />
                                     @error("address")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>

                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mt-4 addoffmodalfoot">
                                <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                    <button class="btn commonButton ml-1" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- family info modal ends -->

    <!-- education modal modal starts -->
    <div wire:ignore.self class="modal fade personalInfo" id="eduInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Education Information</h3>
                    <form wire:submit.prevent="submitEducationInfo" class="px-3">
                    @php $k= 1; @endphp
                        
                        <div class="shadow p-3 rounded">

                            @for($i=0; $i< count($inputs) ; $i++)
                            <h3 class="mb-2 fs-5 d-flex justify-content-between align-items-center">Education Information {{$i+1}}
                             <a wire:click='remove({{$i}})' href="javascript:void(0);">
                                <span><img src="{{ asset('/images/binIcon.svg')}}" /></span></a></h3>
                           
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group mt-0">
                                        <label for="institute">Institute <span class="text-red">*</span></label>
                                        <input wire:model='inputs.{{$i}}.institute' type="text" class="form-control" placeholder="Enter Institute Name" />
                                        @error("inputs.{$i}.institute")
                                          <span class="error text-danger">{{$message}}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mt-0">
                                        <label for="startDate">Starting Date</label>
                                        <input wire:model='inputs.{{$i}}.starting_date' type="date" class="form-control" placeholder="Enter Starting Date" />
                                         @error("inputs.{$i}.starting_date")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                     <!--    <span class="form-control-icon">
                                            <img src="/images/calenderIcon.svg">
                                        </span> -->
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="completeDate">Complete Date</label>
                                        <input wire:model='inputs.{{$i}}.completed_date' type="date" class="form-control" placeholder="Enter Complete Date" />
                                         @error("inputs.{$i}.completed_date")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                        <!-- <span class="form-control-icon">
                                            <img src="/images/calenderIcon.svg">
                                        </span> -->
                                    </div>
                                </div>
                                

                                <div class="col-lg-6">
                                    <div class="form-group" wire:ignore.self>
                                        <label for="degree-{{$i}}">Select Degree</label>
                                        <select wire:model='inputs.{{$i}}.degree' id="degree-{{$i}}" type="text" class="form-control select-degree">
                                            <option value=""></option>
                                            <option value="Bsc Computer Science">Bsc Computer Science</option>
                                            <option value="graduation">Graduation</option>
                                        </select>
                                        @error("inputs.{$i}.degree")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Grade</label>
                                        <input type="text" wire:model='inputs.{{$i}}.grade' class="form-control" placeholder="Enter Grade" />
                                    </div>
                                    @error("inputs.{$i}.grade")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>       
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Document</label>
                                        <div class="fileUploader">
                                            <img src="{{ asset('/images/uploadIcon.svg')}}" />
                                            <span>Drag and Drop File</span>
                                            <input type="file" wire:model='inputs.{{$i}}.document' title="Upload Document" />
                                            @error("inputs.{$i}.document")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                        </div>
                                     
                                        @if(!empty($inputs[$i]['document']) && !is_string($inputs[$i]['document']))
                                        @if($inputs[$i]['document']->extension() == 'png' || $inputs[$i]['document']->extension() == 'jpg' || $inputs[$i]['document']->extension() == 'jpeg'|| $inputs[$i]['document']->extension() == 'svg')
                                       
                                            <p class="uploadFilename"><img width="100" height="100" src="{{$inputs[$i]['document']->temporaryUrl() }}" />{{$inputs[$i]['document']->getClientOriginalName()}} </p>
                                        @elseif($inputs[$i]['document']->extension() == 'pdf')
                                            <p class="uploadFilename"><img src="{{ asset('/images/pdfIcon.svg')}}"> {{$inputs[$i]['document']->getClientOriginalName()}}</p>
                                        @else
                                            <p class="uploadFilename"><img height="100" width="100" src="{{ asset('/images/docIcon.svg')}}"> {{$inputs[$i]['document']->getClientOriginalName()}}</p>


                                        @endif
                                        @else
                                            @if(!empty($inputs[$i]['document']))
                                                @php $extArr = explode('.',$inputs[$i]['document']); 
                                                $nameArr = explode('/',$inputs[$i]['document']);
                                                $extension = $extArr[count($extArr) - 1]; 
                                                $name = $nameArr[count($nameArr) - 1]; @endphp
                                              
                                                @if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg'|| $extension == 'svg')
                                       
                                                    <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img height="100" width="100" src="{{$inputs[$i]['document'] }}" /> </p></a>
                                                @elseif($extension == 'pdf')
                                                     <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img src="{{ asset('/images/pdfIcon.svg')}}"> </p></a>
                                                @else
                                                <!-- <p class="uploadFilename"><img height="100" width="100" src="{{$inputs[$i]['document'] }}" /> </p> -->
                                                    <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img height="100" width="100" src="{{ asset('/images/docIcon.svg')}}"> </p></a>
                                                @endif

                                        @endif
                                        @endif
                                    </div>
                                </div> 

                            </div>
                            @endfor
                        </div>

                        <!-- <div class="shadow p-3 rounded mt-3">
                            <h3 class="mb-2 fs-5 d-flex justify-content-between align-items-center">Education Information <a href="javascript:void(0);"><span><img src="/images/binIcon.svg" /></span></a></h3>
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group mt-0">
                                        <label>Institute</label>
                                        <input type="text" class="form-control" placeholder="Enter Institute Name" />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mt-0">
                                        <label>Starting Date</label>
                                        <input type="text" class="form-control datePicker" placeholder="Enter Starting Date" />
                                        <span class="form-control-icon">
                                            <img src="/images/calenderIcon.svg">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Complete Date</label>
                                        <input type="text" class="form-control datePicker" placeholder="Enter Complete Date" />
                                        <span class="form-control-icon">
                                            <img src="/images/calenderIcon.svg">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Select Degree</label>
                                        <select type="text" class="form-control">
                                            <option></option>
                                            <option>Bsc Computer Science</option>
                                            <option>Graduation</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Grade</label>
                                        <input type="text" class="form-control" placeholder="Enter Grade" />
                                    </div>
                                </div>   
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Document</label>
                                        <div class="fileUploader">
                                            <img src="/images/uploadIcon.svg" />
                                            <span>Drag and Drop File</span>
                                            <input type="file" title="Upload Document" />
                                        </div>
                                        <p class="uploadFilename"><img src="/images/pdfIcon.svg" /> Institute Degree.pdf</p>
                                    </div>
                                </div> 

                            </div>
                        </div> -->

                        <a class="addBtn mt-3" wire:click="addNew" href="javascript:void(0);">Add New <img src="{{ asset('/images/addIcon.svg')}}"></a>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mt-4">
                                    <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    
    <div wire:ignore.self class="modal fade personalInfo" id="addEduInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Education Information</h1>
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <h3 class="text-center">Education Information</h3> -->
                    <form wire:submit.prevent="createEducationInfo" class="px-3">
                        
                        <div class="p-3 rounded">

                            @for($i=0; $i< 1 ; $i++)
                            <h3 class="mb-2 fs-5 d-flex justify-content-between align-items-center">Education Information
                             <!-- <a wire:click='remove({{$i}})' href="javascript:void(0);"> -->
                                <!-- <span><img src="/images/binIcon.svg" /></span></a></h3> -->
                            </h3>
                           
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group mt-0">
                                        <label for="institute">Institute <span class="text-red">*</span></label>
                                        <input wire:model='institute' type="text" class="form-control" placeholder="Enter Institute Name" />
                                         @error("institute")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mt-0">
                                        <label for="startDate">Starting Date</label>
                                        <input wire:model='starting_date' type="date" class="form-control" placeholder="Enter Starting Date" />
                                         @error("starting_date")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                     <!--    <span class="form-control-icon">
                                            <img src="/images/calenderIcon.svg">
                                        </span> -->
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="completeDate">Complete Date</label>
                                        <input wire:model='completed_date' type="date" class="form-control" placeholder="Enter Complete Date" />
                                         @error("completed_date")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                        <!-- <span class="form-control-icon">
                                            <img src="/images/calenderIcon.svg">
                                        </span> -->
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="degree">Select Degree</label>
                                        <select wire:model='degree'  type="text" class="form-control degree">
                                            <option value=""></option>
                                            <option value="Bsc Computer Science">Bsc Computer Science</option>
                                            <option value="graduation">Graduation</option>
                                        </select>
                                         @error("degree")
                                          <span class="error text-danger">{{$message}}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Grade</label>
                                        <input type="text" wire:model='grade' class="form-control" placeholder="Enter Grade" />
                                         @error("grade")
                                          <span class="error text-danger">{{$message}}</span>
                                        @endError
                                    </div>
                                </div>       
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Document<span class="text-red">*</span></label>
                                        <div class="fileUploader">
                                            <img src="{{ asset('/images/uploadIcon.svg')}}" />
                                            <span>Drag and Drop File</span>
                                            <input type="file" wire:model='document' title="Upload Document" />
                                            @error("document")
                                              <span class="error text-danger">{{$message}}</span>
                                            @endError
                                        </div>
                                     
                                        @if(!empty($document) && !is_string($document))
                                        @if($document->extension() == 'png' || $document->extension() == 'jpg' || $document->extension() == 'jpeg'|| $document->extension() == 'svg')
                                       
                                            <p data-ext="{{$document->extension()}}" class="uploadFilename"><img src="{{$document->temporaryUrl() }}" />{{$document->getClientOriginalName()}} </p>
                                        @elseif($document->extension() == 'pdf')
                                            <p data-ext="{{$document->extension()}}" class="uploadFilename"><img src="{{ asset('/images/pdfIcon.svg')}}"> {{$document->getClientOriginalName()}}</p>
                                        @else

                                            <p data-ext="{{$document->temporaryUrl()}}" class="uploadFilename"><img height="100" width="100" src="{{ asset('/images/docIcon.svg')}}"> {{$document->getClientOriginalName()}}</p>


                                        @endif
                                        @else
                                            @if(!empty($document))
                                                @php 
                                                $extArr = explode('.',$document); 
                                                $extension = $extArr[count($extArr) - 1];  
                                                $nameArr = explode('/',$document);
                                                $name = $nameArr[count($nameArr) - 1]; @endphp
                                              

                                                @if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg'|| $extension == 'svg')
                                       
                                                   <a href="{{url('/download')}}/{{$name}}"> <p class="uploadFilename"><img height="100" width="100" src="{{ $document }}" />{{$name}} </p></a>
                                                @elseif($extension == 'pdf')
                                                    <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img src="{{ asset('/images/pdfIcon.svg')}}"> </p></a>
                                                @else
                                                    <a href="{{url('/download')}}/{{$name}}"><p data-ext="{{$extension}}"class="uploadFilename"><img height="100" width="100" src="{{ asset('/images/docIcon.svg')}}"> test</p></a>
                                                @endif

                                        @endif
                                        @endif
                                    </div>
                                </div> 

                            </div>
                            @endfor
                        </div>

                        

                        <!-- <a class="addBtn mt-3" wire:click="addNew" href="javascript:void(0);">Add New <img src="/images/addIcon.svg"></a> -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mt-4 addoffmodalfoot">
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
    <!-- education modal ends -->

    <!-- bank info modal starts -->
    <div class="modal fade personalInfo" wire:ignore.self id="bankInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Bank Information</h1>
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <h3 class="text-center">Bank Information</h3> -->
                    <form wire:submit.prevent="submitBankInfo" class="px-3">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Name as per Bank Records <span class="text-red">*</span></label>
                                    <input wire:model="username" type="text" class="form-control" placeholder="Enter Name" />
                                    @error("username")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="bankName">Bank Name <span class="text-red">*</span></label>
                                    <input wire:model="bank_name" type="text" class="form-control" placeholder="Enter Bank Name" />
                                    @error("bank_name")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="account">Bank Account No. <span class="text-red">*</span></label>
                                    <input wire:model="account" type="number" class="form-control" placeholder="Enter Account No." />
                                    @error("account")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="ifsc">IFSC Code <span class="text-red">*</span></label>
                                    <input wire:model="ifsc" type="text" class="form-control" placeholder="Enter IFSC Code" />
                                    @error("ifsc")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="pan">PAN No. <span class="text-red">*</span></label>
                                    <input wire:model="pan" type="text" class="form-control" placeholder="Enter PAN No." />
                                    @error("pan")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mt-4 addoffmodalfoot">
                                <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                    <button class="btn commonButton ml-1 modalsubmiteffect" type="submit">Submit</button>
                                </div>
                            </div>

                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- bank info modal ends -->

    <!-- statutory modal starts -->
    <div  class="modal fade personalInfo" wire:ignore.self id="statutoryInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Bank & statutory information</h1>

                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <h3 class="text-center">Bank & Statutory Information</h3> -->
                    <form wire:submit.prevent="submitStatutoryInfo" class="px-3">
                        <h3 class="fs-5 mb-0">ESI Account</h3>

                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" wire:model="esi" value="1" id="EmployeeCheck" {{ @$userData['statutoryInfo']['esi'] == '1'?'checked':''}}>
                          
                            <label class="form-check-label" for="EmployeeCheck">
                                Employee is covered under ESI
                            </label>
                        </div>
                        @if(@$this->esi == '1')

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>ESI Number</label>
                                    <input type="number" wire:model="esi_number" value="{{ @$userData['statutoryInfo']['esi_number'] }}" class="form-control" placeholder="Enter ESI Number" />
                                    @error("esi_number")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Branch Office</label>
                                    <input type="text" wire:model="branch_office" value="{{ @$userData['statutoryInfo']['branch_office'] }}" class="form-control" placeholder="Enter Branch Office" />
                                    @error("branch_office")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Dispensary</label>
                                    <input type="text" wire:model="dispensary" value="{{ @$userData['statutoryInfo']['dispensary'] }}" class="form-control" placeholder="Enter dispensary" />
                                    @error("dispensary")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError

                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" wire:model="previous_employment" id="flexCheckDefault1" {{ @$userData['statutoryInfo']['previous_employment'] == '1'?'checked':''}}>
                                    <label class="form-check-label" for="flexCheckDefault1">
                                        In case of any previous employment please fill up the details as under.
                                    </label>
                                  </div>
                            </div>
                            @if($this->previous_employment == '1')
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Previous Ins. No.</label>
                                    <input type="text" wire:model="previousInsNo" value="{{ @$userData['statutoryInfo']['previousInsNo'] }}" class="form-control" placeholder="Previous Ins. No." />
                                    @error("previousInsNo")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError

                                </div>
                            </div>  
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Employer's Code No.</label>
                                    <input type="text" wire:model="employerCode" value="{{ @$userData['statutoryInfo']['dispensary'] }}" class="form-control" placeholder="Employer's Code No." />
                                    @error("employerCode")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name & Address of the Employer</label>
                                    <input type="text" wire:model="nameAddress"  class="form-control" placeholder="Name & Address of the Employer" />
                                    @error("nameAddress")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" wire:model="employerEmail" class="form-control" placeholder="Enter Email" />
                                    @error("employerEmail")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError

                                </div>
                            </div>
                            @endif

                            

                            <div class="col-lg-12">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" wire:model="nominee_detail"  id="flexCheckDefault2" {{ @$userData['statutoryInfo']['nominee_detail'] == '1'?'checked':''}}>
                                    <label class="form-check-label" for="flexCheckDefault2">
                                        Details of Nominee u/s 71 of ESI Act 1948/Rule-56(2) of ESI (Central) Rules, 1950 for payment of cash benefit in the event of death
                                    </label>
                                  </div>
                            </div>
                            @if($this->nominee_detail == '1')


                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" wire:model="nomineeName" value="{{ @$userData['statutoryInfo']['email'] }}" class="form-control" placeholder="Enter Name" />
                                    @error("nomineeName")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError

                                </div>
                            </div>  
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Relationship</label>
                                    <input type="text" wire:model="nomineeRelationship" value="{{ @$userData['statutoryInfo']['nomineeRelationship'] }}" class="form-control" placeholder="Enter Relationship" />
                                    @error("nomineeRelationship")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError

                                </div>
                            </div>  
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" wire:model="nomineeAddress" value="{{ @$userData['statutoryInfo']['email'] }}" class="form-control" placeholder="Enter Address" />
                                    @error("nomineeAddress")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError

                                </div>
                            </div>
                            @endif

                            <div class="col-lg-12">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" wire:model="family_particular" id="flexCheckDefault3" {{ @$userData['statutoryInfo']['family_particular'] == '1'?'checked':''}}>
                                    <label class="form-check-label" for="flexCheckDefault3">Family Particulars of Insured person</label>
                                    <div class="row">
                                    @if($this->family_particular == '1')

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" wire:model="particularName" value="{{ @$userData['statutoryInfo']['email'] }}" class="form-control" placeholder="Enter Address" />
                                                @error("particularName")
                                                <span class="error text-danger">{{$message}}</span>
                                                @endError
                                            </div>
                                        </div>  
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input type="date" wire:model="particularDateofbirth" value="{{ @$userData['statutoryInfo']['particularDateofbirth'] }}" class="form-control" placeholder="Enter Address" />
                                                @error("particularDateofbirth")
                                                <span class="error text-danger">{{$message}}</span>
                                                @endError
                                            </div>
                                        </div>  
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Relationship</label>
                                                <input type="text" wire:model="particularRelationship" value="{{ @$userData['statutoryInfo']['particularRelationship'] }}" class="form-control" placeholder="Enter Address" />
                                                @error("particularRelationship")
                                                <span class="error text-danger">{{$message}}</span>
                                                @endError
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <p class="">Whether residing with him/her</p>
                                    <div class="d-flex">
                                        <div class="form-check me-2">
                                            <input class="form-check-input" type="radio" value="1" name="residing" wire:model="residing"  >
                                                <label class="form-check-label" for="flexRadioDefault10">Yes</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="0" name="residing" wire:model="residing" >
                                            <label class="form-check-label" for="flexRadioDefault1">No</label>
                                        </div>
                                    </div>
                                    @if($this->residing == '1')

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label>Place of Residance</label>
                                        <select wire:model="residancePlace" class="form-control">
                                        <!-- <option value=""></option> -->
                                        <option value="town">Town</option>
                                        <option value="state" selected>State</option>
                                        </select>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                             
                            
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" wire:model="pf" id="flexCheckDefault" >
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Employee is covered under PF
                                    </label>
                                </div>
                            </div>
                            @if(@$this->pf == '1')


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>UAN</label>
                                    <input type="number" wire:model="uan" value="{{ @$userData['statutoryInfo']['uan']}}" class="form-control" placeholder="Enter UAN" />
                                    @error("uan")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>PF Number</label>
                                    <input type="text" wire:model="pf_number" value="{{ @$userData['statutoryInfo']['pf_number']}}"class="form-control" placeholder="Enter PF Number" />
                                    @error("pf_number")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>PF Join Date</label>
                                    <input type="date" wire:model="pf_joinDate" class="form-control" placeholder="Enter Join Date" />
                                    @error("pf_joinDate")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                    <!-- <span class="form-control-icon">
                                        <img src="/images/calenderIcon.svg">
                                    </span> -->
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Whether earlier a member of Employees provident Fund Scheme 1952? {{$this->pf_scheme}}</label>
                                    <div class="d-flex">
                                        <div class="form-check me-2">
                                            <input class="form-check-input" name="pf_scheme" value="1" type="radio" wire:model="pf_scheme" id="flexRadioDefault2" >
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Yes
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" name="pf_scheme"  value="0" type="radio" wire:model="pf_scheme"  id="flexRadioDefault3"  >
                                            <label class="form-check-label" for="flexRadioDefault3">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Whether earlier a member of Employees ‘Pension Scheme ,1995?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-2">
                                          
                                            <input class="form-check-input" name="pension_scheme" value="1" type="radio" wire:model="pension_scheme"  id="flexRadioDefault4">
                                            <label class="form-check-label" for="flexRadioDefault4">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="pension_scheme" value="0" type="radio" wire:model="pension_scheme"  id="flexRadioDefault5" >
                                            <label class="form-check-label" for="flexRadioDefault5">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif

                            <div class="col-lg-12">
                                <div class="form-group mt-4 addoffmodalfoot" >
                                <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                    <button class="btn commonButton ml-1" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- statutory Information modal ends -->

    <!-- additional info modal starts -->
    <div wire:ignore.self class="modal fade personalInfo" id="additionalInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Additional Information</h1>
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <h3 class="text-center">Additional Information</h3> -->
                    <form wire:submit.prevent="submitAdditionalInfo" class="px-3">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Allergies</label>
                                    <select wire:model="allergies" id="allergies" class="form-control">
                                         <option value=""></option> 
                                        <option value="yes">Yes</option>
                                        <option value="no" selected>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Smoke</label>
                                    <select wire:model="smoke" id="smoke_field" class="form-control">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no" selected>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Drink</label>
                                    <select wire:model="drink"  id="drink" class="form-control">
                                         <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no" selected>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Diet</label>
                                    <select wire:model="diet"  id="diet" class="form-control">
                                         <option value=""></option>
                                        <option value="veg">Veg</option>
                                        <option value="non-veg" selected>Non-Veg</option>
                                    </select>
                                </div>
                            </div>
                            

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Hobbies</label>
                                    <input type="text" wire:model="hobbies" id="hobbies" class="form-control" placeholder="Enter Hobbies" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mt-4 addoffmodalfoot">
                                <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                    <button class="btn commonButton ml-1" type="submit">Submit</button>
                                </div>
                            </div>

                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- additional info modal ends -->
     <!-- experience info modal starts -->
    <div wire:ignore.self class="modal fade personalInfo" id="experienceInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Experience Information</h1> -->
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Experience Information</h3>
                    <form wire:submit.prevent="submitExperienceInfo" class="px-3">
                        @for($i=0; $i< count($experienceinputs) ; $i++)
                            <h3 class="mb-2 fs-5 d-flex justify-content-between align-items-center">Experience Information {{$i+1}}
                                @if(count($experienceinputs) > 1)
                             <a wire:click='removeExperienceInfo({{$i}})' href="javascript:void(0);">
                                <span><img src="{{ asset('/images/binIcon.svg')}}" /></span></a>
                                @endif
                            </h3>
                           
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Company Name <span class="text-red">*</span></label>
                                    <input wire:model='experienceinputs.{{$i}}.company_name' type="text" class="form-control" placeholder="Company Name" />
                                    @error("experienceinputs.{$i}.company_name")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Designation <span class="text-red">*</span></label>
                                    <input type="text" wire:model='experienceinputs.{{$i}}.designation' class="form-control" placeholder="Designation" />
                                     @error("experienceinputs.{$i}.designation")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group" wire:ignore.selef>
                                    <label for="dapartment">Select Employee Type <span class="text-red">*</span></label>
                                    <select wire:model='experienceinputs.{{$i}}.employee_type'  class="form-control experienceinputs">
                                        <option selected value="">Select Employee Type</option>
                                        <option value="permanent">Permanent</option>
                                        <option value="freelancer">Freelancer</option>
                                        <option value="contract">Contract</option>
                                    </select>
                                      @error("experienceinputs.{$i}.employee_type")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>

                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Period From <span class="text-red">*</span></label>
                                    <input type="date" wire:model='experienceinputs.{{$i}}.period_from' class="form-control" placeholder="Period From" />
                                     @error("experienceinputs.{$i}.period_from")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Period To</label>
                                    <input type="date" wire:model='experienceinputs.{{$i}}.period_to' class="form-control" placeholder="Period To" />
                                  @error("experienceinputs.{$i}.period_to")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Relevant Experience <span class="text-red">*</span></label>
                                    <input type="text" wire:model='experienceinputs.{{$i}}.relevant_experience' class="form-control" placeholder="Relevant Experience" />
                                     @error("experienceinputs.{$i}.relevant_experience")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Skills</label>
                                    <input type="text" wire:model='experienceinputs.{{$i}}.skills' class="form-control" placeholder="Skills" />
                                    @error("experienceinputs.{$i}.skills")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>

                            

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Employee ID <span class="text-red">*</span></label>
                                    <input wire:model='experienceinputs.{{$i}}.employee_id'  type="text" class="form-control" placeholder="Employee ID" />
                                     @error("experienceinputs.{$i}.employee_id")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Net Pay</label>
                                    <input wire:model='experienceinputs.{{$i}}.net_pay' type="text" class="form-control" placeholder="Net Pay" />
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company City</label>
                                    <input wire:model='experienceinputs.{{$i}}.company_city' type="text" class="form-control" placeholder="Company City" />
                                    @error("experienceinputs.{$i}.company_city")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company State</label>
                                    <input wire:model='experienceinputs.{{$i}}.company_state' type="text" class="form-control" placeholder="Company State" />
                                        @error("experienceinputs.{$i}.company_state")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Country</label>
                                    <select wire:model="experienceinputs.{{$i}}.company_country" id="company-countries-{{$i}}" class="form-control country company-country">
                                      <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->_id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error("experienceinputs.{$i}.company_country")
                                            <span class="error text-danger">{{$message}}</span>
                                    @endError
                                  
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Pin Code</label>
                                    <input wire:model='experienceinputs.{{$i}}.company_pincode' type="text" class="form-control" placeholder="Company Pin Code" />
                                    @error("experienceinputs.{$i}.company_pincode")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Website</label>
                                    <input wire:model='experienceinputs.{{$i}}.company_website' type="text" class="form-control" placeholder="Company Website" />
                                     @error("experienceinputs.{$i}.company_website")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Name of Reporting Manager</label>
                                    <input wire:model='experienceinputs.{{$i}}.manager_name' type="text" class="form-control" placeholder="Name of Reporting Manager" />
                                      @error("experienceinputs.{$i}.manager_name")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Designation of Reporting Manager</label>
                                    <input wire:model='experienceinputs.{{$i}}.manager_designation' type="text" class="form-control" placeholder="Designation of Reporting Manager" />
                                      @error("experienceinputs.{$i}.manager_designation")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Contact Number of Reporting Manager</label>
                                    <input wire:model='experienceinputs.{{$i}}.manager_contact' type="text" class="form-control" placeholder="Contact Number of Reporting Manager" />
                                     @error("experienceinputs.{$i}.manager_contact")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email of Reporting Manager</label>
                                    <input wire:model='experienceinputs.{{$i}}.manager_email' type="email" class="form-control" placeholder="Email of Reporting Manager" />
                                    @error("experienceinputs.{$i}.manager_email")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="dapartment">Verification Status</label>
                                    <select wire:model='experienceinputs.{{$i}}.verification_status'  class="form-control">
                                        <option value="initiated">Initiated</option>
                                        <option value="pending">Pending</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="verified">Verified</option>
                                    </select>
                                     @error("experienceinputs.{$i}.verification_status")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>
                             <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="d-block">Leaving Reason</label>
                                    <textarea class="form-control" placeholder="Leaving Reason" wire:model='experienceinputs.{{$i}}.leaving_reason'></textarea>
                                     @error("experienceinputs.{$i}.leaving_reason")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Document</label>
                                    <div class="fileUploader">
                                        <img src="{{ asset('/images/uploadIcon.svg')}}">
                                        <span>Drag and Drop File</span>
                                        <input type="file" wire:model='experienceinputs.{{$i}}.documents' title="Upload Documents">
                                        @error("experienceinputs.{$i}.documents")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                    </div>
                                     @if(!empty($experienceinputs[$i]['documents']) && !is_string($experienceinputs[$i]['documents']))
                                        @if($experienceinputs[$i]['documents']->extension() == 'png' || $experienceinputs[$i]['documents']->extension() == 'jpg' || $experienceinputs[$i]['documents']->extension() == 'jpeg'|| $experienceinputs[$i]['documents']->extension() == 'svg')
                                       
                                        <p class="uploadFilename"><img height="100" width="100" src="{{$experienceinputs[$i]['documents']->temporaryUrl()}}" />{{$experienceinputs[$i]['documents']->getClientOriginalName()}} </p>
                                        @elseif($experienceinputs[$i]['documents']->extension() == 'pdf')
                                        <p class="uploadFilename"><img src="{{ asset('/images/pdfIcon.svg')}}"> {{$experienceinputs[$i]['documents']->getClientOriginalName()}}</p>
                                        @else
                                            <p class="uploadFilename"><img height="100" width="100" src="{{ asset('/images/docIcon.svg')}}"> {{$experienceinputs[$i]['documents']->getClientOriginalName()}}</p>


                                        @endif
                                      
                                        @else
                                            @if(!empty($experienceinputs[$i]['documents']))
                                                @php $extArr = explode('.',$experienceinputs[$i]['documents']); $extension = $extArr[count($extArr) - 1];

                                                $nameArr = explode('/',$experienceinputs[$i]['documents']);
                                                
                                                $name = $nameArr[count($nameArr) - 1];  @endphp
                                                @if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg'|| $extension == 'svg')
                                       
                                                    <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img height="100" width="100" src="{{ $experienceinputs[$i]['documents'] }}" />{{$experienceinputs[$i]['documents']}} </p></a>
                                                @elseif($extension == 'pdf')
                                                    <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img src="{{ asset('/images/pdfIcon.svg')}}"> {{$experienceinputs[$i]['documents']}}</p></a>
                                                @else
                                                    <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img height="100" width="100" src="{{ asset('/images/docIcon.svg')}}"> {{$experienceinputs[$i]['documents']}}</p></a>
                                                @endif

                                        @endif
                                        @endif
                                    <!-- <p class="uploadFilename"><img src="/images/pdfIcon.svg"> Institute Degree.pdf</p> -->
                                </div>
                            </div>
                        </div>
                        @endfor
                        <a class="addBtn mt-3" wire:click="addNewExperienceInfo" href="javascript:void(0);">Add New <img src="{{ asset('/images/addIcon.svg')}}" /></a>
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group mt-4">
                                

                                    <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>   
    
    <div wire:ignore.self class="modal fade personalInfo" id="addExperienceInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Experience Information</h1>
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <h3 class="text-center">Experience Information</h3> -->
                    <form wire:submit.prevent="createExperienceInfo" class="px-3">
                        @for($i=0; $i< 1 ; $i++)
                            <!-- <h3 class="mb-2 fs-5 d-flex justify-content-between align-items-center">Experience Information

                             </h3> -->
                           
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Company Name <span class="text-red">*</span></label>
                                    <input wire:model='company_name' type="text" class="form-control" placeholder="Company Name" />
                                    @error("company_name")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Designation <span class="text-red">*</span></label>
                                    <input type="text" wire:model='designation' class="form-control" placeholder="Designation" />
                                    @error("designation")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="dapartment">Select Employee Type <span class="text-red">*</span></label>
                                    <select wire:model='employee_type'  class="form-control">
                                        <option selected value="">Select Employee Type</option>
                                        <option value="permanent">Permanent</option>
                                        <option value="freelancer">Freelancer</option>
                                        <option value="contract">Contract</option>
                                    </select>
                                     @error("employee_type")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Period From <span class="text-red">*</span></label>
                                    <input type="date" wire:model='period_from' class="form-control" placeholder="Period From" />
                                    <!-- <span class="form-control-icon">
                                        <img src="/images/calenderIcon.svg" />
                                    </span> -->
                                    @error("period_from")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Period To</label>
                                    <input type="date" wire:model='period_to' class="form-control" placeholder="Period To" />
                                  @error("period_to")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Relevant Experience <span class="text-red">*</span></label>
                                    <input type="text" wire:model='relevant_experience' class="form-control" placeholder="Relevant Experience" />
                                   @error("relevant_experience")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Skills</label>
                                    <input type="text" wire:model='skills' class="form-control" placeholder="Skills" />
                                    @error("skills")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>

                            

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Employee ID <span class="text-red">*</span></label>
                                    <input wire:model='employee_id'  type="text" class="form-control" placeholder="Employee ID" />
                                     @error("employee_id")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Net Pay</label>
                                    <input wire:model='net_pay' type="text" class="form-control" placeholder="Net Pay" />
                                    @error("net_pay")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company City</label>
                                    <input wire:model='company_city' type="text" class="form-control" placeholder="Company City" />
                                    @error("company_city")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company State</label>
                                    <input wire:model='company_state' type="text" class="form-control" placeholder="Company State" />
                                      @error("company_state")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Country</label>
                                    <select wire:model="company_country" id="company-country" class="form-control country">
                                      <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->_id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                      @error("company_country")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Pin Code</label>
                                    <input wire:model='company_pincode' type="text" class="form-control" placeholder="Company Pin Code" />
                                  @error("company_pincode")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Website</label>
                                    <input wire:model='company_website' type="text" class="form-control" placeholder="Company Website" />
                                 @error("company_website")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Name of Reporting Manager</label>
                                    <input wire:model='manager_name' type="text" class="form-control" placeholder="Name of Reporting Manager" />
                                     @error("manager_name")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Designation of Reporting Manager</label>
                                    <input wire:model='manager_designation' type="text" class="form-control" placeholder="Designation of Reporting Manager" />
                                    @error("manager_designation")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Contact Number of Reporting Manager</label>
                                    <input wire:model='manager_contact' type="text" class="form-control" placeholder="Contact Number of Reporting Manager" />
                                    @error("manager_contact")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email of Reporting Manager</label>
                                    <input wire:model='manager_email' type="email" class="form-control" placeholder="Email of Reporting Manager" />
                                      @error("manager_email")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="dapartment">Verification Status</label>
                                    <select wire:model='verification_status'  class="form-control">
                                        <option value="initiated">Initiated</option>
                                        <option value="pending">Pending</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="verified">Verified</option>
                                    </select>
                                    @error("verification_status")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>
                             <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="d-block">Leaving Reason</label>
                                    <textarea class="form-control" placeholder="Leaving Reason" wire:model='leaving_reason'></textarea>
                                    @error("leaving_reason")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Document</label>
                                    <div class="fileUploader">
                                        <img src="{{ asset('/images/uploadIcon.svg')}}">
                                        <span>Drag and Drop File</span>
                                        <input type="file" wire:model='documents' title="Upload Documents">
                                         @error("documents")
                                        <span class="error text-danger">{{$message}}</span>
                                    @endError
                                    </div>
                                     @if(!empty($documents) && !is_string($documents))
                                        @if($documents->extension() == 'png' || $documents->extension() == 'jpg' || $documents->extension() == 'jpeg'|| $documents->extension() == 'svg')
                                       
                                        <p class="uploadFilename"><img src="{{$documents->temporaryUrl()}}" />{{$documents->getClientOriginalName()}} </p>
                                        @elseif($documents->extension() == 'pdf')
                                        <p class="uploadFilename"><img src="/images/pdfIcon.svg"> {{$documents->getClientOriginalName()}}</p>
                                        @else
                                            <p class="uploadFilename"><img height="100" width="100" src="{{ asset('/images/docIcon.svg')}}"> {{$documents->getClientOriginalName()}}</p>


                                        @endif
                                      
                                        @else
                                            @if(!empty($documents))
                                                @php $extArr = explode('.',$documents);
                                                 $extension = $extArr[count($extArr) - 1]; 
                                                $nameArr = explode('/',$documents);
                                                $name = $nameArr[count($nameArr) - 1]; 
                                                @endphp
                                                @if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg'|| $extension == 'svg')
                                       
                                                    <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img height="100" width="100" src="{{ $experienceinputs[$i]['documents'] }}" />{{$experienceinputs[$i]['documents']}} </p></a>
                                                @elseif($extension == 'pdf')
                                                    <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img src="{{ asset('/images/pdfIcon.svg')}}"> {{$documents}}</p></a>
                                                @else
                                                    <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img height="100" width="100" src="{{ asset('/images/docIcon.svg')}}"> {{$documents}}</p></a>
                                                @endif

                                        @endif
                                        @endif
                                    <!-- <p class="uploadFilename"><img src="/images/pdfIcon.svg"> Institute Degree.pdf</p> -->
                                </div>
                            </div>


                            
                        </div>
                        @endfor
                        <a class="addBtn mt-3" wire:click="addNewExperienceInfo" href="javascript:void(0);">Add New <img src="{{ asset('/images/addIcon.svg')}}" /></a>
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group mt-4 addoffmodalfoot">
                                <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                    <button class="btn commonButton ml-1" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- experience info modal ends -->

    <!-- additional info modal starts -->
    <div wire:ignore.self class="modal fade personalInfo" id="payrollInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Payroll</h1>
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <h3 class="text-center">Payroll</h3> -->
                    <form wire:submit.prevent="submitPayroll" class="px-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Annual CTC</label>
                                    <input type="number" wire:model="annual_ctc" class="form-control" placeholder="Enter CTC" />
                                    @error("annual_ctc") <span class="error text-danger">{{$message}}</span>@endError
                                </div>
                            </div>
                            

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Basic Salary</label>
                                    <input type="number" wire:model="basic_salary" class="form-control" placeholder="Enter Basic Salary" />
                                    @error("basic_salary") <span class="error text-danger">{{$message}}</span>@endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Allowances</label>
                                    <input type="number" wire:model="allowances"  class="form-control" placeholder="Enter Allowances" />
                                    @error("allowances") <span class="error text-danger">{{$message}}</span>@endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Deductions</label>
                                    <input type="number" wire:model="deductions" class="form-control" placeholder="Enter Deductions" />
                                    @error("deductions") <span class="error text-danger">{{$message}}</span>@endError
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mt-4 addoffmodalfoot">
                                <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                    <button class="btn commonButton ml-1" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- additional info modal ends -->

    <!-- document modal starts -->
    <div wire:ignore.self class="modal fade personalInfo" id="documentInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Document</h1>
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <h3 class="text-center">Document</h3> -->
                    <form wire:submit.prevent="submitDocument" class="px-3" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Document Name <span class="text-red">*</span></label>
                                    <input type="text" wire:model="name" class="form-control" placeholder="Enter Document Name" />
                                     @error("name")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>
                            

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Document Type <span class="text-red">*</span></label>
                                    <select id="document_type" wire:model="type" class="form-control">
                                        <option value="">Select Document</option>
                                         @foreach($masterDocument as $document)
                                        <option value="{{$document->_id}}">{{ucfirst($document->document)}}</option>
                                        @endforeach
                                    </select>
                                     @error("type")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Document</label>
                                    <div class="fileUploader">
                                        <img src="{{ asset('/images/uploadIcon.svg')}}">
                                        <span>Drag and Drop File</span>
                                        <input type="file" wire:model="document" title="Upload Document">
                                         @error("document")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                    </div>
                                     @if(!empty($document) && !is_string($document))
                                          
                                    @else
                                        @if(!empty($document))
                                            @php $extArr = explode('.',$document); $extension = $extArr[count($extArr) - 1];
                                            $nameArr = explode('/',$document);
                                                $name = $nameArr[count($nameArr) - 1];
                                             @endphp
                                            @if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg'|| $extension == 'svg')
                                           
                                                 <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img height="100" width="100" src="{{ $experienceinputs[$i]['documents'] }}" />{{$name}} </p></a>
                                            @elseif($extension == 'pdf')
                                                 <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img src="{{ asset('/images/pdfIcon.svg')}}"> {{$name}}</p></a>
                                            @else
                                                 <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img height="100" width="100" src="{{ asset('/images/docIcon.svg')}}"> {{$name}}</p></a>
                                            @endif

                                        @endif
                                    @endif
                                    <!-- <p class="uploadFilename"><img src="/images/pdfIcon.svg"> Institute Degree.pdf</p> -->
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mt-4 addoffmodalfoot">
                                <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                    <button class="btn commonButton ml-1" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>  
    <div wire:ignore.self class="modal fade personalInfo" id="editDocumentInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Documents</h3>
                    <form wire:submit.prevent="submitDocument" class="px-3" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Document Name <span class="text-red">*</span></label>
                                    <input type="text" wire:model="name" class="form-control" placeholder="Enter Document Name" />
                                     @error("name")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>
                            

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Document Type <span class="text-red">*</span></label>
                                    <select id="document_select" wire:model="type" class="form-control">
                                        <option value="">Select Document</option>
                                        @foreach($masterDocument as $document)
                                        <option value="{{$document->_id}}">{{ucfirst($document->document)}}</option>
                                        @endforeach
                                    </select>
                                     @error("type")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Document</label>
                                    <div class="fileUploader">
                                        <img src="{{ asset('/images/uploadIcon.svg')}}">
                                        <span>Drag and Drop File</span>
                                        <input type="file" wire:model="document" title="Upload Document">
                                         @error("doc")
                                            <span class="error text-danger">{{$message}}</span>
                                        @endError
                                    </div>
                                     @if(!empty($document) && !is_string($document))
                                    @else
                                        @if(!empty($document))
                                            @php $extArr = explode('.',$document); $extension = $extArr[count($extArr) - 1]; 
                                            $nameArr = explode('/',$document);
                                                $name = $nameArr[count($nameArr) - 1];
                                            @endphp
                                            @if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg'|| $extension == 'svg')
                                           
                                                 <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img height="100" width="100" src="{{$document }}" />{{$name}} </p></a>
                                            @elseif($extension == 'pdf')
                                                 <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img src="{{ asset('/images/pdfIcon.svg')}}"> {{$name}}</p></a>
                                            @else
                                                 <a href="{{url('/download')}}/{{$name}}"><p class="uploadFilename"><img height="100" width="100" src="{{ asset('/images/docIcon.svg')}}"> {{$name}}</p></a>
                                            @endif

                                        @endif
                                    @endif
                                    <!-- <p class="uploadFilename"><img src="/images/pdfIcon.svg"> Institute Degree.pdf</p> -->
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mt-4">
                                    <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- document modal ends -->

    <!-- leaves modal starts -->
    <div class="modal fade personalInfo" id="leavesInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                    <button type="button" wire:click="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Leaves</h3>
                    <form action="" class="px-3">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Leave Type</label>
                                    <select class="form-control">
                                        <option></option>
                                        <option>Casual Leave</option>
                                        <option>Sick Leave</option>
                                        <option>Earned Leave</option>
                                        <option>Loss Of Pay</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>From</label>
                                    <input type="text" class="form-control" placeholder="From" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>To</label>
                                    <input type="text" class="form-control" placeholder="To" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="d-block">Reporting Manager</label>
                                    <select class="form-control manager">
                                        <option value='option-1' data-src="/images/userImg.png">Reporting Manager</option>
                                        <option value='option-2' data-src="http://placehold.it/45x45">Reporting Manager</option>
                                        <option value='option-3' data-src="http://placehold.it/45x45">Reporting Manager</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control">
                                        <option></option>
                                        <option>Approved</option>
                                        <option>Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="d-block">Reason</label>
                                    <textarea class="form-control" placeholder="Enter Reason"></textarea>
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
    <!-- leaves modal ends -->
</div>
@livewireScripts

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.month').select2({
            dropdownParent: $('#pills-attendance')

        }).on('change', function (e) {
            @this.set('month', $(this).val());
        });
        $('.year').select2({
            dropdownParent: $('#pills-attendance')

        }).on('change', function (e) {
            @this.set('year', $(this).val());
        }); 
        $('#employee').select2({
            dropdownParent: $('#pills-attendance')

        }).on('change', function (e) {
            @this.set('employee', $(this).val());
        }); 
        $('#attendance-department').select2({
            dropdownParent: $('#pills-attendance')
        }).on('change', function (e) {
            @this.set('department', $(this).val());
        });
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
<script>
    $(document).ready(function () {
    $("#gender").change(function(e) {
       @this.set('gender', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
    $("#spouse_employment").change(function(e) {
       @this.set('spouse_employment', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#children").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#children").select2({
           dropdownParent: $('#personalInfo2')
       });
   });
    $("#children").change(function(e) {
       @this.set('children', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
    $("#current-countries").change(function(e) {
       @this.set('selectedCurrentCountry', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
    $("#permanent-countries").change(function(e) {
       @this.set('selectedPermanentCountry', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $(".experienceinputs").select2();
   document.addEventListener('livewire:update', function (event) {
       $(".experienceinputs").select2({
           dropdownParent: $('#experienceInfo')
       });
   });
    $(".experienceinputs").change(function(e) {
       @this.set('experienceinputs.{{$i}}.employee_type', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $(".company-country").select2();
   document.addEventListener('livewire:update', function (event) {
       $(".company-country").select2({
           dropdownParent: $('#experienceInfo')
       });
   });
    $(".company-country").change(function(e) {
       @this.set('experienceinputs.{{$i}}.company_country', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#allergies").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#allergies").select2({
           dropdownParent: $('#additionalInfo')
       });
   });
    $("#allergies").change(function(e) {
       @this.set('allergies', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#drink").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#drink").select2({
           dropdownParent: $('#additionalInfo')
       });
   });
    $("#drink").change(function(e) {
       @this.set('drink', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#diet").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#diet").select2({
           dropdownParent: $('#additionalInfo')
       });
   });
    $("#diet").change(function(e) {
       @this.set('diet', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#smoke_field").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#smoke_field").select2({
           dropdownParent: $('#additionalInfo')
       });
   });
    $("#smoke_field").change(function(e) {
       @this.set('smoke', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#document_select").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#document_select").select2({
           dropdownParent: $('#editDocumentInfo')
       });
   });
    $("#document_select").change(function(e) {
       @this.set('type', $(this).val(), true)
    })
   });
</script>
<script>
    $(document).ready(function () {
   $("#document_type").select2();
   document.addEventListener('livewire:update', function (event) {
       $("#document_type").select2({
           dropdownParent: $('#documentInfo')
       });
   });
    $("#document_type").change(function(e) {
       @this.set('type', $(this).val(), true)
    })
   });
</script>


<script>
    $(document).ready(function () {
  //  $(".select-degree").select2();
  //  document.addEventListener('livewire:update', function (event) {
  //   console.log('degreupdate');
  // console.log($('.select-degree').length);
  //   $(".select-degree").select2({
  //          dropdownParent: $('#eduInfo')
  //      });
  //  });
  //   $(".select-degree").change(function(e) {
  //      @this.set('degree', $(this).val(), true)
  //   })
   });
</script> 


<script>
    
   // document.addEventListener('livewire:update', function (event) {
   //  var tab = localStorage.getItem('activeTab');
   //  if(tab){
   //  console.log('rrrr'+$('button[data-bs-target="'+tab+'"]').data('tab'));
   //  @this.tab = $('button[data-bs-target="'+tab+'"]').data('tab');
   //  }  
 
   //  });
    // document.addEventListener('livewire:load', function (event) {
    //     @this.on('submitted', (id) => { 
    //         // console.log('kk');
    //         $('#'+id).modal('hide');
    //     });  
    //     @this.on('active', () => { 
    //         console.log('active');
    //         var tab = localStorage.getItem('activeTab');
    //         if(tab){
    //             console.log('ll'+$('button[data-bs-target="'+tab+'"]').data('tab'));
    //             @this.tab = $('button[data-bs-target="'+tab+'"]').data('tab');
    //         }  
    //     });
              
    // });

  
    window.addEventListener('your-prefix:scroll-to', (ev) => {
        console.log($('.text-danger').length);
        console.log(@this.error);
        if($('.text-danger').length > 0){
            console.log('prefix');
            ev.stopPropagation();
            const selector = ev?.detail?.query;
            if (!selector) {
                return;
            }

            const el = window.document.querySelector(selector);

            if (!el) {
            return;
            }

            try {
            el.scrollIntoView({
            behavior: 'smooth',
            });
            } catch {}
            @this.error = '0';
        }
    }, false);


    
  
</script>





