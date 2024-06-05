<?php
use Illuminate\Support\Facades\Session;
?>
<x-admin-layout>
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
								<h6 class="mb-1">{{@$userData['first_name']}}&nbsp;
									{{@$userData['last_name']}}</h6>
								<small>{{@$userData->getdepartment()->title}}</small>
								<p class="mb-1">{{@$userData->getdesignation()->title}}</p>
								<p>
									Employee ID:<span>{{@$userData['employee_id']}}</span>
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
										<b>{{@$userData['email']}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-5 col-md-5">
									<p>Birth Date:</p>
								</div>

								<div class="col-lg-7 col-md-7">
									<p>
										<b>{{@$userData['date_of_birth']}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-5 col-md-5">
									<p>Joining Date:</p>
								</div>
								<div class="col-lg-7 col-md-7">
									<p>
										<b>{{@$userData['joining_date']}}</b>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-5 col-md-5">
									<p>Phone:</p>
								</div>
								<div class="col-lg-7 col-md-7">
									<p>
										<b>{{@$userData['contact']}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-5 col-md-5">
									<p>Reporting Manager:</p>
								</div>

								<div class="col-lg-7 col-md-7">
									<p>
										<b>{{@$userData->getReportingmanager()}}</b>
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
										<strong>{{(@$userData->app_login==1)?'No':'Yes'}}</strong>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Can this user receive email notification?</p>
								</div>
								<div class="col-lg-6 col-md-6">
									<p>
										<strong>{{(@$userData->email_notification==1)?'No':'Yes'}}</strong>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Workplace:</p>
								</div>

								<div class="col-lg-6 col-md-6">
									<p>
										<strong>{{(@$userData->workplace==1)?'WFO':'WFH'}}</strong>
									</p>

								</div>
							</div>

						</div>
					</div>
					@if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2,'personal_information')))
					<div class="col-xl-1 col-lg-1 col-md-1">
						<div class="editProfile text-end">
							<a href="/employee/update/{{$userData->_id}}"><img
								src="/images/editIcon.svg" /></a>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
		<div class="dashboardSection__body commonBoxShadow rounded-1 mt-5">
			<ul class="nav nav-pills commonTabs" id="pills-tab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="pills-personal-tab"
						data-bs-toggle="pill" data-bs-target="#pills-personal"
						type="button" role="tab" aria-controls="pills-personal"
						aria-selected="true">Personal</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-account-tab"
						data-bs-toggle="pill" data-bs-target="#pills-account"
						type="button" role="tab" aria-controls="pills-account"
						aria-selected="false">Accounts & Statutory</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-employment-tab"
						data-bs-toggle="pill" data-bs-target="#pills-employment"
						type="button" role="tab" aria-controls="pills-employment"
						aria-selected="false">Employment & Job</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-additional-tab"
						data-bs-toggle="pill" data-bs-target="#pills-additional"
						type="button" role="tab" aria-controls="pills-additional"
						aria-selected="false">Additional Details</button>
				</li>

				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-payroll-tab"
						data-bs-toggle="pill" data-bs-target="#pills-payroll"
						type="button" role="tab" aria-controls="pills-payroll"
						aria-selected="false">Payroll</button>
				</li>

				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-documents-tab"
						data-bs-toggle="pill" data-bs-target="#pills-documents"
						type="button" role="tab" aria-controls="pills-documents"
						aria-selected="false">Documents</button>
				</li>

				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-attendance-tab"
						data-bs-toggle="pill" data-bs-target="#pills-attendance"
						type="button" role="tab" aria-controls="pills-attendance"
						aria-selected="false">Attendance</button>
				</li>

				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-leaves-tab"
						data-bs-toggle="pill" data-bs-target="#pills-leaves" type="button"
						role="tab" aria-controls="pills-leaves" aria-selected="false">Leaves</button>
				</li>
			</ul>
		</div>

		<div class="tab-content mt-5" id="pills-tabContent">
			<!-- personal tab starts -->
			<div class="tab-pane fade show active" id="pills-personal"
				role="tabpanel" aria-labelledby="pills-personal-tab" tabindex="0">
				<div class="row">
					<div class="col-lg-6">
						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							<a class="editIcon" href="{{url('personal-information/'.$userData['_id'])}}"><i
								class="fa-solid fa-pen"></i> </a>
							<h3>Personal Information</h3>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Gender:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{ucwords(@$userData['gender'])}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Whatsapp:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{@$userData['whatsapp']}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Personal Email:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{@$userData['email']}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Current Address:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{@$userData['address']['current_address']}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Permanent Address:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{@$userData['address']['permanent_address']}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Nationality:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{@$userData['nationality']}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Religion:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{@$userData['religion']}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Blood Group:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{@$userData['blood_group']}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Marital Status:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{ucwords(@$userData['marital_status'])}}</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Employment of spouse:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{@ucfirst($userData['spouse_employment'])}}</b>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>No. of Children:</p>
								</div>
								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{@$userData['children']}}</b>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Passport No:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{@$userData['passport_number']}}</b>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Passport Expiry Date:</p>
								</div>
								<div class="col-lg-8 col-md-8">
									<p>
										<b>{{@$userData['passport_expiry_date'] != ''?date('d M Y',
											(int)$userData['passport_expiry_date']):''}}</b>
									</p>
								</div>
							</div>
						</div>

						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							
							<h3>Emergency Contactsss</h3>

							<p class="green">Primary Contact <a class="editIcon" data-bs-toggle="modal" style="top:0px"
								data-bs-target="#contactInfo" href="javascript:void(0);"><i
								class="fa-solid fa-pen"></i> </a></p>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>
										Name<span class="red">*</span>:
									</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>David Johns</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>
										Relationship<span class="red">*</span>:
									
									
									<p>
								
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>Dad</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>
										Phone<span class="red">*</span>:
									
									
									<p>
								
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>9876543220</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>
										Phone No. 2<span class="red">*</span>:
									
									
									<p>
								
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>9876543230</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Email:
									
									
									<p>
								
								</div>
								<div class="col-lg-8 col-md-8">
									<p>
										<b>Johndavid@gmail.com</b>
									</p>
								</div>
							</div>
							<hr />
							<p class="green">Secondary Contact <a class="editIcon" data-bs-toggle="modal" style="top:0px"
								data-bs-target="#contactInfo" href="javascript:void(0);"><i
								class="fa-solid fa-pen"></i> </a></p>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>
										Name<span class="red">*</span>:
									</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>David Johns</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>
										Relationship<span class="red">*</span>:
									
									
									<p>
								
								</div>
								<div class="col-lg-8 col-md-8">
									<p>
										<b>Dad</b>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>
										Phone<span class="red">*</span>:
									
									
									<p>
								
								</div>
								<div class="col-lg-8 col-md-8">
									<p>
										<b>9876543220</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>
										Phone No. 2<span class="red">*</span>:
									
									
									<p>
								
								</div>
								<div class="col-lg-8 col-md-8">
									<p>
										<b>9876543230</b>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Email:
									
									
									<p>
								
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>Johndavid@gmail.com</b>
									</p>
								</div>
							</div>


						</div>
					</div>
					<div class="col-lg-6">
						<div class="profileCard commonBoxShadow rounded-1  mb-3">
							<a class="editIcon" data-bs-toggle="modal"
								data-bs-target="#joiningDetail" href="javascript:void(0);"> <img
								src="/images/editIcon.svg" />
							</a>
							<h3>Joining Details</h3>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Confirmation Date:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>12 May 2016</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Notice Period:
									
									
									<p>
								
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>1 Months</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Probation Period:
									
									
									<p>
								
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>6 Months</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Other Terms:
									
									
									<p>
								
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>Lorem Ipsum is simply dummy text of the printing and
											typesetting industry. </b>
									</p>
								</div>
							</div>
						</div>

						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							<a class="editIcon" data-bs-toggle="modal"
								data-bs-target="#officialContact" href="javascript:void(0);"> <img
								src="images/editIcon.svg" />
							</a>
							<h3>Official Contact Information</h3>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Redmine Username:</p>
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>Alex.john</b>
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
										<b>AlexJohn#6230</b>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Skype ID:
									
									
									<p>
								
								</div>

								<div class="col-lg-8 col-md-8">
									<p>
										<b>Alexjohn.upwork@gmail.com</b>
									</p>
								</div>
							</div>

						</div>

						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							<a class="editIcon" data-bs-toggle="modal"
								data-bs-target="#familyInfo" href="javascript:void(0);"> <img
								src="images/editIcon.svg" />
							</a>
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
									<tr>
										<td data-label="Name">David Johns</td>
										<td data-label="Relationship">Dad</td>
										<td data-label="Date of Birth">02 February 1956</td>
										<td data-label="Phone">9876543230</td>
										<td data-label="Address">1861 Bayonne Ave, Manchester
											Township, NJ, 08759</td>
										<td data-label="Action">
											<div class="dropdown">
												<a class="btn btn-secondary dropdown-toggle"
													href="javascript:void(0);" role="button"
													data-bs-toggle="dropdown" aria-expanded="false"> <i
													class="fa-solid fa-ellipsis-vertical"></i>
												</a>
												<ul class="dropdown-menu">
													<li><a class="dropdown-item" href="javascript:void(0);">Edit</a></li>
													<li><a class="dropdown-item" href="javascript:void(0);">Delete</a></li>
												</ul>
											</div>
										</td>
									</tr>
								</table>
							</div>
							<a class="addBtn" href="javascript:void(0);">Add New <img
								src="images/addIcon.svg" /></a>
						</div>

						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							<a class="editIcon" data-bs-toggle="modal"
								data-bs-target="#eduInfo" href="javascript:void(0);"> <img
								src="images/editIcon.svg" />
							</a>
							<h3>Education Information</h3>

							<ul class="eduList">
								<li>
									<p>
										<b>International College of Arts and Science (UG)</b>
									</p>
									<p>Bsc Computer Science</p>
									<p>22 April 2013 - 22 April 2014 . A+</p> <a
									href="javascript:void(0);"><img src="images/pdfIcon.svg" /> <small>Institute
											Degree.pdf</small></a>
								</li>

								<li>
									<p>
										<b>International College of Arts and Science (UG)</b>
									</p>
									<p>Bsc Computer Science</p>
									<p>22 April 2013 - 22 April 2014 . A+</p> <a
									href="javascript:void(0);"><img src="images/pdfIcon.svg" /> <small>Institute
											Degree.pdf</small></a>
								</li>
							</ul>
							<a class="addBtn mt-4" href="javascript:void(0);">Add New <img
								src="images/addIcon.svg" /></a>

						</div>
					</div>
				</div>
			</div>
			<!-- personal ends -->

			<!-- account tab starts -->
			<div class="tab-pane fade" id="pills-account" role="tabpanel"
				aria-labelledby="pills-account-tab" tabindex="0">
				<div class="row">
					<div class="col-lg-6">
						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							<a class="editIcon" data-bs-toggle="modal"
								data-bs-target="#bankInfo" href="javascript:void(0);"> <img
								src="images/editIcon.svg" />
							</a>
							<h3>Bank Information</h3>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Name as per Bank Records:</p>
								</div>

								<div class="col-lg-6 col-md-6">
									<p class="green">
										<strong>Neha Guleria</strong>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Bank Name:</p>
								</div>

								<div class="col-lg-6 col-md-6">
									<p class="green">
										<strong>ICICI Bank</strong>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Bank Account No:</p>
								</div>

								<div class="col-lg-6 col-md-6">
									<p class="">
										<strong>12 May 1990</strong>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>IFSC Code:</p>
								</div>

								<div class="col-lg-6 col-md-6">
									<p class="">
										<strong>ICI24504</strong>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>PAN No:</p>
								</div>

								<div class="col-lg-6 col-md-6">
									<p class="">
										<strong>TC000Y56</strong>
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							<a class="editIcon" data-bs-toggle="modal"
								data-bs-target="#statutoryInfo" href="javascript:void(0);"> <img
								src="images/editIcon.svg" />
							</a>
							<h3>Bank & Statutory</h3>
							<p class="green">
								<strong>ESI Account:</strong>
							</p>

							<div class="mb-3 form-check">
								<input type="checkbox" class="form-check-input"
									id="exampleCheck1"> <label class="form-check-label"
									for="exampleCheck1">Employee is covered under ESI</label>
							</div>

							<p class="warning">
								<span><img src="images/warningIcon.svg" /> Not covered under
									ESI.</span>
							</p>

							<p class="green mt-5">
								<strong>PF Account:</strong>
							</p>
							<div class="mb-3 form-check">
								<input type="checkbox" class="form-check-input"
									id="exampleCheck1"> <label class="form-check-label"
									for="exampleCheck1">Employee is covered under PF</label>
							</div>

							<p>
								<small><strong>PF KYC Not Done !</strong></small>
							</p>
							<p class="not-verify mt-3">
								<span>No verified employee identify found.</span>
							</p>

							<p class="warning mt-3">
								<span><img src="images/warningIcon.svg" /> Not covered under PF.</span>
							</p>
						</div>
					</div>
				</div>
			</div>
			<!-- account tab ends -->

			<!-- employeement tab starts -->
			<div class="tab-pane fade" id="pills-employment" role="tabpanel"
				aria-labelledby="pills-employment-tab" tabindex="0">
				<div class="row">
					<div class="col-lg-6">
						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							<a class="editIcon" href="javascript:void(0);"> <img
								src="images/editIcon.svg">
							</a>
							<h3>Experience Information</h3>

							<ul class="eduList">
								<li>
									<p>
										<b>Ui Designer at Softuvo Solutions</b>
									</p>
									<p>
										<b>20 April 2017 - Present (6 years 9 months) . 8 Lac per
											annum</b>
									</p>
									<p>D-199, Phase 8B, Industrial Area, Sector 74, Sahibzada Ajit
										Singh Nagar, Punjab 160055</p>
									<p>Shanky Gupta (Manager) . 0172 467 0301 . info@softuvo.com</p>
								</li>

								<li>
									<p>
										<b>Ui Designer at Zen Corporation</b>
									</p>
									<p>
										<b>15 April 2013 - 15 April 2017 (5 years 9 months) . 4 Lac
											per annum</b>
									</p>
									<p>Ui designing, Ux, Interaction Design, Visula Design, Mobile
										and web App designs</p>
									<p>D-199, Phase 8B, Industrial Area, Sector 74, Sahibzada Ajit
										Singh Nagar, Punjab 160055</p>
									<p>Shanky Gupta (Manager) . 0172 467 0301 . info@softuvo.com</p>
								</li>

								<li>
									<p>
										<b>Ui Designer at Dalt Technology</b>
									</p>
									<p>
										<b>01 January 2013 - 15 April 2013 (4 months) . 2 Lac per
											annum</b>
									</p>
									<p>Ui designing, Ux, Interaction Design, Visula Design, Mobile
										and web App designs</p>
									<p>D-199, Phase 8B, Industrial Area, Sector 74, Sahibzada Ajit
										Singh Nagar, Punjab 160055</p>
									<p>Shanky Gupta (Manager) . 0172 467 0301 . info@softuvo.com</p>
								</li>
							</ul>

							<a class="addBtn" href="javascript:void(0);">Add New <img
								src="images/addIcon.svg"></a>
						</div>
					</div>
				</div>

			</div>
			<!-- employeement tab ends -->

			<!-- additionalm information starts -->
			<div class="tab-pane fade" id="pills-additional" role="tabpanel"
				aria-labelledby="pills-additional-tab" tabindex="0">
				<div class="row">
					<div class="col-lg-5">
						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							<a class="editIcon" data-bs-toggle="modal"
								data-bs-target="#additionalInfo" href="javascript:void(0);"> <img
								src="images/editIcon.svg">
							</a>
							<h3>Additional Details</h3>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Allergies:</p>
								</div>
								<div class="col-lg-6 col-md-6">
									<p>
										<strong>No</strong>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Smoke:</p>
								</div>
								<div class="col-lg-6 col-md-6">
									<p>
										<strong>Yes</strong>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Drink:</p>
								</div>
								<div class="col-lg-6 col-md-6">
									<p>
										<strong>No</strong>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Diet:</p>
								</div>
								<div class="col-lg-6 col-md-6">
									<p>
										<strong>Non-Veg</strong>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<p>Hobbies:</p>
								</div>
								<div class="col-lg-6 col-md-6">
									<p>
										<strong>Playing Badminton</strong>
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
								src="images/editIcon.svg">
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
			<div class="tab-pane fade" id="pills-documents" role="tabpanel"
				aria-labelledby="pills-documents-tab" tabindex="0">
				<div class="row">
					<div class="col-lg-5">
						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							<a class="editIcon" data-bs-toggle="modal"
								data-bs-target="#documentInfo" href="javascript:void(0);"> <img
								src="images/editIcon.svg">
							</a>
							<h3>Documents</h3>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Dosument Name:</p>
								</div>
								<div class="col-lg-8 col-md-8">
									<p>
										<strong><img src="images/pdfIcon.svg" /> Institute Degree.pdf</strong>
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<p>Document Type:</p>
								</div>
								<div class="col-lg-8 col-md-8">
									<p class="green">
										<strong>.PDF File</strong>
									</p>
								</div>
							</div>

							<a class="addBtn mt-5" data-bs-toggle="modal"
								data-bs-target="#documentInfo" href="javascript:void(0);">Add
								New <img src="images/addIcon.svg">
							</a>
						</div>
					</div>
				</div>
			</div>
			<!-- document tab ends -->

			<!-- attendance tab starts -->
			<div class="tab-pane fade" id="pills-attendance" role="tabpanel"
				aria-labelledby="pills-attendance-tab" tabindex="0">
				<div class="profileCard commonBoxShadow rounded-1 mb-3">
					<a class="editIcon" data-bs-toggle="modal"
						data-bs-target="#leavesInfo" href="javascript:void(0);"> <img
						src="images/editIcon.svg">
					</a>
					<h3>Attendance</h3>

					<div class="pageFilter mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="leftFilters">
									<div class="form-floating">
										<select class="form-select" id="floatingSelect"
											aria-label="Floating label select example">
											<option selected="">All</option>
											<option value="1">All</option>
											<option value="2">All</option>
											<option value="3">All</option>
										</select> <label for="floatingSelect">Employee</label>
									</div>

									<div class="form-floating">
										<select class="form-select" id="floatingSelect"
											aria-label="Floating label select example">
											<option selected="">All</option>
											<option value="1">All</option>
											<option value="2">All</option>
											<option value="3">All</option>
										</select> <label for="floatingSelect">Department</label>
									</div>

									<div class="form-floating">
										<select class="form-select" id="floatingSelect"
											aria-label="Floating label select example">
											<option selected="">January</option>
											<option value="1">February</option>
											<option value="2">March</option>
											<option value="3">April</option>
										</select> <label for="floatingSelect">Month</label>
									</div>

									<div class="form-floating">
										<select class="form-select" id="floatingSelect"
											aria-label="Floating label select example">
											<option selected="">2023</option>
											<option value="1">2022</option>
											<option value="2">2021</option>
											<option value="3">2020</option>
										</select> <label for="floatingSelect">Year</label>
									</div>

									<button class="btn btn-search">
										<img src="images/iconSearch.svg" /> Search here
									</button>
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
									<tr>
										<td>1</td>
										<td>01 Jan 2016</td>
										<td>10 AM</td>
										<td>7 PM</td>
										<td>9 hrs</td>
										<td>1 hrs</td>
										<td>0</td>
									</tr>

									<tr>
										<td>2</td>
										<td>01 Jan 2016</td>
										<td>10 AM</td>
										<td>7 PM</td>
										<td>9 hrs</td>
										<td>1 hrs</td>
										<td>0</td>
									</tr>

									<tr>
										<td>3</td>
										<td>01 Jan 2016</td>
										<td>10 AM</td>
										<td>7 PM</td>
										<td>9 hrs</td>
										<td>1 hrs</td>
										<td>0</td>
									</tr>

									<tr>
										<td>4</td>
										<td>01 Jan 2016</td>
										<td>10 AM</td>
										<td>7 PM</td>
										<td>9 hrs</td>
										<td>1 hrs</td>
										<td>0</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="commonPagination my-2">
						<div class="row">
							<div class="col-lg-12">
								<div class="commonPagination__content justify-content-end">
									<p class="mb-0">
										Showing <span>1 to 10</span> of <span>16 entries</span>
									</p>
									<div class="paginationButton">
										<a href="javascript:void(0);">Previous</a> <a
											href="javascript:void(0);">1</a> <a
											href="javascript:void(0);">2</a> <a
											href="javascript:void(0);">Next</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- attendance tab ends -->

			<!-- Leaves tabs starts -->
			<div class="tab-pane fade" id="pills-leaves" role="tabpanel"
				aria-labelledby="pills-leaves-tab" tabindex="0">
				<div class="profileCard commonBoxShadow rounded-1 mb-3">
					<a class="editIcon"> <img src="images/editIcon.svg">
					</a>

					<h3>Leaves</h3>
					<div class="row">
						<div class="col-lg-3 col-md-3 col-6">
							<div class="leaveCard">
								<h4>20</h4>
								<p>Annual Leave</p>
							</div>
						</div>

						<div class="col-lg-3 col-md-3 col-6">
							<div class="leaveCard">
								<h4>10</h4>
								<p>Medical Leave</p>
							</div>
						</div>

						<div class="col-lg-3 col-md-3 col-6">
							<div class="leaveCard">
								<h4>5</h4>
								<p>Other Leave</p>
							</div>
						</div>

						<div class="col-lg-3 col-md-3 col-6">
							<div class="leaveCard">
								<h4>10</h4>
								<p>Remaining Leave</p>
							</div>
						</div>
					</div>

					<div class="pageFilter mb-3 mt-4 p-0">
						<div class="row">
							<div class="col-lg-5">
								<div class="leftFilters">
									<div class="form-floating position-reletive">
										<input type="text" class="form-control datePicker"
											placeholder="Date"> <label for="floatingInput">Date</label> <span
											class="formIcon"><img src="images/calenderIcon.svg" /></span>
									</div>

									<div class="form-floating position-reletive">
										<input type="text" class="form-control" id="floatingPassword"
											placeholder="Password"> <label for="floatingPassword">Year</label>
										<span class="formIcon"><img src="images/calenderIcon.svg" /></span>
									</div>

									<button class="btn btn-search">
										<img src="images/iconSearch.svg" /> Search here
									</button>
								</div>
							</div>
						</div>
					</div>

					<div class="commonDataTable">
						<div class="table-responsive">
							<table class="table mt-3">
								<thead>
									<tr>
										<th>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" value=""
													id="flexCheckChecked">
											</div>
										</th>
										<th>Employee ID</th>
										<th>From</th>
										<th>To</th>
										<th>Leave Type</th>
										<th>Reason</th>
										<th>Leave Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" value=""
													id="flexCheckChecked1">
											</div>
										</td>
										<td>SSPL01</td>
										<td>01 Jan 2016</td>
										<td>01 Jan 2016</td>
										<td>Casual Leave</td>
										<td>Urgent work at home</td>
										<td><span class="badge badge-blue">Approved</span></td>
										<td>
											<button class="btn btn-default" data-bs-toggle="modal"
												data-bs-target="#leavesInfo" href="javascript:void(0);">
												<img src="images/penIcon.svg" />
											</button>

											<button class="btn btn-default">
												<img src="images/deleteIcon.svg" />
											</button>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" value=""
													id="flexCheckChecked1">
											</div>
										</td>
										<td>SSPL01</td>
										<td>01 Jan 2016</td>
										<td>01 Jan 2016</td>
										<td>Casual Leave</td>
										<td>Urgent work at home</td>
										<td><span class="badge badge-blue">Approved</span></td>
										<td>
											<button class="btn btn-default" data-bs-toggle="modal"
												data-bs-target="#leavesInfo" href="javascript:void(0);">
												<img src="images/penIcon.svg" />
											</button>

											<button class="btn btn-default">
												<img src="images/deleteIcon.svg" />
											</button>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" value=""
													id="flexCheckChecked1">
											</div>
										</td>
										<td>SSPL01</td>
										<td>01 Jan 2016</td>
										<td>01 Jan 2016</td>
										<td>Casual Leave</td>
										<td>Urgent work at home</td>
										<td><span class="badge badge-blue">Approved</span></td>
										<td>
											<button class="btn btn-default" data-bs-toggle="modal"
												data-bs-target="#leavesInfo" href="javascript:void(0);">
												<img src="images/penIcon.svg" />
											</button>

											<button class="btn btn-default">
												<img src="images/deleteIcon.svg" />
											</button>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" value=""
													id="flexCheckChecked1">
											</div>
										</td>
										<td>SSPL01</td>
										<td>01 Jan 2016</td>
										<td>01 Jan 2016</td>
										<td>Casual Leave</td>
										<td>Urgent work at home</td>
										<td><span class="badge badge-red">Declined</span></td>
										<td>
											<button class="btn btn-default" data-bs-toggle="modal"
												data-bs-target="#leavesInfo" href="javascript:void(0);">
												<img src="images/penIcon.svg" />
											</button>

											<button class="btn btn-default">
												<img src="images/deleteIcon.svg" />
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="commonPagination my-2">
						<div class="row">
							<div class="col-lg-12">
								<div class="commonPagination__content justify-content-end">
									<p class="mb-0">
										Showing <span>1 to 10</span> of <span>16 entries</span>
									</p>
									<div class="paginationButton">
										<a href="javascript:void(0);">Previous</a> <a
											href="javascript:void(0);">1</a> <a
											href="javascript:void(0);">2</a> <a
											href="javascript:void(0);">Next</a>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- Leave tabs ends -->

			<!-- Salaryslip tab start -->
			<div class="tab-pane fade" id="pills-salary" role="tabpanel"
				aria-labelledby="pills-salary-tab" tabindex="0">
				<div class="profileCard commonBoxShadow rounded-1 mb-3">
					<div class="row">
						<div class="col-lg-6">
							<h3>Salary Slips for the Month of March 2023</h3>
						</div>

						<div class="col-lg-6">
							<div class="text-end">
								<div class="btn-group" role="group"
									aria-label="Basic outlined example">
									<button type="button" class="btn">CSV</button>
									<button type="button" class="btn">PDF</button>
									<button type="button" class="btn">
										<span><img src="images/printIcon.svg" /></span> Print
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="company">
								<div class="company__logo">
									<img class="mini-logo" src="images/mini-logo-green.svg"
										alt="mini-logo-green" />
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
								<p>
									<small>Designing Department</small>
								</p>
								<p>
									<b>UI Designer</b>
								</p>
								<p>
									Employee ID: <b>SSPLO1</b>
								</p>
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

					<p class="mt-2">
						<b>Net Salary: 34968</b> (Thirty four thousand nine hundred and
						sixty eight only.)
					</p>
				</div>
			</div>
			<!-- Salaryslip tab ends -->

			<!-- Awards tab starts -->
			<div class="tab-pane fade" id="pills-awards" role="tabpanel"
				aria-labelledby="pills-awards-tab" tabindex="0">
				<div class="row">
					<div class="col-lg-5">
						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							<a class="editIcon" href="javascript:void(0);"> <img
								src="images/editIcon.svg" />
							</a>
							<h3>Awards & Recognitions</h3>

							<ul class="eduList">
								<li>
									<p>
										<b>Employee of the Month</b>
									</p>
									<p class="grey pb-2">May 2023</p>
								</li>

								<li>
									<p>
										<b>Employee of the Quarter</b>
									</p>
									<p class="grey pb-2">Dec 2022</p>
								</li>

								<li>
									<p>
										<b>General Appreciation of Achievement</b>
									</p>
									<p class="grey pb-2">Oct 2022</p>
								</li>

								<li>
									<p>
										<b>Employee of the Month</b>
									</p>
									<p class="grey pb-2">Jan 2022</p>
								</li>
							</ul>
							<!-- <a class="addBtn" href="javascript:void(0);">Add New <img src="images/addIcon.svg" /></a> -->
						</div>
					</div>
				</div>
			</div>
			<!-- Award tab ends -->

			<!-- Payroll history starts -->
			<div class="tab-pane fade" id="pills-history" role="tabpanel"
				aria-labelledby="pills-history-tab" tabindex="0">
				<div class="row">
					<div class="col-lg-5">
						<div class="profileCard commonBoxShadow rounded-1 mb-3">
							<a class="editIcon" href="javascript:void(0);"> <img
								src="images/editIcon.svg">
							</a>
							<h3>Payroll History</h3>

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
			<!-- Payroll history ends -->

		</div>
	</div>
</div>

</x-admin-layout>