<?php
use Illuminate\Support\Facades\Session;
use App\Models\Permission;
use App\Models\RolesPermission;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\UserJoiningDetail;
?>
<x-admin-layout>
<style>
.edit_multiple_document{

    width: 20px;
}
.deleteDocument{
   width: 45px;
}
 a.editIcon.editEducation {
    margin: 15px 29px;
}
</style>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-head-box">
					<h3>Profile</h3>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">Profile</li>
						</ol>
					</nav>
				</div>
			</div>
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
		<div class="dashboardSection">
			<div class="dashboardSection__body commonBoxShadow rounded-1">
				<div class="row">
					<div class="col-xl-3 col-lg-6 col-md-6">
						<div class="outerSection">
							@if(@$userData->photo != '')
							<div class="imgSection">
								<img src="{{@$userData->photo}}" />

							</div>
							@endif
							<div class="detailSection">
								<h6 class="mb-1">{{$userData->first_name}}&nbsp;
									{{$userData->last_name}}</h6>
								<small>{{! empty($userData->getdepartment()) ?
									$userData->getdepartment()->title : ''}}</small>
								<p class="mb-1">{{! empty($userData->getdesignation()) ?
									$userData->getdesignation()->title : ''}}</p>
								<p>
									Employee ID:<span>{{$userData->employee_id}}</span>
								</p>
								<!-- <a href="javascript:void(0);">Send Message</a> -->
							</div>
						</div>
					</div>

					<div class="col-xl-4 col-lg-6 col-md-6">
						<div class="commonDetail borderSection">
							<div class="row">
								<div class="col-lg-5 col-md-5">
									<p>Email:</p>
								</div>

								<div class="col-lg-7 col-md-7">
									<p class="green">
										<b>{{$userData->email}}</b>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-5 col-md-5">
									<p>Birth Date:</p>
								</div>

								<div class="col-lg-7 col-md-7">
									<p>
										<b>{{! empty ($userData->date_of_birth) ? date('d-M-Y ',strtotime($userData->date_of_birth)) : ''}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-5 col-md-5">
									<p>Joining Date:</p>
								</div>
								<div class="col-lg-7 col-md-7">
									<p>
										<b>{{! empty ($userData->joining_date) ? date('d-M-Y ',strtotime($userData->joining_date)) : ''}}</b>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-5 col-md-5">
									<p>Phone:</p>
								</div>
								<div class="col-lg-7 col-md-7">
									<p>
										<b>{{$userData->contact}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-5 col-md-5">
									<p>Reporting Manager:</p>
								</div>

								<div class="col-lg-7 col-md-7">
									<p>
										<b>{{$userData->getReportingmanager()}}</b>
									</p>
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
									<p>
										<strong>{{($userData->app_login==1)?'No':'Yes'}}</strong>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Can this user receive email notification?</p>
								</div>
								<div class="col-lg-6 col-md-6">
									<p>
										<strong>{{($userData->email_notification==1)?'No':'Yes'}}</strong>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Workplace:</p>
								</div>

								<div class="col-lg-6 col-md-6">
									<p>
										<strong>{{($userData->workplace==1)?'WFO':'WFH'}}</strong>
									</p>

								</div>
							</div>

						</div>
					</div>
					@if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'personal_information')))

					<div class="col-xl-1 col-lg-1 col-md-1">
						<div class="editProfile text-end">
							<a href="/employee/update/{{$userData->_id}}" class="greyedit"><i class="fa-solid fa-pen" ></i></a>
						</div>
					</div>
					@endif

				</div>
			</div>
			<div class="dashboardSection__body commonBoxShadow rounded-1 mt-5">
				<ul class="nav nav-pills commonTabs" id="pills-tab" role="tablist">
					<li class="nav-item " role="presentation">
						<button class="nav-link <?=($tabs == 'personal') ? 'active' : ''?> " id="pills-personal-tab"
							data-bs-toggle="pill" data-bs-target="#pills-personal"
							type="button" role="tab" aria-controls="pills-personal"
							aria-selected="true">Personal</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link <?=($tabs == 'skill') ? 'active' : ''?>" id="pills-skill-tab"
							data-bs-toggle="pill" data-bs-target="#pills-skill"
							type="button" role="tab" aria-controls="pills-skill"
							aria-selected="false">Skill</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link <?=($tabs == 'accountStatutory') ? 'active' : ''?> " id="pills-account-tab"
							data-bs-toggle="pill" data-bs-target="#pills-account"
							type="button" role="tab" aria-controls="pills-account"
							aria-selected="false">Accounts & Statutory</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link <?=($tabs == 'experience') ? 'active' : ''?>" id="pills-employment-tab"
							data-bs-toggle="pill" data-bs-target="#pills-employment"
							type="button" role="tab" aria-controls="pills-employment"
							aria-selected="false">Employment & Job</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link <?=($tabs == 'additionDetails') ? 'active' : ''?> " id="pills-additional-tab"
							data-bs-toggle="pill" data-bs-target="#pills-additional"
							type="button" role="tab" aria-controls="pills-additional"
							aria-selected="false">Additional Details</button>
					</li>

