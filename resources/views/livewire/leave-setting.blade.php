<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-head-box">
                <h3>Leave Settings</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Leave Settings</li>
                    </ol>
                </nav>
            </div>
        
            <div class="dashboardSection">
                <div class="setting">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="dashboardSection__body mb-3 leaveList">
                                <ul>
                                    <li>
                                        <a href="#leaveYear">Leave Year</a>
                                    </li> 
                                    <li>
                                        <a href="#leaveType">Leave Type</a>
                                    </li>

                                    @foreach($leaveTypes as $leaveType)
                                        <li>
                                            <a wire:click="$set('type_id', '{{$leaveType['_id']}}')" href="#{{str_replace(' ', '', $leaveType['name'])}}">{{$leaveType['name']}}</a>
                                        </li>

                                    @endforeach

                                    <!-- <li>
                                        <a href="#sickLeave">Sick Leave</a>
                                    </li>

                                    <li>
                                        <a href="#earnedLeave">Earned Leave/ Privilege Leave</a>
                                    </li>

                                    <li>
                                        <a href="#maternityLeave">Maternity Leave</a>
                                    </li>

                                    <li>
                                        <a href="#paternityLeave">Paternity Leave</a>
                                    </li>

                                    <li>
                                        <a href="#compensatoryOff">Compensatory Off</a>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="dashboardSection__body" id="leaveYear">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h4>Leave Year</h4>

                                        <div class="form-group">
                                            <label>From<sup>*</sup></label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" />
                                                <span class="ms-2"><img src="{{ asset('/images/editIconGreen.svg') }}" /></span>
                                            </div>
                                        </div>

                                        <h4 class="fs-6 mt-4">Carry Forward *</h4>
                                        <div class="d-flex mt-2">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault">
                                                <label class="form-check-label" for="flexRadioDefault">
                                                  Yes
                                                </label>
                                              </div>
                                              <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                  No
                                                </label>
                                              </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" />
                                                <span class="ms-2"><img src="{{ asset('/images/editIconGreen.svg') }}" /></span>
                                            </div>
                                        </div>

                                        <h4 class="fs-6 mt-4">Earned leave *</h4>
                                        <div class="d-flex mt-2">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault1" id="flexRadioDefault2">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                  Yes
                                                </label>
                                              </div>
                                              <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault1" id="flexRadioDefault3" checked>
                                                <label class="form-check-label" for="flexRadioDefault3">
                                                  No
                                                </label>
                                              </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-7">
                                        <h4 class="d-flex justify-content-between align-items-center">Custom Policy
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                            </div>
                                        </h4>

                                        <div class="commonDataTable">
                                            <div class="table-responsive mt-3">
                                                <table class="table border rounded">
                                                    <thead>
                                                        <tr>
                                                            <th>Policy Name</th>
                                                            <th>Days</th>
                                                            <th>Assignee</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>5 Year Service</td>
                                                            <td>5</td>
                                                            <td>
                                                                <div class="user-name">
                                                                    <div class="user-image">
                                                                        <img src="images/user-img.jpg" alt="user-img">
                                                                    </div>
                                                                    <span class="green">Alex</span>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="actionIcons">
                                                                    <ul>
                                                                        <li><a class="edit" href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li>
                                                                        <li><button class="bin" type="button"><i class="fa-regular fa-trash-can"></i></button></li>
                                                                    </ul>
                                                                </div>
                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <td>5 Year Service</td>
                                                            <td>5</td>
                                                            <td>
                                                                <div class="user-name">
                                                                    <div class="user-image">
                                                                        <img src="images/user-img.jpg" alt="user-img">
                                                                    </div>
                                                                    <span class="green">Alex</span>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="actionIcons">
                                                                    <ul>
                                                                        <li><a class="edit" href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li>
                                                                        <li><button class="bin" type="button"><i class="fa-regular fa-trash-can"></i></button></li>
                                                                    </ul>
                                                                </div>
                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <td>5 Year Service</td>
                                                            <td>5</td>
                                                            <td>
                                                                <div class="user-name">
                                                                    <div class="user-image">
                                                                        <img src="images/user-img.jpg" alt="user-img">
                                                                    </div>
                                                                    <span class="green">Alex</span>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="actionIcons">
                                                                    <ul>
                                                                        <li><a class="edit" href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li>
                                                                        <li><button class="bin" type="button"><i class="fa-regular fa-trash-can"></i></button></li>
                                                                    </ul>
                                                                </div>
                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <td>5 Year Service</td>
                                                            <td>5</td>
                                                            <td>
                                                                <div class="user-name">
                                                                    <div class="user-image">
                                                                        <img src="images/user-img.jpg" alt="user-img">
                                                                    </div>
                                                                    <span class="green">Alex</span>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="actionIcons">
                                                                    <ul>
                                                                        <li><a class="edit" href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li>
                                                                        <li><button class="bin" type="button"><i class="fa-regular fa-trash-can"></i></button></li>
                                                                    </ul>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboardSection__body" id="leaveType">
                                <form wire:submit.prevent="submitLeaveType" enctype="multipart/form-data" class="px-3">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <h4>Leave Type</h4>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Type<sup>*</sup></label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" wire:model="name" class="form-control" />
                                                        <!-- <span class="ms-2"><img src="{{ asset('/images/editIconGreen.svg')}}" /></span> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Short Form<sup>*</sup></label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" wire:model="short_form" class="form-control" />
                                                        <!-- <span class="ms-2"><img src="{{ asset('/images/editIconGreen.svg') }}" /></span> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 mt-3">
                                                    <div class="form-group">

                                                        <label >Select Leave Type<sup>*</sup></label>
                                                        <!-- <div class="d-flex"> -->
                                                        <div class="form-check me-1">
                                                            <input class="form-check-input" type="radio" value="maternity" wire:model="type"   >
                                                            <label class="form-check-label" for="flexRadioDefault10">Maternity</label>
                                                        </div>
                
                                                        <div class="form-check me-1">
                                                            <input class="form-check-input" type="radio" value="paternity" wire:model="type" >
                                                            <label class="form-check-label" for="flexRadioDefault1">Paternity</label>
                                                        </div>
                                                        <div class="form-check me-1">
                                                            <input class="form-check-input" type="radio" value="bereavement" wire:model="type" >
                                                            <label class="form-check-label" for="flexRadioDefault1">Bereavement</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="lop" wire:model="type" >
                                                            <label class="form-check-label" for="flexRadioDefault1">LOP</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="other"  wire:model="type" >
                                                            <label class="form-check-label" for="flexRadioDefault1">Other</label>
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
                                        <div class="col-lg-7">
                                            <h4 class="d-flex justify-content-between align-items-center">Custom Policy
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                                </div>
                                            </h4>
    
                                            <div class="commonDataTable">
                                                <div class="table-responsive mt-3">
                                                    <table class="table border rounded">
                                                        <thead>
                                                            <tr>
                                                                <th>Leave Name</th>
                                                                <th>Short Form</th>
                                                                <th>Leave Type</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($leaveTypes as $leave )
                                                            <tr>
                                                             
                                                                <td>{{$leave->name}}</td>
                                                                <td>{{$leave->short_form}}</td>
                                                               
                                                                <td>
                                                                    <div class="user-name">
                                                                        {{-- <div class="user-image">
                                                                            <img src="images/user-img.jpg" alt="user-img">
                                                                        </div> --}}
                                                                        <span class="green">{{$leave->type}}</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="actionIcons">
                                                                        <ul>
                                                                            <li><a class="edit" href="javascript:void(0);" wire:click="edit('{{ $leave->_id }}')"><i class="fa-solid fa-pen"></i></a></li>
                                                                            <li><button class="bin" type="button"  onclick="confirm('Are you sure you want to delete this Record?') || event.stopImmediatePropagation()" wire:click="delete('{{$leave->_id}}')"><i class="fa-regular fa-trash-can"></i></button></li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @foreach($leaveTypes as $leaveType)




                            <div class="dashboardSection__body mt-3" id="{{str_replace(' ', '' , $leaveType['name'])}}">
                                <h4 class="d-flex justify-content-between align-items-center">{{$leaveType['name']}}
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault1">
                                    </div>
                                </h4>
                                @if(@$leaveType['type'] == 'maternity')
                                    <form wire:submit.prevent="updateSetting" enctype="multipart/form-data" class="px-3">

                                       
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Payroll Component</label>
                                                    <select class="form-control" wire:model="payroll_component" >
                                                        <option value="" selected>Select Payroll</option>
                                                        <option value="basic">Basic Salary</option>
                                                        <option value="gross">Gross Salary</option>
                                                    </select>
                                                    @error('payroll_component') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox" wire:model="normal" class="form-check-input" id="normal">
                                                    <label class="form-check-label" for="exampleCheck1">Normal</label>
                                                </div>
                                            </div> 
                                            @if(@$this->normal == '1')
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label>Maximum weeks before Expected Delivery Date - </label>
                                                            <div class="d-flex align-items-center">
                                                                <input type="text" wire:model="normal_max_week_before_expected" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label>Maximum weeks after Expected Delivery Date - </label>
                                                            <div class="d-flex align-items-center">
                                                                <input type="text" wire:model="normal_max_week_after_expected" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <h4 class="fs-6 mt-4">Conditions</h4> 
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label>DOJ should be </label>
                                                            <div class="d-flex align-items-center">
                                                                <input type="text" class="form-control" wire:model="normal_doj_month_old"/>
                                                            </div>
                                                            <label>month old  </label>

                                                        </div>
                                                    </div>
                                                    <h4 class="fs-6 mt-4">Credit if on resigned *</h4>
                                                    <div class="d-flex mt-2">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" wire:model="normal_credit_resigned" name="normal_credit_resigned" type="radio"  id="flexRadioDefault">
                                                            <label class="form-check-label" for="flexRadioDefault">
                                                              Yes
                                                            </label>
                                                          </div>
                                                          <div class="form-check">
                                                            <input class="form-check-input" wire:model="normal_credit_resigned" type="radio" name="normal_credit_resigned" id="flexRadioDefault1" checked>
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                              No
                                                            </label>
                                                          </div>
                                                    </div> 
                                                    <h4 class="fs-6 mt-4">Credit if on probation *</h4>
                                                    <div class="d-flex mt-2">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" wire:model="normal_credit_probation" type="radio" name="normal_credit_probation" id="flexRadioDefault2">
                                                            <label class="form-check-label" for="flexRadioDefault">
                                                              Yes
                                                            </label>
                                                          </div>
                                                          <div class="form-check">
                                                            <input class="form-check-input" wire:model="normal_credit_probation" type="radio" name="normal_credit_probation" id="flexRadioDefault3" checked>
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                              No
                                                            </label>
                                                          </div>
                                                    </div>
                                                    <h4 class="fs-6 mt-4">WFH Settings</h4> 
                                                    <div class="form-group">
                                                        <div class="mb-3 form-check">
                                                            <input type="checkbox"  wire:model="normal_wfh" class="form-check-input" id="exampleCheckwfh" >
                                                            <label class="form-check-label" for="exampleCheck1">WFH</label>
                                                        </div>
                                                    </div>

                                                    @if(@$this->normal_wfh == '1')  
                                                        <div class="form-group">
                                                            <div class="mb-3 form-check">
                                                                <input type="checkbox"  wire:model="normal_wfh_permanent" class="form-check-input" id="permanentwfh">
                                                                <label class="form-check-label" for="exampleCheck1">Permanent WFH</label>
                                                            </div>
                                                        </div> 
                                                        @if(@$this->normal_wfh_permanent == '1')  
                                                            <div class="col-lg-5">
                                                                <div class="form-group">
                                                                    <label>Maximum weeks before Expected Delivery Date - </label>
                                                                    <div class="d-flex align-items-center">
                                                                        <input type="text" wire:model="normal_permanent_max_week_before" class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-5">
                                                                <div class="form-group">
                                                                    <label>Maximum weeks after Expected Delivery Date - </label>
                                                                    <div class="d-flex align-items-center">
                                                                        <input type="text" wire:model="normal_permanent_max_week_after" class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        @endif 
                                                        <div class="form-group">
                                                            <div class="mb-3 form-check">
                                                                <input type="checkbox"  wire:model="normal_temporary_wfh" class="form-check-input" id="permanentwfh">
                                                                <label class="form-check-label" for="exampleCheck1">Temporary WFH</label>
                                                            </div>
                                                        </div> 
                                                        @if(@$this->normal_temporary_wfh == '1')  

                                                            <div class="col-lg-5">
                                                                <div class="form-group">
                                                                    <label>Maximum weeks before Expected Delivery Date - </label>
                                                                    <div class="d-flex align-items-center">
                                                                        <input type="text" wire:model="normal_temporary_max_week_before" class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-5">
                                                                <div class="form-group">
                                                                    <label>Maximum weeks after Expected Delivery Date - </label>
                                                                    <div class="d-flex align-items-center">
                                                                        <input type="text" wire:model="normal_temporary_max_week_after" class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        @endif
                                                    @endif
                                                    <h4 class="fs-6 mt-4">Leave Clubbed Settings</h4> 
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label>Leave cannot Clubbed with - </label>
                                                            <div class="d-flex align-items-center">
                                                                <select class="form-select user_list" wire:model="normal_not_clubbed" id="floatingSelect" aria-label="Floating label select example">
                                                                  <option value="" selected>Select Leave Type</option>
                                                                  @foreach($leaveTypes as $type)
                                                                  <option value="{{$type['_id']}}">{{$type['name']}}</option>
                                                                  @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox"  class="form-check-input" wire:model="adoptive" id="adoptive">
                                                    <label class="form-check-label" for="exampleCheck1">Adoptive and Commission mothers Case</label>
                                                </div>
                                            </div> 
                                            @if(@$this->adoptive == '1')
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label>Maximum weeks after Expected Date - </label>
                                                            <div class="d-flex align-items-center">
                                                                <input type="text" wire:model="adoptive_max_week_after_expected" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <h4 class="fs-6 mt-4">Conditions</h4> 
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label>DOJ should be </label>
                                                            <div class="d-flex align-items-center">
                                                                <input type="text" wire:model="adoptive_doj_month_old" class="form-control" />
                                                            </div>
                                                            <label>month old  </label>

                                                        </div>
                                                    </div>
                                                    <h4 class="fs-6 mt-4">Credit if on resigned *</h4>
                                                    <div class="d-flex mt-2">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" wire:model="adoptive_credit_resigned" type="radio" name="flexRadioDefault" id="flexRadioDefault">
                                                            <label class="form-check-label" for="flexRadioDefault">
                                                              Yes
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" wire:model="adoptive_credit_resigned" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                              No
                                                            </label>
                                                        </div>
                                                    </div> 
                                                    <h4 class="fs-6 mt-4">Credit if on probation *</h4>
                                                    <div class="d-flex mt-2">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" wire:model="adoptive_credit_probation" type="radio" name="adoptive_credit_probation" value="yes" >
                                                            <label class="form-check-label" for="flexRadioDefault">
                                                              Yes
                                                            </label>
                                                          </div>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="adoptive_credit_probation" wire:model="adoptive_credit_probation" value="no">
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                              No
                                                            </label>
                                                          </div>
                                                    </div>
                                                    <h4 class="fs-6 mt-4">WFH Settings</h4> 
                                                    <div class="form-group">
                                                        <div class="mb-3 form-check">
                                                            <input type="checkbox" wire:model="adoptive_wfh" class="form-check-input" >
                                                            <label class="form-check-label" for="exampleCheck1">WFH</label>
                                                        </div>
                                                    </div>  
                                                    <div class="form-group">
                                                        <div class="mb-3 form-check">
                                                            <input type="checkbox"  wire:model="adoptive_wfh_permanent"class="form-check-input" id="permanentwfh">
                                                            <label class="form-check-label" for="exampleCheck1">Permanent WFH</label>
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label>Maximum weeks before Expected Delivery Date - </label>
                                                            <div class="d-flex align-items-center">
                                                                <input type="text" wire:model="adoptive_permanent_max_week_before" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label>Maximum weeks after Expected Delivery Date - </label>
                                                            <div class="d-flex align-items-center">
                                                                <input type="text" wire:model="adoptive_permanent_max_week_after" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div>  
                                                    <div class="form-group">
                                                        <div class="mb-3 form-check">
                                                            <input type="checkbox" wire:model="adoptive_wfh_temporary"  class="form-check-input">
                                                            <label class="form-check-label" for="exampleCheck1">Temporary WFH</label>
                                                        </div>
                                                    </div> 
                                                
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label>Maximum weeks before Expected Delivery Date - </label>
                                                            <div class="d-flex align-items-center">
                                                                <input type="text" wire:model="adoptive_temporary_max_week_before" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label>Maximum weeks after Expected Delivery Date - </label>
                                                            <div class="d-flex align-items-center">
                                                                <input type="text" wire:model="adoptive_temporary_max_week_after" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <h4 class="fs-6 mt-4">Leave Clubbed Settings</h4> 
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label>Leave cannot Clubbed with - </label>
                                                            <div class="d-flex align-items-center">
                                                                <select class="form-select user_list" wire:model="adoptive_not_clubbed" id="floatingSelect" aria-label="Floating label select example">
                                                                  <option value="all" selected>Select All</option>
                                                                  @foreach($leaveTypes as $type)
                                                                  <option value="{{$type['_id']}}">{{$type['name']}}</option>
                                                                  @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox"  wire:model="miscarriage" class="form-check-input" id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">Miscarriage or abortion</label>
                                                </div>
                                            </div>
                                            @if(@$this->miscarriage == '1')

                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>Maximum weeks after Expected Date - </label>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" wire:model="miscarriage_max_week_after_expected" class="form-control" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <h4 class="fs-6 mt-4">Conditions</h4> 
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>DOJ should be </label>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" wire:model="miscarriage_doj_month_old" class="form-control" />
                                                        </div>
                                                        <label>month old  </label>

                                                    </div>
                                                </div>
                                                <h4 class="fs-6 mt-4">Credit if on resigned *</h4>
                                                <div class="d-flex mt-2">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" wire:model="miscarriage_credit_resigned" type="radio" name="flexRadioDefault" id="flexRadioDefault">
                                                        <label class="form-check-label" for="flexRadioDefault">
                                                          Yes
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" wire:model="miscarriage_credit_resigned" type="radio" name="flexRadioDefault"  checked>
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                          No
                                                        </label>
                                                    </div>
                                                </div> 
                                                <h4 class="fs-6 mt-4">Credit if on probation *</h4>
                                                <div class="d-flex mt-2">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" wire:model="miscarriage_credit_probation" type="radio" name="flexRadioDefault" >
                                                        <label class="form-check-label" for="flexRadioDefault">
                                                          Yes
                                                        </label>
                                                      </div>
                                                      <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="flexRadioDefault" wire:model="miscarriage_credit_probation">
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                          No
                                                        </label>
                                                      </div>
                                                </div>
                                                <h4 class="fs-6 mt-4">WFH Settings</h4> 
                                                <div class="form-group">
                                                    <div class="mb-3 form-check">
                                                        <input type="checkbox" wire:model="miscarriage_wfh" class="form-check-input" >
                                                        <label class="form-check-label" for="exampleCheck1">WFH</label>
                                                    </div>
                                                </div>  
                                                <div class="form-group">
                                                    <div class="mb-3 form-check">
                                                        <input type="checkbox"  wire:model="miscarriage_wfh_permanent"class="form-check-input" >
                                                        <label class="form-check-label" for="exampleCheck1">Permanent WFH</label>
                                                    </div>
                                                </div> 
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>Maximum weeks before Expected Delivery Date - </label>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" wire:model="miscarriage_permanent_max_week_before" class="form-control" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>Maximum weeks after Expected Delivery Date - </label>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" wire:model="miscarriage_permanent_max_week_after" class="form-control" />
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="form-group">
                                                    <div class="mb-3 form-check">
                                                        <input type="checkbox" wire:model="miscarriage_wfh_temporary"  class="form-check-input">
                                                        <label class="form-check-label" for="exampleCheck1">Temporary WFH</label>
                                                    </div>
                                                </div> 
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>Maximum weeks before Expected Delivery Date - </label>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" wire:model="miscarriage_temporary_max_week_before" class="form-control" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>Maximum weeks after Expected Delivery Date - </label>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" wire:model="miscarriage_temporary_max_week_after" class="form-control" />
                                                        </div>
                                                    </div>
                                                </div> 
                                                <h4 class="fs-6 mt-4">Leave Clubbed Settings</h4> 

                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>Leave cannot Clubbed with - </label>
                                                        <div class="d-flex align-items-center">
                                                            <select class="form-select user_list" wire:model="miscarriage_not_clubbed" id="floatingSelect" aria-label="Floating label select example">
                                                              <option value="all" selected>Select All</option>
                                                              @foreach($leaveTypes as $type)
                                                              <option value="{{$type['_id']}}">{{$type['name']}}</option>
                                                              @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif 
                                            <h4 class="fs-6 mt-4">Approval Required *</h4>
                                            <div class="form-group">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox"  class="form-check-input" wire:model="approval_required">
                                                    <label class="form-check-label" for="exampleCheck1">WFH</label>
                                                </div>
                                            </div>
                                            @if(@$this->approval_required == '1') 
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>How Many Days in Advance - </label>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" wire:model="approval_days" class="form-control" />
                                                        </div>
                                                    </div>
                                                </div> 
                                            @endif 
                                            <h4 class="fs-6 mt-4">Notification while apply</h4>
                                            <div class="form-group">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox"  wire:model="notification_apply" class="form-check-input" id="exampleCheckwfh">
                                                    <label class="form-check-label" for="exampleCheck1"></label>
                                                </div>
                                            </div> 
                                            @if(@$this->notification_apply == '1') 

                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label>Notification - </label>
                                                    <div class="d-flex align-items-center" wire:ignore>
                                                        {{-- <input type="text" class="form-control" wire:model="notification"/> --}}          
    				                                    <textarea class="form-control" id="notification" placeholder="" wire:model="notification" ></textarea>
                                                    </div>
                                                </div>
                                            </div>  
                                            @endif
                                            <h4 class="fs-6 mt-4">Effect on Appraisal Period</h4>
                                            <div class="form-group">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox"  class="form-check-input" wire:model="effect_appraisal">
                                                    <label class="form-check-label" for="exampleCheck1"></label>
                                                </div>
                                            </div> 
                                            @if(@$this->effect_appraisal == '1') 
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>Increase the appraisal date by number of leaves - </label>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" class="form-control" wire:model="increase_appraisal"/>
                                                        </div>
                                                    </div>
                                                </div> 
                                            @endif
                                            <h4 class="fs-6 mt-4">Effect on Work Experience</h4>
                                            <div class="form-group">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox"  class="form-check-input" wire:model="effect_experience">
                                                    <label class="form-check-label" for="exampleCheck1">WFH</label>
                                                </div>
                                            </div> 
                                            @if(@$this->effect_experience == '1') 
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>Reduce the experience by number of days - </label>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" class="form-control" wire:model="reduce_experience"/>
                                                        </div>
                                                    </div>
                                                </div> 
                                            @endif          
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mt-4">
                                                <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                                            </div>
                                        </div> 
                                    </form>

                                @elseif(@$leaveType['type'] == 'paternity')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Payroll Component</label>
                                                <select class="form-control" wire:model="payroll_component">
                                                    <option value="" selected>Select Payroll</option>
                                                    <option value="basic">Basic Salary</option>
                                                    <option value="gross">Gross Salary</option>
                                                </select>
                                                @error('payroll_component') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Maximum allowed</label>
                                                <input type="number" wire:model="normal_max_week_after_expected" class="form-control" />
                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>DOJ</label>
                                                <input type="text" wire:model="normal_doj_month_old" class="form-control" />
                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label >Can be used if on resigned<sup>*</sup></label>
                                            <div class="d-flex">
                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" value="1" wire:model="normal_credit_resigned" value="yes"   >
                                                        <label class="form-check-label" for="flexRadioDefault10">Yes</label>
                                                </div>
        
                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" value="0" wire:model="normal_credit_resigned" value="no">
                                                    <label class="form-check-label" for="flexRadioDefault1">No</label>
                                                </div>
                                                
                                            </div>
                                           
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label >Can be used if on probation<sup>*</sup></label>
                                            <div class="d-flex">
                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" value="1" wire:model="normal_credit_probation"  value="yes"  >
                                                        <label class="form-check-label" for="flexRadioDefault10">Yes</label>
                                                </div>
                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" value="0" wire:model="normal_credit_probation"  value="no">
                                                    <label class="form-check-label" for="flexRadioDefault1">No</label>
                                                </div>
                                                
                                            </div>
                                           
                                        </div>
                                        
                                        <div class="col-lg-12 mt-3 mb-3">
                                            <label >Work Status<sup>*</sup></label>
                                            <div class="d-flex">
                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" value="1" wire:model="normal_wfh"    >
                                                        <label class="form-check-label" for="flexRadioDefault10">WFH</label>
                                                </div>
                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" value="0" wire:model="normal_wfh"   >
                                                    <label class="form-check-label" for="flexRadioDefault1">WFO</label>
                                                </div>
                                                
                                            </div>
                                           
                                        </div>
                                        @if(@$this->normal_wfh == '1')
                                            <div class="form-group">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox"  wire:model="normal_wfh_permanent" class="form-check-input" id="permanentwfh">
                                                    <label class="form-check-label" for="exampleCheck1">Permanent WFH</label>
                                                </div>
                                            </div> 
                                            @if(@$this->normal_wfh_permanent == '1')
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>Maximum Days - </label>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" wire:model="normal_permanent_max_week_after" class="form-control" />
                                                        </div>
                                                    </div>
                                                </div> 
                                            @endif
                                            <div class="form-group">
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox"  wire:model="normal_wfh_temporary" class="form-check-input" id="permanentwfh">
                                                    <label class="form-check-label" for="exampleCheck1">Temporary WFH</label>
                                                </div>
                                            </div> 
                                            @if(@$this->normal_wfh_temporary == '1')

                                             <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label>Maximum Days - </label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" wire:model="normal_temporary_max_week_after" class="form-control" />
                                                    </div>
                                                </div>
                                            </div> 
                                            @endif
                                        @endif
                                        
                                         <h4 class="fs-6 mt-4">Leave Clubbed Settings</h4> 

                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>Leave cannot Clubbed with - </label>
                                                <div class="d-flex align-items-center">
                                                    <select class="form-select user_list" wire:model="normal_not_clubbed" id="floatingSelect" aria-label="Floating label select example">
                                                      <option value="all" selected>Select All</option>
                                                      @foreach($leaveTypes as $type)
                                                      <option value="{{$type['_id']}}">{{$type['name']}}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="fs-6 mt-4">Approval Required *</h4>
                                       <div class="form-group">
                                            <div class="mb-3 form-check">
                                                <input type="checkbox"  class="form-check-input" wire:model="approval_required">
                                                <label class="form-check-label" for="exampleCheck1">WFH</label>
                                            </div>
                                        </div> 
                                         <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>How Many Days in Advance - </label>
                                                <div class="d-flex align-items-center">
                                                    <input type="text" wire:model="approval_days" class="form-control" />
                                                </div>
                                            </div>
                                        </div>  
                                        <h4 class="fs-6 mt-4">Notification while apply</h4>
                                       <div class="form-group">
                                            <div class="mb-3 form-check">
                                                <input type="checkbox"  wire:model="notification_apply" class="form-check-input" id="exampleCheckwfh">
                                                <label class="form-check-label" for="exampleCheck1"></label>
                                            </div>
                                        </div> 
                                         <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>Notification - </label>
                                                <div class="d-flex align-items-center">
                                                    <input type="text" class="form-control" wire:model="notification"/>
                                                </div>
                                            </div>
                                        </div>  
                                        <h4 class="fs-6 mt-4">Effect on Appraisal Period</h4>
                                       <div class="form-group">
                                            <div class="mb-3 form-check">
                                                <input type="checkbox"  class="form-check-input" wire:model="effect_appraisal">
                                                <label class="form-check-label" for="exampleCheck1"></label>
                                            </div>
                                        </div> 
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>Increase the appraisal date by number of leaves - </label>
                                                <div class="d-flex align-items-center">
                                                    <input type="text" class="form-control" wire:model="increase_appraisal"/>
                                                </div>
                                            </div>
                                        </div> 
                                        <h4 class="fs-6 mt-4">Effect on Work Experience</h4>
                                       <div class="form-group">
                                            <div class="mb-3 form-check">
                                                <input type="checkbox"  class="form-check-input" wire:model="effect_experience">
                                                <label class="form-check-label" for="exampleCheck1">WFH</label>
                                            </div>
                                        </div> 
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>Reduce the experience by number of days - </label>
                                                <div class="d-flex align-items-center">
                                                    <input type="text" class="form-control" wire:model="reduce_experience"/>
                                                </div>
                                            </div>
                                        </div> 
                                        
                                    
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mt-4">
                                           
                                            <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                                        </div>
                                    </div> 
                                @elseif(@$leaveType['type'] == 'bereavement')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Maximum allowed</label>
                                                <input type="number" wire:model="normal_max_week_after_expected" class="form-control" />  
                                            </div>
                                        </div>
                                        <h4 class="fs-6 mt-4">Leave Clubbed Settings</h4> 

                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>Leave cannot Clubbed with - </label>
                                                <div class="d-flex align-items-center">
                                                    <select class="form-select user_list" wire:model="miscarriage_not_clubbed" id="floatingSelect" aria-label="Floating label select example">
                                                      <option value="all" selected>Select All</option>
                                                      @foreach($leaveTypes as $type)
                                                      <option value="{{$type['_id']}}">{{$type['name']}}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="fs-6 mt-4">Approval Required *</h4>
                                        <div class="form-group">
                                            <div class="mb-3 form-check">
                                                <input type="checkbox"  class="form-check-input" wire:model="approval_required">
                                                <label class="form-check-label" for="exampleCheck1">WFH</label>
                                            </div>
                                        </div>
                                        @if(@$this->approval_required == '1') 
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label>How Many Days in Advance - </label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" wire:model="approval_days" class="form-control" />
                                                    </div>
                                                </div>
                                            </div> 
                                        @endif 
                                        <h4 class="fs-6 mt-4">Notification while apply</h4>
                                        <div class="form-group">
                                            <div class="mb-3 form-check">
                                                <input type="checkbox"  wire:model="notification_apply" class="form-check-input" id="exampleCheckwfh">
                                                <label class="form-check-label" for="exampleCheck1"></label>
                                            </div>
                                        </div> 
                                        @if(@$this->notification_apply == '1') 
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label>Notification - </label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" class="form-control" wire:model="notification"/>
                                                    </div>
                                                </div>
                                            </div>  
                                        @endif
                                    </div>
                                @elseif(@$leaveType['type'] == 'lop')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Maximum allowed</label>
                                                <input type="number" wire:model="normal_max_week_after_expected" class="form-control" />  
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Maximum consecutive allowed</label>
                                                <input type="number" wire:model="max_consecutive_allowed" class="form-control" />  
                                            </div>
                                        </div>
                                        <h4 class="fs-6 mt-4">If taken more than Maximum allowed</h4> 
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Deductions</label>
                                                <input type="number" wire:model="max_allowed_deduction" class="form-control" />  
                                            </div>
                                        </div>
                                        <h4 class="fs-6 mt-4">If taken more than Maximum consecutive allowed</h4> 
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Deductions</label>
                                                <input type="number" wire:model="max_consecutive_deduction" class="form-control" />  
                                            </div>
                                        </div>
                                        <h4 class="fs-6 mt-4">If Leave count is more than <input type="number" wire:model="leave_count" class="form-control" />  in a year</h4> 
                                        <div class="form-group">
                                            <div class="mb-3 form-check">
                                                <input type="checkbox"  class="form-check-input" wire:model="effect_appraisal">
                                                <label class="form-check-label" for="exampleCheck1">Effect on Appraisal Period</label>
                                            </div>
                                        </div> 
                                     
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>Increase the appraisal date by number of leaves - </label>
                                                <div class="d-flex align-items-center">
                                                    <input type="text" class="form-control" wire:model="increase_appraisal"/>
                                                </div>
                                            </div>
                                        </div> 
                                        <!-- <h4 class="fs-6 mt-4">Effect on Work Experience</h4> -->
                                       <div class="form-group">
                                            <div class="mb-3 form-check">
                                                <input type="checkbox"  class="form-check-input" wire:model="effect_experience">
                                                <label class="form-check-label" for="exampleCheck1">Effect on Work Experience</label>
                                            </div>
                                        </div> 
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>Reduce the experience by number of days - </label>
                                                <div class="d-flex align-items-center">
                                                    <input type="text" class="form-control" wire:model="reduce_experience"/>
                                                </div>
                                            </div>
                                        </div> 
                                         <h4 class="fs-6 mt-4">Approval Required *</h4>
                                        <div class="form-group">
                                            <div class="mb-3 form-check">
                                                <input type="checkbox"  class="form-check-input" wire:model="approval_required">
                                                <label class="form-check-label" for="exampleCheck1">WFH</label>
                                            </div>
                                        </div>
                                        @if(@$this->approval_required == '1') 
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label>How Many Days in Advance - </label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" wire:model="approval_days" class="form-control" />
                                                    </div>
                                                </div>
                                            </div> 
                                        @endif 
                                    </div>
                                @else
                                    <div class="row">
                                        <h4 class="fs-6 mt-4">Credit Settings</h4> 
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Credited Frequency</label>
                                                <select class="form-control" wire:model="credited_frequency">
                                                    <option value="" selected>Select Credited Frequency</option>
                                                    <option value="monthly">Monthly</option>
                                                    <option value="quarterly">Quarterly</option>
                                                    <option value="biyearly">Biyearly</option>
                                                    <option value="yearly">Yearly</option>
                                                </select>
                                                @error('payroll_component') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                    </div>

                                @endif
                            </div>
                            @endforeach

                            <div class="dashboardSection__body mt-3" id="sickLeave">
                                <h4 class="d-flex justify-content-between align-items-center">Sick Leave
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault1">
                                    </div>
                                </h4>

                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label>Days</label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" />
                                                <span class="ms-2"><img src="{{ asset('/images/editIconGreen.svg')}}" /></span>
                                            </div>
                                        </div>
                                    </div> 
                                   
                                </div>
                            </div>

                            <div class="dashboardSection__body mt-3"  id="earnedLeave">
                                <h4 class="d-flex justify-content-between align-items-center">Earned Leave/ Privilege Leave
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault1">
                                    </div>
                                </h4>

                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label>Days</label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" />
                                                <span class="ms-2"><img src="{{ asset('/images/editIconGreen.svg') }}" /></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboardSection__body mt-3" id="maternityLeave">
                                <h4 class="d-flex justify-content-between align-items-center">Maternity Leave
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault1">
                                    </div>
                                </h4>

                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label>Days</label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" />
                                                <span class="ms-2"><img src="{{ asset('/images/editIconGreen.svg') }}" /></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboardSection__body mt-3" id="paternityLeave">
                                <h4 class="d-flex justify-content-between align-items-center">Paternity Leave
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault1">
                                    </div>
                                </h4>

                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label>Days</label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" />
                                                <span class="ms-2"><img src="{{ asset('/images/editIconGreen.svg') }}" /></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboardSection__body mt-3" id="compensatoryOff">
                                <h4 class="d-flex justify-content-between align-items-center">Compensatory Off
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault1">
                                    </div>
                                </h4>

                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label>Days</label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" />
                                                <span class="ms-2"><img src="{{ asset('/images/editIconGreen.svg') }}" /></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
        
    <!-- holiday modal starts -->
<div class="modal fade personalInfo" id="leaveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Edit Leave</h3>
                <form action="" class="px-3">
                    <div class="row">>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Leave Type</label>
                                <select class="form-control">
                                    <option>Casual Leave</option>
                                    <option>Sick Leave</option>
                                    <option>Earned Leave</option>
                                    <option>Loss Of Pay</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Leave Paid Status</label>
                                <select class="form-control">
                                    <option></option>
                                    <option>Paid</option>
                                    <option>Unpaid</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>No. of Leaves</label>
                                <select class="form-control">
                                    <option></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
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
<!-- holidy modal ends -->
</div>

@push('scripts')


    <script>
        document.addEventListener('livewire:update', function (event) {
            if(@this.notification_apply  == '1'){
                ClassicEditor.create(document.querySelector('#notification')).then(editor => {  
                    editor.model.document.on('change:data', () => {
                        @this.set('notification', editor.getData());
                    })
                })
                .catch(error => {
                    console.error(error);
                });
            }
        });
    </script>
@endpush