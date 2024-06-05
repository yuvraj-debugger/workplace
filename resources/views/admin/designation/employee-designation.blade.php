
<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Designation</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Designation</li>
				</ol>
			</nav>
		</div>
		<div class="pageFilter mb-3">
                <div class="row">
                     <div class="col-xl-7 col-lg-6 col-md-6 col-sm-6">
                        @if(((Auth::user()->user_role==0)||(Permission::userpermissions('filters',2, 'holidays')|| RolesPermission::userpermissions('filters',2, 'holidays')) )||((Auth::user()->user_role==0)||(Permission::userpermissions('mark_default',2, 'holidays')|| RolesPermission::userpermissions('mark_default',2, 'holidays')) ))
                       <form  method="get" action="">
                        <div class="leftFilters">
                            @if((Auth::user()->user_role==0)||(Permission::userpermissions('filters',2, 'holidays')|| RolesPermission::userpermissions('filters',2, 'holidays')) )
                                <div class="form-group mt-0" >
                                    <label for="floatingSelect">Designation</label>
                                    <select class="form-select js-select2" id="floatingSelect" name="holiday_search" aria-label="Floating label select example">
                                    <option value=''>Select all</option>
                                    </select>
                                    
                                </div>
                                <div class="col mt-1">
                                    <button type="submit" value="Submit" class="btn btn-search mt-4"><img src="images/iconSearch.svg" /> Search here</button>
                                    <button type="button" value="reset" class="btn btn-search mt-4" onclick="window.location='{{ url("employee-designation") }}'">Reset</button>
                                </div>
                            @endif
                        </div>
                        </form>
                        @endif
                      
                    </div> 
                    @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2, 'holidays') || RolesPermission::userpermissions('create',2, 'holidays')) )
                    <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6">
                        <div class="rightFilter holidays">     
                            <a class="addBtn holidays mt-2"  data-bs-toggle="modal" data-bs-target="#addHoliday" href="javascript:void(0);" ><i class="fa-solid fa-plus"></i> Add Designation</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal fade" id="addHoliday" tabindex="-1" aria-labelledby="addHolidayLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel">Add Designation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   <form method="post" class="px-3" enctype="multipart/form-data" id="createHoliday"> 
                      @csrf
                    <div class="row">
                    <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control" placeholder="Enter Date" min="<?=date('Y-m-d')?>" />
                                      <span class="text-danger error" id="error_date"></span> 
                                    
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Occasion</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter Occasion" />
                                                                     <span class="text-danger error" id="error_title"></span> 
                                    
                                </div>
                            </div>
                        <div class="col-lg-12">
                            <div class="form-group mt-4">
                                <button class="btn commonButton modalsubmiteffect">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>      </div>
    </div>
  </div>
</div>     
            
	</div>
</div>
</x-admin-layout>