<!-- 					<li class="nav-item" role="presentation"> -->
<!-- 						<button class="nav-link" id="pills-payroll-tab" -->
<!-- 							data-bs-toggle="pill" data-bs-target="#pills-payroll" -->
<!-- 							type="button" role="tab" aria-controls="pills-payroll" -->
<!-- 							aria-selected="false">Payroll</button> -->
<!-- 					</li> -->

					<li class="nav-item" role="presentation">
						<button class="nav-link <?=($tabs == 'document') ? 'active' : ''?> " id="pills-documents-tab"
							data-bs-toggle="pill" data-bs-target="#pills-documents"
							type="button" role="tab" aria-controls="pills-documents"
							aria-selected="false">Documents</button>
					</li>

					<li class="nav-item" role="presentation">
						<button class="nav-link <?=($tabs == 'attendance') ? 'active' : ''?>  " id="pills-attendance-tab"
							data-bs-toggle="pill" data-bs-target="#pills-attendance"
							type="button" role="tab" aria-controls="pills-attendance"
							aria-selected="false">Attendance</button>
					</li>

					<li class="nav-item" role="presentation">
						<button class="nav-link <?=($tabs == 'leaves') ? 'active' : ''?>" id="pills-leaves-tab"
							data-bs-toggle="pill" data-bs-target="#pills-leaves"
							type="button" role="tab" aria-controls="pills-leaves"
							aria-selected="false">Leaves</button>
					</li>
				</ul>
			</div>

			<div class="tab-content mt-5" id="pills-tabContent">
				<!-- personal tab starts -->
				<div class="tab-pane fade <?=($tabs == 'personal') ? 'active show' : ''?>" id="pills-personal"
					role="tabpanel" aria-labelledby="pills-personal-tab" tabindex="0">
					<div class="row">
						<div class="col-lg-6">
							<div class="profileCard commonBoxShadow rounded-1 mb-3">
								@if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'personal_information')) )
								<a class="editIcon greyedit"
									href="/personal-information/{{$userData->_id}}"><i class="fa-solid fa-pen" ></i>
								</a>
								@endif
								<h3>Personal Information</h3>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Gender:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{ucwords($userData->gender)}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Whatsapp:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->whatsapp}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Personal Email:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->personal_email}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Current Address:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->getCurrentAddress()}}</b>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Current City:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->getCurrentCity()}}</b>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Current State:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->getCurrentState()}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Permanent Address:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->getPermanetAddress()}}</b>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Permanent City:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->getPermanetCity()}}</b>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Permanent State:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->getPermanetState()}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>
											Nationality<span class="red">*</span>:
										</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->nationality}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Religion:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->religion}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Blood Group:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->blood_group}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>
											Martial Status<span class="red">*</span>:
										</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{ucfirst($userData->marital_status)}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Employment of spouse:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{ucfirst($userData->spouse_employment)}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>No. of Children:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->children}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Passport No:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->passport_number}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Passport Expiry Date:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{! empty($userData->passport_expiry_date) ? date('d M Y',$userData->passport_expiry_date): ''}}</b>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Notes:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{$userData->getNotes()}}</b>
										</p>
									</div>
								</div>
							</div>

							<div class="profileCard commonBoxShadow rounded-1 mb-3">

								<h3>Emergency Contact</h3>

								<div class="commonTableResponsive emergencyContactTable">
									<table class="table">
										<tr>
											<th>Name</th>
											<th>Relationship</th>
											<th>Phone</th>
											<th>Phone No.2</th>
											<th>Email</th>
											<th>Notes</th>
											<th>&nbsp;</th>
										</tr>
										@foreach($emergencyContact as $contact)
										<tr>
											<td>{{$contact->name}}</td>
											<td>{{$contact->relationship}}</td>
											<td>{{$contact->phone}}</td>
											<td>{{$contact->phone_two}}</td>
											<td>{{$contact->email}}</td>
											<td>{{$contact->notes}}</td>
											<td>
												<div class="dropdown">
													<a class="btn btn-secondary dropdown-toggle"
														href="javascript:void(0);" role="button"
														data-bs-toggle="dropdown" aria-expanded="false"> <i
														class="fa-solid fa-ellipsis-vertical"></i>
													</a>
												@if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'emergency_contact')||RolesPermission::userpermissions('update',2, 'emergency_contact'))) 
													<ul class="dropdown-menu">
														<li><a class="dropdown-item" href="javascript:void(0);"
															onclick="editEmergency('{{$contact->_id}}','{{$userData->_id}}')">Edit</a></li>
														<li><a class="dropdown-item deleteContact"
															href="javascript:void(0);" data-id="{{$contact->_id}}">Delete</a></li>
													</ul>
													@endif
												</div>
											</td>
										</tr>
										@endforeach
									</table>
								</div>
								<hr />
								@if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'emergency_contact'))) 
								<a class="addBtn" data-bs-toggle="modal"
									data-bs-target="#addEmergencycontact"
									href="javascript:void(0);" onclick="$('.error').html('')">Add
									New <img src="{{ asset('/images/addIcon.svg')}}" />
								</a>
								@endif
							</div>
						</div>
						<div class="col-lg-6">
							<div class="profileCard commonBoxShadow rounded-1  mb-3">
							<?php 
							
							$userConfirmation = UserJoiningDetail::where('user_id',$userData->_id)->first();
							if( empty($userConfirmation) || $userConfirmation->confirmation_check != '2'){
							?>
    							@if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'joining_details')) )
    							<?php 
    							if(isset($userConfirmation->status)&&($userConfirmation->status == "3" || $userConfirmation->status == "4")){
    							?>
    								<a class="editIcon greyedit" data-bs-toggle="modal"
    									onclick="updateJoining('{{$userData->_id}}')" href="javascript:void(0);"> <i class="fa-solid fa-pen" ></i>
    								</a>
    								<?php }?>
							   @endif
							   <?php }?>
								<h3>Joining Details</h3>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>
										@if( empty($joiningDetail) || $joiningDetail->confirmation_check != '2') Expected @endif Confirmation Date:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>
											
											<?php 
											    
											if(! empty( $userData->probation_period == '6')){
											    echo ! empty($userData->joining_date) ? (date('d M Y ', strtotime('+ 6 months', strtotime($userData->joining_date)))) : '';
											}else{
											    echo (date('d M Y ', strtotime('+'.$joiningDetail->probation_period.' months', strtotime($userData->joining_date))));
											}
											?>
											</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Probation Period:<p>
									</div>
									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{! empty($joiningDetail->probation_period) ? $joiningDetail->probation_period . ' months' : ''}}</b>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>RM Confirmation Date :<p>
									</div>
									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{! empty ($joiningDetail->rm_confirmation_date) ? date('d M Y',$joiningDetail->rm_confirmation_date) : ''}}</b>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>RM Rejected Date :<p>
									</div>
									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{! empty ($joiningDetail->rm_rejection_date) ? date('d M Y',$joiningDetail->rm_rejection_date) : ''}}</b>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>HR Confirmation Date :<p>
									</div>
									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{! empty ($joiningDetail->hr_confirmation_date) ? date('d M Y',$joiningDetail->hr_confirmation_date) : ''}}</b>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>HR Rejected Date :<p>
									</div>
									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{! empty ($joiningDetail->hr_rejection_date) ? date('d M Y',$joiningDetail->hr_rejection_date) : ''}}</b>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Status :<p>
									</div>
									<div class="col-lg-8 col-md-8">
										<p>
											<b><?php 
											if(isset($joiningDetail->status) && ! empty($joiningDetail->status)){
    											if($joiningDetail->status=='5'){
    											    echo "Probation Extend";
    											}elseif ($joiningDetail->status=='2'){
    											    echo "Confirmed";
    											}elseif($joiningDetail->status == '1'){
    											    echo "Approve By".' '.$joiningDetail->getRm();
    											}
											}
											?></b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Notes:
										<p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{! empty ($joiningDetail) ? $joiningDetail->notes : ''}}</b>
										</p>
									</div>
								</div>
							</div>

							<div class="profileCard commonBoxShadow rounded-1 mb-3">
							@if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'official_contact_information')) )
								<a class="editIcon greyedit" onclick="editOfficialContact('{{$userData->_id}}')"
									data-bs-target="#officialContact" href="javascript:void(0);"> <i class="fa-solid fa-pen" ></i>
								</a>
							@endif
								<h3>Official Contact Information</h3>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Redmine Username:</p>
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{! empty($officialContact) ? $officialContact->redmine_username : ''}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Discord Username:
										
										
										<p>
									
									</div>

									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{! empty($officialContact) ? $officialContact->discord_username :''}}</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Skype ID:<p>
									</div>
									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{! empty($officialContact) ? $officialContact->skype_id :''}}</b>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<p>Notes:<p>
									</div>
									<div class="col-lg-8 col-md-8">
										<p>
											<b>{{! empty($officialContact) ? $officialContact->notes :''}}</b>
										</p>
									</div>
								</div>
							</div>
							<div class="profileCard commonBoxShadow rounded-1 mb-3">
								<h3>Family Information</h3>
								<div class="commonTableResponsive familyInformation">
									<table class="table">
										<tr>
											<th>Name</th>
											<th>Relationship</th>
											<th>Date of Birth</th>
											<th>Phone</th>
											<th>Address</th>
											<th>Notes</th>
											<th>&nbsp;</th>
										</tr>
										@foreach($familyInformation as $family)
										<tr>
											<td>{{ucfirst($family->name)}}</td>
											<td>{{ucfirst($family->relationship)}}</td>
											<td>{{$family->date_of_birth}}</td>
											<td>{{$family->phone}}</td>
											<td>{{$family->address}}</td>
											<td>{{$family->notes}}</td>
											<td>
												<div class="dropdown">
													<a class="btn btn-secondary dropdown-toggle"
														href="javascript:void(0);" role="button"
														data-bs-toggle="dropdown" aria-expanded="false"> <i
														class="fa-solid fa-ellipsis-vertical"></i>
													</a>
													<ul class="dropdown-menu">
													 @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'family_information'))) 
														<li><a class="dropdown-item" href="javascript:void(0);" onclick="editFamily('{{$family->_id}}','{{$userData->_id}}')">Edit</a></li>
													@endif
													@if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'family_information'))) 
														<li><a class="dropdown-item deleteFamily" href="javascript:void(0);" data-id="{{$family->_id}}">Delete</a></li>
													@endif
													</ul>
												</div>
											</td>
										</tr>
										@endforeach
									</table>
								</div>
								@if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2, 'family_information'))) 
								<a class="addBtn" data-bs-toggle="modal" data-bs-target="#addFamilyInformation" href="javascript:void(0);" onclick="$('.error').html('')">Add New <img
									src="/images/addIcon.svg" /></a>
								@endif
							</div>

							<div class="profileCard commonBoxShadow rounded-1 mb-3">
								<h3>Education Information</h3>

								<ul class="eduList">
								@foreach($userEducation as $education)
									<li>
										<p class="instituteName">
											<b>{{$education->institute}}</b>
										</p>
										<p>{{$education->degree}}</p>
										<p>{{$education->starting_date}} - {{$education->completed_date}} . {{$education->grade}}</p> 
										@if(! empty($education->document))
										<a
										href="{{$education->document}}" target="_blank"><img src="/images/pdfIcon.svg" /> <small></small></a>
										@endif
										<p><b>Note</b> : {{$education->notes}}</p>
										
										<div>
										@if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'education_information')) )
										<a class="editEducation" onclick="editEducation('{{$education->_id}}','{{$userData->_id}}')" ><i class="fa-solid fa-pen"></i> </a>
									    @endif
									    </div>
									    <div>
									    @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'education_information')) )
										<a class="eddeleteicon deleteEducation" onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$education->_id}}" ><i class="fa-regular fa-trash-can"></i></a>
										@endif
										</div>
									</li>
									@endforeach
								</ul>
							    @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2, 'education_information')) )
								<a class="addBtn mt-4" data-bs-toggle="modal" data-bs-target="#addeducationInformation" href="javascript:void(0);" onclick="$('#updatedFamily').html('')">Add New <img
									src="/images/addIcon.svg" /></a>
							    @endif

							</div>
						</div>
					</div>
				</div>
				<!-- personal ends -->
				<!-- Employee Skill -->
				
				<div class="tab-pane fade <?=($tabs == 'skill') ? 'active show' : ''?>" id="pills-skill" role="tabpanel"
					aria-labelledby="pills-skill-tab" tabindex="0">
					<div class="row">
						<div class="col-lg-4">
							<div class="profileCard commonBoxShadow rounded-1 mb-3">
								
								<h3>Skill</h3>
								<div class="commonTableResponsive skillTable">
									<table class="table">
										<tr>
											<th>Skill</th>
											<th>Notes</th>
										</tr>
										@foreach($employeeSkills as $skill)
										<tr>
											<td>{{ucfirst($skill->employee_skill)}}</td>
											<td>{{ucfirst($skill->notes)}}</td>
											<td>
												<div class="dropdown text-right">
													<a class="btn btn-secondary dropdown-toggle"
														href="javascript:void(0);" role="button"
														data-bs-toggle="dropdown" aria-expanded="false">
														<!-- <i class="fa-solid fa-ellipsis-vertical"></i> -->
														<img src="{{asset ('images/vertical-dots.svg')}}"/>
													</a>
													<ul class="dropdown-menu">
														<li><a class="dropdown-item" href="javascript:void(0);" onclick="editSkill('{{$skill->_id}}','{{$userData->_id}}')">Edit</a></li>
														<li><a class="dropdown-item deleteSkill" href="javascript:void(0);" data-id="{{$skill->_id}}">Delete</a></li>
													</ul>
												</div>
											</td>
										</tr>
										@endforeach
									</table>
								</div>
									<a class="addBtn" data-bs-toggle="modal" data-bs-target="#employeeskill" href="javascript:void(0);" onclick="$('.error').html('')">Add New <img
									src="/images/addIcon.svg" /></a>
							</div>
							
						</div>
					</div>
				</div>
				<!--End Skill  -->

				<!-- account tab starts -->
				<div class="tab-pane fade <?=($tabs == 'accountStatutory') ? 'active show' : ''?>" id="pills-account" role="tabpanel"
					aria-labelledby="pills-account-tab" tabindex="0">
					<div class="row">
						<div class="col-lg-6">
							<div class="profileCard commonBoxShadow rounded-1 mb-3">
							@if((Auth::user()->user_role==0)||(Permission::userpermissions('update','2','bank_information')) )
								<a class="editIcon greyedit" data-bs-toggle="modal"
									onclick="updateBankInfo('{{$userData->_id}}')" href="javascript:void(0);"> <i class="fa-solid fa-pen" ></i>
								</a>
							@endif
								<h3>Bank Information</h3>
								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Name as per Bank Records:</p>
									</div>

									<div class="col-lg-6 col-md-6">
										<p class="green">
											<strong>{{! empty($bankInfo)  ? ucfirst($bankInfo->username) : ''}}</strong>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Bank Name:</p>
									</div>

									<div class="col-lg-6 col-md-6">
										<p class="green">
											<strong>{{! empty($bankInfo)  ? $bankInfo->bank_name : ''}}</strong>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Bank Account No:</p>
									</div>

									<div class="col-lg-6 col-md-6">
										<p class="">
											<strong>{{! empty($bankInfo)  ? $bankInfo->account : ''}}</strong>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>IFSC Code:</p>
									</div>

									<div class="col-lg-6 col-md-6">
										<p class="">
											<strong>{{! empty($bankInfo)  ? $bankInfo->ifsc : ''}}</strong>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>PAN No:</p>
									</div>

									<div class="col-lg-6 col-md-6">
										<p class="">
											<strong>{{! empty($bankInfo)  ? $bankInfo->pan : ''}}</strong>
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="profileCard commonBoxShadow rounded-1 mb-3">
							 @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'bank_and_statutory')) )
								<a class="editIcon greyedit" href="/bank-statutory/{{$userData->_id}}"> <i class="fa-solid fa-pen" ></i>
								</a>
							@endif
								<h3>Bank & Statutory</h3>
								<p class="green">
									<strong>ESI Account:</strong>
								</p>
								@if(! empty($employeeBank))
								<ul>
	                            <li><b>ESI Number</b> : {{$employeeBank->esi_number}}</li>
								<li><b>Branch office</b> : {{$employeeBank->branch_office}}</li>
								<li><b>Dispensary</b> : {{$employeeBank->dispensary}}</li>
								</ul>
								@else
								<p class="warning">
									<span><img src="/images/warningIcon.svg" /> Not covered under
										ESI.</span>
								</p>
								@endif

								<p class="green mt-5">
									<strong>PF Account:</strong>
								</p>
							@if(! empty($employeeBank))
							<ul>
	                            <li><b>UAN Number</b> : {{$employeeBank->uan}}</li>
								<li><b>PF Number</b> : {{$employeeBank->pf_number}}</li>
								</ul>
							@else
								<p class="warning mt-3">
									<span><img src="/images/warningIcon.svg" /> Not covered under
										PF.</span>
								</p>
								@endif
							</div>
						</div>
					</div>
				</div>
				<!-- account tab ends -->

				<!-- employeement tab starts -->
				<div class="tab-pane fade <?=($tabs == 'experience') ? 'active show' : ''?>" id="pills-employment" role="tabpanel"
					aria-labelledby="pills-employment-tab" tabindex="0">
					<div class="row">
						<div class="col-lg-9 col-xxl-6 col-xl-8">
							<div class="profileCard commonBoxShadow rounded-1 mb-3">
								<h3>Experience Information</h3>
								<ul class="eduList experienceActionBtns">
								@foreach($userExperience as $experience)
								<?php 
								$yearsDiff = $experience->period_to - $experience->period_from;
								$years = floor($yearsDiff / (365*60*60*24));
								$months = floor(($yearsDiff - $years * 365*60*60*24) / (30*60*60*24));
								?>
									<li>
										<p>
										@if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2,'employment_and_job')) )
											<a class="editIcon deleteExperience" onclick="deleteExperience('{{$userData->_id}}')" ><i class="fa-regular fa-trash-can"></i>
										@endif
										</a>
										@if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2,'employment_and_job')) )
										<a class="editIcon greyedit" href="/edit-experience-information/{{$experience->_id}}/{{$userData->_id}}" ><i class="fa-solid fa-pen"></i>
									
								</a> @endif	&nbsp;
											<b>{{$experience->company_name}}</b>
										</p>
										<p>
											<b>{{date('jS M Y',$experience->period_from)}} - {{date('jS M Y',$experience->period_to)}}({{$years}} years {{$months}} months)-{{$experience->net_pay}}</b>
										</p>
										<p>{{$experience->designation}}</p>
										<p>{{$experience->company_city}}  {{$experience->company_state}}  {{$experience->getCountryAttribute()}}</p>
									</li>
									@endforeach
								</ul>
								@if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2,'employment_and_job')) )
								
								<a class="addBtn" href="/experience-information/{{$userData->_id}}" onclick="$('.error').html('')">Add New <img
									src="/images/addIcon.svg" /></a>
									@endif
							</div>
							
						</div>
					</div>

				</div>
				<!-- employeement tab ends -->

				<!-- additionalm information starts -->
				<div class="tab-pane fade <?=($tabs == 'additionDetails') ? 'active show' : ''?>  " id="pills-additional" role="tabpanel"
					aria-labelledby="pills-additional-tab" tabindex="0">
					<div class="row">
						<div class="col-lg-5">
							<div class="profileCard commonBoxShadow rounded-1 mb-3">
							@if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'additional_detail')) ) 
								<a class="editIcon greyedit" onclick ="editaddition('{{$userData->_id}}')"href="javascript:void(0);"> <i class="fa-solid fa-pen" ></i>
								</a>
							@endif
								<h3>Additional Details</h3>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Allergies:</p>
									</div>
									<div class="col-lg-6 col-md-6">
										<p>
											<strong>{{! empty($userAdditionDetails) ? ucfirst($userAdditionDetails->allergies) : ''}}</strong>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Smoke:</p>
									</div>
									<div class="col-lg-6 col-md-6">
										<p>
											<strong>{{! empty($userAdditionDetails) ? ucfirst($userAdditionDetails->smoke) : ''}}</strong>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Drink:</p>
									</div>
									<div class="col-lg-6 col-md-6">
										<p>
											<strong>{{! empty($userAdditionDetails) ? ucfirst($userAdditionDetails->drink) : ''}}</strong>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Diet:</p>
									</div>
									<div class="col-lg-6 col-md-6">
										<p>
											<strong>{{! empty($userAdditionDetails) ? ucfirst($userAdditionDetails->diet) : ''}}</strong>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Hobbies:</p>
									</div>
									<div class="col-lg-6 col-md-6">
										<p>
											<strong>{{! empty($userAdditionDetails) ? ucfirst($userAdditionDetails->hobbies) : ''}}</strong>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- additional information ends -->

				<!-- payroll tab starts -->
				<div class="tab-pane fade" id="pills-payroll" role="tabpanel"
					aria-labelledby="pills-payroll-tab" tabindex="0">
					<div class="row">
						<div class="col-lg-5">
							<div class="profileCard commonBoxShadow rounded-1 mb-3">
								<a class="editIcon" data-bs-toggle="modal"
									data-bs-target="#payrollInfo" href="javascript:void(0);"> <img
									src="/images/editIcon.svg">
								</a>
								<h3>Payroll</h3>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Annual CTC:</p>
									</div>
									<div class="col-lg-6 col-md-6">
										<p>
											<strong>8,70,000</strong>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Basic Salary:</p>
									</div>
									<div class="col-lg-6 col-md-6">
										<p class="green">
											<strong>----</strong>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Allowances:</p>
									</div>
									<div class="col-lg-6 col-md-6">
										<p>
											<strong>1500</strong>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6">
										<p>Deductions:</p>
									</div>
									<div class="col-lg-6 col-md-6">
										<p>
											<strong>2500</strong>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- payroll tab ends -->

				<!-- document tab starts -->
				<div class="tab-pane fade <?=($tabs == 'document') ? 'active show' : ''?> " id="pills-documents" role="tabpanel"
					aria-labelledby="pills-documents-tab" tabindex="0">
					<div class="row">
						<div class="col-md-12">
							<div class="profileCard commonBoxShadow rounded-1 mb-3">
								<h3>Documents</h3>
								
								<div class="commonDataTable">
									<table class="table">
										<tr>
<!-- 										<th>Folder Name</th> -->
										<th>Document Name</th>
										<th>Document Type</th>
										<th></th>
										</tr>
										@foreach($employeeDocument as $alldocument)
										<tr>
											<td><a target="_blank" href="{{$alldocument->document}}">
											<?php 
											if(! empty($alldocument->document)){?>
											<img src="/images/pdfIcon.svg" />
											<?php }?></a> {{$alldocument->name}}</td>
											<td>{{$alldocument->type}}</td>
											<td>
												<div class="actionIcons">
													<ul>
												@if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'documents')) ) 
												<li><a class="editIcon edit_multiple_document edit position-relative top-0 left-0 mr-1" onclick="editDocument('{{$alldocument->_id}}','{{$userData->_id}}')" ><i class="fa-solid fa-pen"></i></a></li>
												@endif
												<button class="bin eyeButtons edit mx-1 documenteyebutton" type="button" data-bs-toggle="modal" onclick="documentView('{{$alldocument->_id}}','{{$userData->_id}}')"><i class="fa fa-eye" aria-hidden="true"></i></button>
												@if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2,'documents')) ) 
												<li><a class="deleteDocument policyDelete ml-1" data-id="{{$alldocument->_id}}" > <i class="fa-regular fa-trash-can"></i></a></li>
												@endif
												</ul>
												</div>
											</td>
										</tr>
										@endforeach
									</table>
									{{$employeeDocument->links('pagination::bootstrap-4')}}
								</div>
								@if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2,'documents')) ) 
								<a class="addBtn mt-5" data-bs-toggle="modal"
									data-bs-target="#documentInfo" href="javascript:void(0);">Add
									New <img src="/images/addIcon.svg">
								</a>
								@endif
							</div>
						</div>
					</div>
				</div>
				
<!-- 				<div class="modal fade commonModalNew" id="folderModal" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true"> -->
<!--   <div class="modal-dialog modal-dialog-centered"> -->
<!--     <div class="modal-content"> -->
<!--       <div class="modal-header"> -->
<!--         <h1 class="modal-title fs-5" id="folderModalLabel">Create Folder</h1> -->
<!--         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
<!--       </div> -->
<!--       <div class="modal-body"> -->
<!--            <form method="post" enctype="multipart/form-data" id="addFolder"> -->
<!-- 					@csrf -->
<!-- 					<input type="hidden" name="user_id" -->
<!-- 								value="{{$userData->_id}}" /> -->
<!-- 					<div class="col-lg-12"> -->
<!--                             <div class="form-group"> -->
<!--                                 <label>Folder Name</label> -->
<!--                                 <input type="text" id="folder_name" class="form-control" value="" name="folder_name"> -->
<!--                                      <span class="text-danger error" id="errorss_folder_name"></span>  -->
<!--                             </div> -->
<!--                         </div> -->
<!--                          <div class="modal-footer"> -->
<!--                                     <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Close</button> -->
<!--                                     <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button> -->
<!--       					</div> -->
<!--                 </form> -->
<!--       </div> -->
     
<!--     </div> -->
<!--   </div> -->
<!-- </div> -->
				<!-- document tab ends -->

				<!-- attendance tab starts -->
				<div class="tab-pane fade <?=($tabs == 'attendance') ? 'active show' : ''?>" id="pills-attendance" role="tabpanel"
					aria-labelledby="pills-attendance-tab" tabindex="0">
					<div class="profileCard commonBoxShadow rounded-1 mb-3">
						<h3>Attendance</h3>

						<div class="pageFilter mb-3">
							<div class="row">
								<form  method="get" action="/employee-profile/{{$userData->_id}}?activetab=attendance">
									<input type="hidden" name="activetab" value="attendance" id="activetab" />
									<div class="leftFilters">
										<div class="col-xxl-3 col-xl-3 col-lg-4">
											<div class="form-floating">
												<input type="date" class="form-control" id="floatingInput" placeholder="Date" name="from_date" value="{{$from_Date}}"> 
												<label for="floatingInput">From Date</label>
											</div>
										</div>
										<div class="col-xxl-3 col-xl-3 col-lg-4">
											<div class="form-floating">
												<input type="date" class="form-control" id="floatingInput" placeholder="Date" name="to_date" value="{{$to_Date}}"> 
												<label for="floatingInput">To Date</label>
											</div>
										</div>
										
										<button class="btn btn-search mt-0">
											<img src="/images/iconSearch.svg" /> Search here
										</button>
										<button type="button" value="reset" class="btn btn-search mt-0" onclick="window.location='{{ url("employee-profile/$userData->_id?activetab=attendance") }}'">Reset</button>
									</div>
								</form>
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
										</tr>
									</thead>
									<tbody>
									 @if(empty($employeeAttendance) || count($employeeAttendance) == 0)
                                                <tr><td class="text-center" colspan="9">No Data Found</td></tr>
                                            @else   
								@foreach($employeeAttendance as $key=>$attendance)
										<tr>
											<td>{{++$key}}</td>
											<td>{{date('d M, Y',$attendance->date)}}</td>
											<td>{{! empty ($attendance->punch_in) ? date('H:i:s a',$attendance->punch_in) : ''}}</td>
											<td>{{! empty($attendance->punch_out) ? date('H:i:s a',$attendance->punch_out) : ''}}</td>
											<td><?php 
											if(! empty($attendance->punch_out)){
											    $mins = ($attendance->punch_out)-($attendance->punch_in);
							    echo gmdate("H:i:s", $mins);
											}
							    ?>
							    </td>
										</tr>
								@endforeach
								@endif
									</tbody>
								</table>
												 {{$employeeAttendance->links('pagination::bootstrap-4')}}
								
							</div>
						</div>
					</div>
				</div>
				<!-- attendance tab ends -->

				<!-- Leaves tabs starts -->
				<div class="tab-pane fade <?=($tabs == 'leaves') ? 'active show' : ''?>" id="pills-leaves" role="tabpanel"
					aria-labelledby="pills-leaves-tab" tabindex="0">
					<div class="profileCard commonBoxShadow rounded-1 mb-3">
						<h3>Leaves</h3>
<!-- 						<div class="row"> -->
<!-- 							<div class="col-lg-3 col-md-3 col-6"> -->
<!-- 								<div class="leaveCard"> -->
<!-- 									<h4>20</h4> -->
<!-- 									<p>Annual Leave</p> -->
<!-- 								</div> -->
<!-- 							</div> -->

<!-- 							<div class="col-lg-3 col-md-3 col-6"> -->
<!-- 								<div class="leaveCard"> -->
<!-- 									<h4>10</h4> -->
<!-- 									<p>Medical Leave</p> -->
<!-- 								</div> -->
<!-- 							</div> -->

<!-- 							<div class="col-lg-3 col-md-3 col-6"> -->
<!-- 								<div class="leaveCard"> -->
<!-- 									<h4>5</h4> -->
<!-- 									<p>Other Leave</p> -->
<!-- 								</div> -->
<!-- 							</div> -->

<!-- 							<div class="col-lg-3 col-md-3 col-6"> -->
<!-- 								<div class="leaveCard"> -->
<!-- 									<h4>10</h4> -->
<!-- 									<p>Remaining Leave</p> -->
<!-- 									</div> -->
<!-- 							</div> -->
<!-- 						</div> -->

						<div class="pageFilter mb-3 mt-4 p-0">
							<div class="row">
								<div class="col-lg-3">
								<form  method="get" action="/employee-profile/{{$userData->_id}}?activetab=leaves">
								<input type="hidden" name="activetab" value="leaves" id="leaves" />
									<div class="leftFilters">
										<div class="form-floating position-reletive">
											<input type="date" name="leave_from_date" class="form-control datePicker" value="{{$leave_from_date}}"
												placeholder="Date"> <label for="floatingInput">From Date</label>
										</div>
										<div class="col-xxl-3 col-xl-3 col-lg-4">
											<div class="form-floating">
												<input type="date" class="form-control" id="floatingInput" placeholder="Date" name="leave_to_date" value="{{$leave_to_date}}"> 
												<label for="floatingInput">To Date</label>
											</div>
										</div>
										<button class="btn btn-search mt-0">
											<img src="/images/iconSearch.svg" /> Search here
										</button>
										<div class="col-sm">
                            				<button type="button" value="reset" class="btn btn-search mt-0" onclick="window.location='{{ url("employee-profile/$userData->_id?activetab=leaves") }}'">Reset</button>
                            			</div>
									</div>
									</form>
								</div>
							</div>
						</div>

						<div class="commonDataTable">
							<div class="table-responsive">
								<table class="table mt-3">
									<thead>
										<tr>
											<th>Employee ID</th>
											<th>From</th>
											<th>To</th>
											<th>Leave Type</th>
											<th>Reason</th>
											<th>Leave Status</th>
											</tr>
									</thead>
									<tbody>
									 @if(empty($employeeLeave) || count($employeeLeave) == 0)
                                                <tr><td class="text-center" colspan="9">No Data Found</td></tr>
                                            @else   
									@foreach($employeeLeave as $leave)
										<tr>
											<td>{{$userData->employee_id}}</td>
											<td>{{date('d M,Y',$leave->str_from_date)}}</td>
											<td>{{date('d M,Y',$leave->str_to_date)}}</td>
											<td><?php 
											if($leave->leave_type == '1'){
											    echo "Casual Leave";
											}elseif($leave->leave_type == '2'){
											    echo "Sick Leave";
											}elseif($leave->leave_type == '3'){
											    echo "Earned Leave";
											}else{
											    echo "Loss Of Pay";
											}
											
											?></td>
											<td>{{$leave->reason}}</td>
											<td><span class="badge badge-blue"><?php 
											
											if($leave->status==1){
											    echo 'Pending';
											}
											if($leave->status==2){
											    echo 'Approved';
											}
											if($leave->status==3){
											    echo 'Rejected';
											}
											
											?></span></td>
										</tr>
										@endforeach
										@endif
									</tbody>
								</table>
									{{$employeeLeave->links('pagination::bootstrap-4')}}
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		
		
		<div class="modal fade" id="documentInfo" tabindex="-1"
			aria-labelledby="documentInfoLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5 ml-auto" id="documentInfoLabel">Documents
						</h1>
						<button type="button" class="btn-close roundedclose" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post" enctype="multipart/form-data"
							id="addEmployeeDocument">
							@csrf <input type="hidden" name="user_id"
								value="{{$userData->_id}}" />
							<div class="row">
								 <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Document Name<span class="text-red">*</span></label>
                                    <input type="text" name="name"  class="form-control" placeholder="Enter Document Name" />
                                                               <span class="text-danger error" id="errordocument_name"></span> 
                                </div>
                            </div>
                            

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Document Type <span class="text-red">*</span></label>
                                    <select id="document_type" name="type" class="form-control">
                                        <option value="">Select Document</option>
                                         @foreach($masterDocument as $document)
                                        <option value="{{$document->document}}">{{ucfirst($document->document)}}</option>
                                        @endforeach
                                    </select>
                                                               <span class="text-danger error" id="errordocument_type"></span> 
                                    
                                   
                                </div>
                            </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Document</label><span class="text-red">*</span>
                                    <div class="fileUploader">
                                        <input type="file" name="document[]" multiple title="Upload Document">
                                    </div>
                                      <span class="text-danger error" id="errordocument_document"></span> 
                                 </div>
                               </div>
                               <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="notes_document" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"  ></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary modalcanceleffect"
									data-bs-dismiss="modal">Cancel</button>
								<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
		
		<div class="modal fade" id="editdocumentInfo" tabindex="-1"
			aria-labelledby="editdocumentInfoLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="documentInfoLabel">Edit Documents
						</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post" enctype="multipart/form-data"
							id="updatedEmployeeDocument">
							@csrf <input type="hidden" name="user_id"
								value="{{$userData->_id}}" />
								<input type="hidden" name="edit_document_id" id="edit_document_id" />
 							<div class="row">
								 <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Document Name <span class="text-red">*</span></label>
                                    <input type="text" name="name"  class="form-control" id="edit_document" placeholder="Enter Document Name" />
                                                               <span class="text-danger error" id="errordocument_name"></span> 
                                </div>
                            </div>
                            

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Document Type <span class="text-red">*</span></label>
                                    <select id="edit_document_type" name="type" class="form-control">
                                        <option value="">Select Document</option>
                                         @foreach($masterDocument as $document)
                                        <option value="{{$document->document}}">{{ucfirst($document->document)}}</option>
                                        @endforeach
                                    </select>
                                                               <span class="text-danger error" id="errordocument_type"></span> 
                                    
                                   
                                </div>
                            </div>
                            <div class="form-group">
				                                        <input type="file" name='document' id="edit_all_document" title="Upload Documents"

					style="display: none;" > <span id="all_document"></span>
					<a  href="" target="_blank" id="edit_documents"><img src="/images/pdfIcon.svg" /> <small></small></a>
					<label for="edit_all_document" class="btn btn-default"><i
					class="fa-solid fa-upload"></i>Document</label><br />
					<span class="text-danger error" id="errorseducation_document"></span>
				<br />
				
			</div>
			
			
			
                            
                               <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="edit_notes_document" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"  ></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary modalcanceleffect"
									data-bs-dismiss="modal">Close</button>
								<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
		
		
		

		<div class="modal fade" id="addEmergencycontact" tabindex="-1"
			aria-labelledby="addEmergencycontactLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5 ml-auto" id="addEmergencycontactLabel">Emergency
							Contact Information</h1>
						<button type="button" class="btn-close roundedclose" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post" enctype="multipart/form-data"
							id="addemergencyContact">
							@csrf <input type="hidden" name="user_id"
								value="{{$userData->_id}}" />
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="name">Name <sup>*</sup></label> <input name='name'
											type="text" class="form-control" placeholder="Enter Name" />
										<span class="text-danger error" id="error_name"></span>

									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="relationship">Relationship <sup>*</sup></label> <input
											name='relationship' type="text" class="form-control"
											placeholder="Enter relationship Name" /> <span
											class="text-danger error" id="error_relationship"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="phone">Phone No. <sup>*</sup></label> <input
											name='phone' type="text" class="form-control"
											placeholder="Enter Phone no." /> <span
											class="text-danger error" id="error_phone"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="phone_two">Phone No.2</label> <input
											name='phone_two' type="text" class="form-control"
											placeholder="Enter Phone no." /> <span
											class="text-danger error" id="error_phone_two"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="email">Email</label> <input
											name='email' type="text" class="form-control"
											placeholder="Enter email" /> <span class="text-danger error"
											id="error_email"></span>

									</div>
								</div>
								<div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="notes" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes" ></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary modalcanceleffect"
									data-bs-dismiss="modal">Cancel</button>
								<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>



		<div class="modal fade" id="editEmergencycontact" tabindex="-1"
			aria-labelledby="editEmergencycontactLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="editEmergencycontactLabel">Edit
							Emergency Contact Information</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post" enctype="multipart/form-data"
							id="updateemergencyContact">
							@csrf <input type="hidden" name="user_id"
								value="{{$userData->_id}}" /> <input type="hidden"
								name="edit_id" id="edit_id" value="" />

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="name">Name <sup>*</sup></label> <input name='name'
											type="text" class="form-control" placeholder="Enter Name"
											id="edit_name" /> <span class="text-danger error"
											id="error_name"></span>

									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="relationship">Relationship <sup>*</sup></label> <input
											name='relationship' type="text" class="form-control"
											placeholder="Enter relationship Name" id="edit_relationship" />
										<span class="text-danger error" id="error_relationship"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="phone">Phone No. <sup>*</sup></label> <input
											name='phone' type="text" class="form-control"
											placeholder="Enter Phone no." id="edit_phone_no" /> <span
											class="text-danger error" id="error_phone"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="phone_two">Phone No.2</label> <input
											name='phone_two' type="text" class="form-control"
											placeholder="Enter Phone no." id="edit_phone_no2" /> <span
											class="text-danger error" id="error_phone_two"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="email">Email</label> <input
											name='email' type="text" class="form-control"
											placeholder="Enter email" id="edit_email" /> <span
											class="text-danger error" id="error_email"></span>

									</div>
								</div>
								<div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="edit_notes_emergency" name="notes" 
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes" ></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary modalcanceleffect"
									data-bs-dismiss="modal">Close</button>
								<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>

		<div class="modal fade" id="joiningDetail" tabindex="-1"
			aria-labelledby="joiningDetailLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="joiningDetailLabel">Joining
							Details</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post" enctype="multipart/form-data"
							id="addjoiningDetails">
							@csrf <input type="hidden" name="user_id"
								value="{{$userData->_id}}" />
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mt-0">
										<label>Probation Periods</label> 
										<input name="probation_period" class="form-control" id="probation_period">
									</div>
								</div>

						<div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="edit_notes_joining" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary modalcanceleffect"
									data-bs-dismiss="modal">Close</button>
								<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
		<div class="modal fade" id="officialContact" tabindex="-1"
			aria-labelledby="officialContactLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5 ml-auto" id="officialContactLabel">Official Contact Information
						</h1>
						<button type="button" class="btn-close roundedclose" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post" enctype="multipart/form-data"
							id="addOfficialContact">
							@csrf <input type="hidden" name="user_id"
								value="{{$userData->_id}}" />
							<div class="row">
								<div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="redmine">Redmine Username</label>
                                <input name="redmine_username" type="text" class="form-control" placeholder="Enter Redmine Username" id="redmine_username"/>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="discord">Discord Username</label>
                                <input name="discord_username" type="text" class="form-control" placeholder="Enter Discord Username" id="discord_username"/>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="skype">Skype ID</label>
                                <input name="skype_id" type="text" class="form-control" placeholder="Enter Skype ID" id="skype_id"/>
                            </div>
                        </div>
                        
                        
                        
                        <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="edit_notes_official_contact" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary modalcanceleffect"
									data-bs-dismiss="modal">Cancel</button>
								<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
		
		
		<div class="modal fade" id="addFamilyInformation" tabindex="-1"
			aria-labelledby="addFamilyInformationLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5 ml-auto" id="addFamilyInformationLabel">Family Information
						</h1>
						<button type="button" class="btn-close roundedclose" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post" enctype="multipart/form-data"
							id="addFamily">
							@csrf <input type="hidden" name="user_id"
								value="{{$userData->_id}}" />
							<div class="row">
								<div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-red">*</span></label>
                                    <input name='name' type="text" class="form-control" placeholder="Enter Name" />
                                 	<span class="text-danger error" id="errors_name"></span>
                                    
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="relation">Relationship <span class="text-red">*</span></label>
                                    <input name='relationship' type="text" class="form-control" placeholder="Enter Relationship" />
                                   <span class="text-danger error" id="errors_relationship"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" placeholder="Enter Date of Birth" name='date_of_birth' />
                                     <span class="text-danger error" id="errors_date_of_birth"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">Phone <span class="text-red">*</span></label>
                                    <input name='phone' type="number" class="form-control" placeholder="Enter Phone" />
                                   <span class="text-danger error" id="errors_phone"></span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input name='address' type="text" class="form-control" placeholder="Enter Address" />
                                      <span class="text-danger error" id="errors_address"></span>
                                </div>

                            </div>
                            <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="add_notes_family" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary modalcanceleffect"
									data-bs-dismiss="modal">Cancel</button>
								<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
		
		
			<div class="modal fade" id="editFamilyInformation" tabindex="-1"
			aria-labelledby="editFamilyInformationLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5 ml-auto" id="editFamilyInformationLabel">Edit Family Information
						</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post" enctype="multipart/form-data"
							id="updatedFamily">
							@csrf <input type="hidden" name="user_id"
								value="{{$userData->_id}}" />
								
								 <input type="hidden"
								name="edit_family_id" id="edit_family_id" value="" />
							<div class="row">
								<div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-red">*</span></label>
                                    <input name='name' type="text" class="form-control" placeholder="Enter Name" id="edit_family_name"/>
                                 	<span class="text-danger error" id="errorfamily_name"></span>
                                    
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="relation">Relationship <span class="text-red">*</span></label>
                                    <input name='relationship' type="text" class="form-control" placeholder="Enter Relationship" id="edit_family_relation"/>
                                   <span class="text-danger error" id="errorfamily_relationship"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" placeholder="Enter Date of Birth" name='date_of_birth' id="edit_family_date_birth"/>
                                     <span class="text-danger error" id="errorfamily_date_of_birth"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">Phone <span class="text-red">*</span></label>
                                    <input name='phone' type="number" class="form-control" placeholder="Enter Phone" id="edit_family_phone"/>
                                   <span class="text-danger error" id="errorfamily_phone"></span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input name='address' type="text" class="form-control" placeholder="Enter Address" id="edit_family_address" />
                                      <span class="text-danger error" id="errorfamily_address"></span>
                                </div>

                            </div>
                            <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="edit_notes_family" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary modalcanceleffect"
									data-bs-dismiss="modal">Close</button>
								<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
		
		<div class="modal fade commonModalNew" id="addeducationInformation" tabindex="-1"
			aria-labelledby="addeducationInformationLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5 ml-auto" id="addeducationInformationLabel">Education Information
						</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post" enctype="multipart/form-data"
							id="addEducation">
							@csrf <input type="hidden" name="user_id"
								value="{{$userData->_id}}" />
								
								 <input type="hidden"
								name="edit_family_id" id="edit_family_id" value="" />
							<div class="row">
								 <div class="col-lg-6">
                                    <div class="form-group mt-0">
                                        <label for="institute">Institute <span class="text-red">*</span></label>
                                        <input name='institute' type="text" class="form-control" placeholder="Enter Institute Name" />
                                        <span class="text-danger error" id="errorseducation_institute"></span> 
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mt-0">
                                        <label for="startDate">Starting Date</label>
                                        <input name='starting_date' type="date" class="form-control" placeholder="Enter Starting Date" />
                                        <span class="text-danger error" id="errorseducation_starting_date"></span> 
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="completeDate">Complete Date</label>
                                        <input name='completed_date' type="date" class="form-control" placeholder="Enter Complete Date" />
                                        <span class="text-danger error" id="errorseducation_completed_date"></span> 
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="degree">Select Degree</label>
                                        <select name='degree' id="employee_degree"class="form-control degree">
                                            <option value="">Select Degree</option>
                                            @foreach($allDegree as $degree)
                                            <option value="{{$degree->degree_name}}">{{$degree->degree_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Grade</label>
                                        <input type="text" name='grade' class="form-control" placeholder="Enter Grade" />
                                    </div>
                                </div> 
                                
                                 <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Upload Document</label>
                                    <div class="fileUploader">
                                        <input type="file" name="document" id="upload_document" title="Upload Document">
                                    </div>
                                      <span class="text-danger error" id="errorseducation_document"></span>
                                 </div>
                               </div>
				<div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="add_notes_education_information" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary modalcanceleffect"
									data-bs-dismiss="modal">Cancel</button>
								<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
		
		<div class="modal fade" id="editeducationInformation" tabindex="-1"
			aria-labelledby="editeducationInformationLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5 ml-auto" id="editeducationInformationLabel">Edit Education Information
						</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post" enctype="multipart/form-data"
							id="updatedEducation">
							@csrf <input type="hidden" name="user_id"
								value="{{$userData->_id}}" />
								
								 <input type="hidden"
								name="edit_education_id" id="edit_education_id" value="" />
							<div class="row">
								 <div class="col-lg-6">
                                    <div class="form-group mt-0">
                                        <label for="institute">Institute <span class="text-red">*</span></label>
                                        <input name='institute' id="edit_education" type="text" class="form-control" placeholder="Enter Institute Name" />
                                        <span class="text-danger error" id="errors_edit_education_institute"></span> 
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mt-0">
                                        <label for="startDate">Starting Date</label>
                                        <input name='starting_date' id="edit_starting_date" type="date" class="form-control" placeholder="Enter Starting Date" />
                                        <span class="text-danger error" id="errors_edit_education_starting_date"></span> 
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="completeDate">Complete Date</label>
                                        <input name='completed_date' id="edit_completed_date" type="date" class="form-control" placeholder="Enter Complete Date" />
                                        <span class="text-danger error" id="errors_edit_education_completed_date"></span> 
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="degree">Select Degree</label>
                                        <select name='degree' id="edit_employee_degree"class="form-control degree">
                                            <option value="">Select Degree</option>
                                            @foreach($allDegree as $degree)
                                            <option value="{{$degree->degree_name}}">{{$degree->degree_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Grade</label>
                                        <input type="text" name='grade' id="edit_grade" class="form-control" placeholder="Enter Grade" />
                                    </div>
                                </div> 
                                
                                <div class="form-group">
				                                        <input type="file" name='document' id="img" title="Upload Documents"

					style="display: none;" > <span id="education_document"></span>
					@if(! empty($degree->document))
					<a  href="" target="_blank" id="edit_upload_document"><img src="/images/pdfIcon.svg" /> <small></small></a>
					@endif
					<label for="img" class="btn btn-default"><i
					class="fa-solid fa-upload"></i> Upload Document</label><br />
					<span class="text-danger error" id="errorseducation_document"></span>
				<br />
				
			</div>
                                
				<div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="edit_notes_education_information" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary modalcanceleffect"
									data-bs-dismiss="modal">Cancel</button>
								<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
<div class="modal fade commonModalNew" id="employeeskill" tabindex="-1" aria-labelledby="employeeskillLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="employeeskillLabel">Add Skill</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="addEmployeeSkill">
					@csrf
                   <input type="hidden" name="user_id"  id="user_id" value="{{$userData->_id}}">
					<div class="col-lg-12">
                            <div class="form-group">
                                <label>Skill</label>
                                <input type="text" id="employee_skill" class="form-control" value="" name="employee_skill">
                                     <span class="text-danger error" id="errorsskill_employee_skill"></span> 
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="add_notes_skill" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>


<div class="modal fade" id="statutoryInfo" tabindex="-1" aria-labelledby="statutoryInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="statutoryInfoLabel">Bank & Statutory Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="addbankstatutory">
					@csrf
					<input type="hidden" name="id" id="edit_skills_id" value="" /> 
                   <input type="hidden" name="user_id"  id="user_id" value="{{$userData->_id}}">
                   <div class="row">
                                                       <label><b>ESI Account</b></label>
                   
					   <div class="col-lg-6">
                                <div class="form-group">
                                    <label>ESI Number</label>
                                    <input type="number" name="esi_number" value="" class="form-control" placeholder="Enter ESI Number" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Branch Office</label>
                                    <input type="text" name="branch_office" value="" class="form-control" placeholder="Enter Branch Office" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Dispensary</label>
                                    <input type="text" name="dispensary" value="" class="form-control" placeholder="Enter dispensary" />

                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" name="previous_employment" id="flexCheckDefault1">
                                    <label class="form-check-label" for="flexCheckDefault1">
                                        In case of any previous employment please fill up the details as under.
                                    </label>
                                  </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Previous Ins. No.</label>
                                    <input type="text" name="previousInsNo" value="" class="form-control" placeholder="Previous Ins. No." />

                                </div>
                            </div>  
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Employer's Code No.</label>
                                    <input type="text" name="employerCode" value="" class="form-control" placeholder="Employer's Code No." />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name & Address of the Employer</label>
                                    <input type="text" name="nameAddress"  class="form-control" placeholder="Name & Address of the Employer" />

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="employerEmail" class="form-control" placeholder="Enter Email" />

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" name="nominee_detail"  id="flexCheckDefault2">
                                    <label class="form-check-label" for="flexCheckDefault2">
                                        Details of Nominee u/s 71 of ESI Act 1948/Rule-56(2) of ESI (Central) Rules, 1950 for payment of cash benefit in the event of death
                                    </label>
                                  </div>
                            </div>
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="nomineeName" value="" class="form-control" placeholder="Enter Name" />
                                </div>
                            </div>  
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Relationship</label>
                                    <input type="text" name="nomineeRelationship" value="" class="form-control" placeholder="Enter Relationship" />
                                </div>
                            </div>  
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="nomineeAddress" value="{{ @$userData['statutoryInfo']['email'] }}" class="form-control" placeholder="Enter Address" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" name="family_particular" id="flexCheckDefault3">
                                    <label class="form-check-label" for="flexCheckDefault3">Family Particulars of Insured person</label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="particularName" value="" class="form-control" placeholder="Enter Address" />
                                            </div>
                                        </div>  
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input type="date" name="particularDateofbirth" value="" class="form-control" placeholder="Enter Address" />
                                            </div>
                                        </div>  
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Relationship</label>
                                                <input type="text" name="particularRelationship" value="" class="form-control" placeholder="Enter Address" />
                                            </div>
                                        </div>
                                    </div>
                                    <p class="">Whether residing with him/her</p>
                                    <div class="d-flex">
                                        <div class="form-check me-2">
                                            <input class="form-check-input" type="radio" value="1" name="residing" name="residing"  >
                                                <label class="form-check-label" for="flexRadioDefault10">Yes</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="0" name="residing" name="residing" >
                                            <label class="form-check-label" for="flexRadioDefault1">No</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label>Place of Residance</label>
                                        <select name="residancePlace" class="form-control">
                                        <option value="town">Town</option>
                                        <option value="state" selected>State</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" name="pf" id="flexCheckDefault" >
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Employee is covered under PF
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>UAN</label>
                                    <input type="number" name="uan" value="" class="form-control" placeholder="Enter UAN" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>PF Number</label>
                                    <input type="text" name="pf_number" value="" class="form-control" placeholder="Enter PF Number" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>PF Join Date</label>
                                    <input type="date" name="pf_joinDate" class="form-control" placeholder="Enter Join Date" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Whether earlier a member of Employees provident Fund Scheme 1952?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-2">
                                            <input class="form-check-input" name="pf_scheme" value="1" type="radio" name="pf_scheme" id="flexRadioDefault2" >
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Yes
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" name="pf_scheme"  value="0" type="radio" name="pf_scheme"  id="flexRadioDefault3"  >
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
                                          
                                            <input class="form-check-input" name="pension_scheme" value="1" type="radio" name="pension_scheme"  id="flexRadioDefault4">
                                            <label class="form-check-label" for="flexRadioDefault4">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="pension_scheme" value="0" type="radio" name="pension_scheme"  id="flexRadioDefault5" >
                                            <label class="form-check-label" for="flexRadioDefault5">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mt-4">
                                    <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                                </div>
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

<div class="modal fade" id="editemployeeskill" tabindex="-1" aria-labelledby="editemployeeskillLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="editemployeeskillLabel">Edit Skill</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="updateEmployeeSkill">
					@csrf
					<input type="hidden" name="id" id="edit_employee_skills" value="" /> 
                   <input type="hidden" name="user_id"  id="user_id" value="{{$userData->_id}}">
					<div class="col-lg-12">
                            <div class="form-group">
                                <label>Skill</label>
                                <input type="text" id="edit_employee_skill" class="form-control" value="" name="employee_skill">
                                     <span class="text-danger error" id="errorseditskill_employee_skill"></span> 
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="edit_notes_skill" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"  ></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
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



<div class="modal fade" id="bankInfo" tabindex="-1" aria-labelledby="bankInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="bankInfoLabel">Bank Information</h1>
        <button type="button" class="btn-close roundedclose" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="updatedBankInfo">
					@csrf
                   <input type="hidden" name="user_id"  id="user_id" value="{{$userData->_id}}">
					<div class="row">
					
					 <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Name as per Bank Records <span class="text-red">*</span></label>
                                    <input name="username" type="text" class="form-control" placeholder="Enter Name" id="bank_username"/>
                                   <span class="text-danger error" id="edit_bank_username"></span> 
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="bankName">Bank Name <span class="text-red">*</span></label>
                                    <input name="bank_name" type="text" class="form-control" placeholder="Enter Bank Name" id="edit_bank_name"/>
                                   <span class="text-danger error" id="edit_bank_bank_name"></span> 
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="account">Bank Account No. <span class="text-red">*</span></label>
                                    <input name="account" type="number" class="form-control" placeholder="Enter Account No." id="bank_account" />
                                     <span class="text-danger error" id="edit_bank_account"></span> 
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="ifsc">IFSC Code <span class="text-red">*</span></label>
                                    <input name="ifsc" type="text" class="form-control" placeholder="Enter IFSC Code" id="edit_ifsc_code"/>
                                       <span class="text-danger error" id="edit_bank_ifsc"></span> 
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="pan">PAN No. <span class="text-red">*</span></label>
                                    <input name="pan" type="text" class="form-control" placeholder="Enter PAN No." id="edit_pan" />
                                <span class="text-danger error" id="edit_bank_pan"></span> 
                                </div>
                            </div>
                            <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="edit_notes_bank" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"  ></textarea>
                            </div>
                           <span class="text-danger error" id="edit_bank_user_role"></span> 
                        </div>
					
					
					</div>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>




<div class="modal fade" id="additionalInfo" tabindex="-1" aria-labelledby="additionalInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="additionalInfoLabel">Additional Information</h1>
        <button type="button" class="btn-close roundedclose" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="updatedAdditionInformation">
					@csrf
                   <input type="hidden" name="user_id"  id="user_id" value="{{$userData->_id}}">
					<div class="row">
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Allergies</label>
                                    <select name="allergies" id="allergies" class="form-control">
                                         <option value="">Select</option> 
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Smoke</label>
                                    <select name="smoke" id="smoke_field" class="form-control">
                                        <option value="">Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Drink</label>
                                    <select name="drink"  id="drink" class="form-control">
                                         <option value="">Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Diet</label>
                                    <select name="diet"  id="diet" class="form-control js-select2">
                                         <option value="">Select</option>
                                        <option value="veg">Veg</option>
                                        <option value="non-veg">Non-Veg</option>
                                    </select>
                                </div>
                            </div>
                            

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Hobbies</label>
                                    <input type="text" name="hobbies" id="hobbies" class="form-control" placeholder="Enter Hobbies" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="edit_addition_info" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"  ></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
                        </div>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>
<div class="modal fade commonModalNew" id="viewReason" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Notes</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     <div>
  		<span class="documentnotes"></span>
	</div>
        </div>
      </div>
    </div>
  </div>



		
	</div>
</div>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>

function documentView(id,userId)
{

  $('#viewReason').modal('show');
  
      $.ajax({
                type: 'post',
                url: "{{ route('documentView')}}",
                data: "id="+id+"&userId="+userId+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('.documentnotes').text(data.notes)
                
                },
            });

}


$(document).ready(function() {
  $("#employeeskill").on("hidden.bs.modal", function() {
  	 $(this).find('form').trigger('reset');
  });
});



$(function(){
  $('#confirmation_check').select2({
    dropdownParent: $('#joiningDetail')
  });
});



 $(function(){
  $('#allergies').select2({
    dropdownParent: $('#additionalInfo')
  });
});

$(function(){
  $('#document_type').select2({
    dropdownParent: $('#documentInfo')
  });
});


 $(function(){
  $('#smoke_field').select2({
    dropdownParent: $('#additionalInfo')
  });
}); 

$(function(){
  $('#drink').select2({
    dropdownParent: $('#additionalInfo')
  });
});

 
$(function(){
  $('#diet').select2({
    dropdownParent: $('#additionalInfo')
  });
});


 $(function(){
  $('#employee_degree').select2({
    dropdownParent: $('#addeducationInformation')
  });
}); 

 $(function(){
  $('#edit_employee_degree').select2({
    dropdownParent: $('#editeducationInformation')
  });
}); 


function editaddition(userId)
{
$('#additionalInfo').modal('show')

 $.ajax({
                type: 'post',
                url: "{{ route('editAdditionData')}}",
                data: "userId="+userId+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#allergies').val(data.allergies).trigger('change')
                $('#smoke_field').val(data.smoke).trigger('change');
                $('#drink').val(data.drink).trigger('change');
                $('#diet').val(data.diet).trigger('change');
                $('#hobbies').val(data.hobbies);
                $('#edit_addition_info').val(data.notes);
                
                },
       });




}

$('#addEmployeeDocument').on('submit', function (event) {
    		event.preventDefault();
    		var formData = new FormData(this);
    		console.log(formData)
  			$.ajax({
                type: 'post',
                url: "{{ route('uploadDocuments')}}",
                data: formData,
                contentType:false,
                processData:false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                console.log(data);
                $('.error').html('');
                if($.isEmptyObject(data.errors)){
                                window.location = "/employee-profile/<?=$userData->_id?>?activetab=document";

                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#errordocument_'+key).html(value)
                	})
                }
            	} 
            });

		});
$('#updatedAdditionInformation').on('submit', function (event) {
    		event.preventDefault();
             var formData = $(this).serialize();
             console.log(formData);
  			$.ajax({
                type: 'post',
                url: "{{ route('updatedAddition')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>?activetab=additionDetails";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#errors_'+key).html(value)
                    	})
                    }
            	} 
                
            });

		});

$('#updatedBankInfo').on('submit', function (event) {
    		event.preventDefault();
             var formData = $(this).serialize();
            console.log(formData);
  			$.ajax({
                type: 'post',
                url: "{{ route('addBankInfo')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>?activetab=accountStatutory";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#edit_bank_'+key).html(value)
                    	})
                    }
            	} 
                
            });

		});

function editSkill(id,userId)
{
$('#editemployeeskill').modal('show');
 $.ajax({
                type: 'post',
                url: "{{ route('editSkills')}}",
                data: "id="+id+"&userId="+userId+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                console.log(data)
                $('#edit_employee_skill').val(data.employee_skill);
                $('#edit_employee_skills').val(data.id);
                $('#edit_notes_skill').text(data.notes);
            
                },
            });
}

$('#addbankstatutory').on('submit', function (event) {
    		event.preventDefault();
             var formData = $(this).serialize();
            console.log(formData);
  			$.ajax({
                type: 'post',
                url: "{{ route('addbankstatutory')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>?activetab=accountStatutory";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#errors_'+key).html(value)
                    	})
                    }
            	} 
                
            });

		});


$('#addEmployeeSkill').on('submit', function (event) {
    		event.preventDefault();
             var formData = $(this).serialize();
            console.log(formData);
  			$.ajax({
                type: 'post',
                url: "{{ route('addSkills')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>?activetab=skill";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#errorsskill_'+key).html(value)
                    	})
                    }
            	} 
                
            });

		});
		
		
$('#updateEmployeeSkill').on('submit', function (event) {
    		event.preventDefault();
             var formData = $(this).serialize();
  			$.ajax({
                type: 'post',
                url: "{{ route('updatedSkills')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>?activetab=skill";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#errorseditskill_'+key).html(value)
                    	})
                    }
            	} 
                
            });
		});
		
		$('.deleteSkill').click(function(){
		 var id = $(this).data("id");
		 $.ajax({
                type: 'post',
                url: "{{ route('skillDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	window.location = "/employee-profile/<?=$userData->_id?>?activetab=skill";
                 
                },
            });
		})
		

$('#addemergencyContact').on('submit', function (event) {
    		event.preventDefault();
             var formData = $(this).serialize();
            console.log(formData);
  			$.ajax({
                type: 'post',
                url: "{{ route('addEmergency')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>?activetab=personal";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#error_'+key).html(value)
                    	})
                    }
            	} 
                
            });

		});

function editEmergency(id,userId)
{
 $('#editEmergencycontact').modal('show')
 
  $.ajax({
                type: 'post',
                url: "{{ route('editEmergency')}}",
                data: "id="+id+"&userId="+userId+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#edit_name').val(data.name)
                $('#edit_relationship').val(data.relationship)
                $('#edit_phone_no').val(data.phone)
                $('#edit_phone_no2').val(data.phone_two)
                $('#edit_email').val(data.email)
                $('#edit_notes_emergency').text(data.notes)
                $('#edit_id').val(data.id)
                },
            });
 
}



$('#updateemergencyContact').on('submit', function (event) {
    		event.preventDefault();
             var formData = $(this).serialize();
  			$.ajax({
                type: 'post',
                url: "{{ route('updateEmergency')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>?activetab=personal";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#error_'+key).html(value)
                    	})
                    }
            	} 
                
            });

		});
		
		$('.deleteContact').click(function(){
		 var id = $(this).data("id");
		 $.ajax({
                type: 'post',
                url: "{{ route('contactDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
		})
function updateJoining(userId)
{
$('#joiningDetail').modal('show')
$('.error').html('');


 $.ajax({
                type: 'post',
                url: "{{ route('editJoining')}}",
                data: "userId="+userId+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#confirmation_check').val(data.confirmation_check).trigger('change')
                $('#notice_period').val(data.notice_period);
                $('#probation_period').val(data.probation_period);
                $('#other_terms').val(data.other_terms);
                $('#edit_notes_joining').text(data.notes);
                },
       });
}
		
		
$('#addjoiningDetails').on('submit', function (event) {
    		event.preventDefault();
             var formData = $(this).serialize();
            console.log(formData);
  			$.ajax({
                type: 'post',
                url: "{{ route('addJoining')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>?activetab=personal";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#errorjoining_'+key).html(value)
                    	})
                    }
            	} 
                
            });

		});
		
function editOfficialContact(userId)
{
$('#officialContact').modal('show')
   $.ajax({
                type: 'post',
                url: "{{ route('editOfficialContact')}}",
                data: "userId="+userId+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#discord_username').val(data.discord_username);
                $('#redmine_username').val(data.redmine_username);
                $('#skype_id').val(data.skype_id);
                $('#edit_notes_official_contact').text(data.notes);
                },
       });

}


		
$('#addOfficialContact').on('submit', function (event) {
    		event.preventDefault();
            var formData = $(this).serialize();
  			$.ajax({
                type: 'post',
                url: "{{ route('addOfficialcontact')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>?activetab=personal";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#error_'+key).html(value)
                    	})
                    }
            	} 
                
            });

		});

$('#addFamily').on('submit', function (event) {
    		event.preventDefault();
            var formData = $(this).serialize();
  			$.ajax({
                type: 'post',
                url: "{{ route('addFamilyInformation')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>?activetab=personal";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#errors_'+key).html(value)
                    	})
                    }
            	} 
                
            });

		});
function editFamily(id,userId)
{
$('#editFamilyInformation').modal('show')
  $.ajax({
                type: 'post',
                url: "{{ route('editFamily')}}",
                data: "id="+id+"&userId="+userId+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#edit_family_name').val(data.name)
                $('#edit_family_relation').val(data.relationship)
                $('#edit_family_phone').val(data.phone)
                $('#edit_family_address').val(data.address)
                $('#edit_family_date_birth').val(data.date_of_birth)
                $('#edit_family_id').val(data.id)
                $('#edit_notes_family').text(data.notes)
                },
            });
 
}
$('#updatedFamily').on('submit', function (event) {
    		event.preventDefault();
             var formData = $(this).serialize();
  			$.ajax({
                type: 'post',
                url: "{{ route('updateFamilyInformation')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>?activetab=personal";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#errorfamily_'+key).html(value)
                    	})
                    }
            	} 
                
            });

		});
	$('.deleteFamily').click(function(){
		 var id = $(this).data("id");
		 $.ajax({
                type: 'post',
                url: "{{ route('familyDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
		})
		
		
		$('#addEducation').on('submit', function (event) {
    		event.preventDefault();
    		var formData = new FormData(this);
  			$.ajax({
                type: 'post',
                url: "{{ route('addEducationDetails')}}",
                data: formData,
                contentType:false,
                processData:false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
                if($.isEmptyObject(data.errors)){
                	window.location = "/employee-profile/<?=$userData->_id?>?activetab=personal";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#errorseducation_'+key).html(value)
                	})
                }
            	} 
                
            });

		});
$('.deleteExperience').click(function(){
		 var id = $(this).data("id");
		 $.ajax({
                type: 'post',
                url: "{{ route('deleteExperience')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });

})

function updateBankInfo(userId)
{
$('#bankInfo').modal('show')
  $.ajax({
                type: 'post',
                url: "{{ route('editBankInfo')}}",
                data: "userId="+userId+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#bank_username').val(data.username)
                $('#edit_bank_name').val(data.bank_name)
                $('#bank_account').val(data.account)
                $('#edit_ifsc_code').val(data.ifsc);
                $('#edit_pan').val(data.pan);
                $('#edit_notes_bank').text(data.notes)
                },
            });
}

	img.onchange = evt => {
      	const [file] = img.files
      	if (file) {
      	$('#education_document').text(file.name);
        blah.src = URL.createObjectURL(file)
      	}
  	}
  	
  		edit_all_document.onchange = evt => {
      	const [file] = edit_all_document.files
      	if (file) {
      	$('#all_document').text(file.name);
        blah.src = URL.createObjectURL(file)
      	}
  	}
  	
  	
  	
function editEducation(id,userId)
{
 $('#editeducationInformation').modal('show')
 $('#edit_education_id').val(id)
 
  $.ajax({
                type: 'post',
                url: "{{ route('editEmployeeEducation')}}",
                data: "id="+id+"&userId="+userId+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                console.log(data)
                $('#edit_education').val(data.institute)
                $('#edit_starting_date').val(data.starting_date)
                $('#edit_completed_date').val(data.completed_date)
                $('#edit_employee_degree').val(data.degree).trigger('change')
                $('#edit_grade').val(data.grade)
                $('#edit_upload_document').attr("href",data.document)
                $('#edit_notes_education_information').val(data.notes)
             
                },
            });
 
}
	$('#updatedEducation').on('submit', function (event) {
    		event.preventDefault();
    		var formData = new FormData(this);
  			$.ajax({
                type: 'post',
                url: "{{ route('updateEducationDetails')}}",
                data: formData,
                contentType:false,
                processData:false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
                if($.isEmptyObject(data.errors)){
                	window.location = "/employee-profile/<?=$userData->_id?>?activetab=personal";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#errorseducation_'+key).html(value)
                	})
                }
            	} 
                
            });

		});

	$('.deleteEducation').click(function(){
		 var id = $(this).data("id");
		 $.ajax({
                type: 'post',
                url: "{{ route('educationDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	window.location = "/employee-profile/<?=$userData->_id?>?activetab=personal";
                 
                },
            });
		})
		
		
		$('.deleteDocument').click(function(){
		 var id = $(this).data("id");
		 console.log(id)
		 $.ajax({
                type: 'post',
                url: "{{ route('deleteDocument')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	window.location = "/employee-profile/<?=$userData->_id?>?activetab=document";
                 
                },
            });
		})
		
		function editDocument(id,userId)
		{
		 $('#editdocumentInfo').modal('show')
 		 $('#edit_document_id').val(id)
 		 $.ajax({
 			   type: 'post',
                url: "{{ route('editEmployeeDocument')}}",
                data: {id:id,userId:userId},
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                console.log(data)
                  var data = JSON.parse(data)
                  $('#edit_document').val(data.name)
                  $('#edit_document_type').val(data.type)
                  $('#edit_documents').attr("href",data.document)
                  $("#edit_notes_document").val(data.notes)
               
                }
 			
 		   });
         
		}
			$('#updatedEmployeeDocument').on('submit', function (event) {
    		event.preventDefault();
    		var formData = new FormData(this);
    		
  			$.ajax({
                type: 'post',
                url: "{{ route('updatedDocuments')}}",
                data: formData,
                contentType:false,
                processData:false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
                if($.isEmptyObject(data.errors)){
                window.location = "/employee-profile/<?=$userData->_id?>?activetab=document";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#errorseducation_'+key).html(value)
                	})
                }
            	} 
                
            });

		});
		
		setTimeout(function() {
	$('#success').hide();
 }, 3000);

setTimeout(function() {
	$('#danger').hide();
 }, 3000);
		
</script> </x-admin-layout>