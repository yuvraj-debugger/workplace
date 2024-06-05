<?php 
use App\Models\Permission;


use App\Models\RolesPermission;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

?>


<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
                <h3>Holidays</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Holidays</li>
                    </ol>
                </nav>
            </div>
            	 @if(session('success'))
                    <div class="alert alert-success alert-block" id="success">
                        {{ session('success') }}
                    </div>
				@endif
					 @if(session('info'))
                    <div class="alert alert-danger alert-block" id="danger">
                        {{ session('info') }}
                    </div>
				@endif
				@if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2, 'holidays') || RolesPermission::userpermissions('create',2, 'holidays')) )
            <div class="pageFilter mb-3">
                <div class="row">
                     <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
                        @if(((Auth::user()->user_role==0)||(Permission::userpermissions('filters',2, 'holidays')|| RolesPermission::userpermissions('filters',2, 'holidays')) )||((Auth::user()->user_role==0)||(Permission::userpermissions('mark_default',2, 'holidays')|| RolesPermission::userpermissions('mark_default',2, 'holidays')) ))
                       <form  method="get" action="">
                        <div class="leftFilters">
                            @if((Auth::user()->user_role==0)||(Permission::userpermissions('filters',2, 'holidays')|| RolesPermission::userpermissions('filters',2, 'holidays')) )
                                <div class="form-group mt-0" >
                                    <label for="floatingSelect">Occasion</label>
                                    <select class="form-select js-select2" id="floatingSelect" name="holiday_search" aria-label="Floating label select example">
                                    <option value=''>Select all</option>
                                    @foreach($holidays as $holiday)
                                     <option value="{{$holiday->_id}}" {{ ($holidays_search==$holiday->_id) ? 'selected' : '' }}>{{$holiday->title}} </option>
                                    @endforeach
                                    </select>
                                    
                                </div>
            
                                <div class="form-group mt-0">
                                    <label for="floatingInput">Date</label>                                  
                                    <input type="date" class="form-control" id="floatingInput" placeholder="Date" name="date_search" value="{{$date}}">
                                </div>
                                <div class="col mt-1">
                                    <button type="submit" value="Submit" class="btn btn-search mt-4"><img src="images/iconSearch.svg" /> Search here</button>
                                    <button type="button" value="reset" class="btn btn-search mt-4" onclick="window.location='{{ url("holidays") }}'">Reset</button>
                                </div>
                            @endif
                        </div>
                        </form>
                        @endif
                      
                    </div> 
                    
                    <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12">
                        <div class="rightFilter holidays">     
                            <a class="addBtn holidays"  data-bs-toggle="modal" data-bs-target="#addHoliday" href="javascript:void(0);" ><i class="fa-solid fa-plus"></i> Add Holidays</a>
                        </div>
                    </div>
                </div>
            </div>
                                @endif
             <?php 
             
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        
                        ?>
            <div class="commonDataTable">
					<div class="table-responsive">
					@if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'holidays') || RolesPermission::userpermissions('delete',2, 'holidays')) )
					 <div class="deleteSelection">
                                <a href="javascript:void(0);" id="deleteAll"  style="display: none;">Delete</a>
                            </div>
                            @endif
						<table class="table">
							<thead>
								<tr>
									
									<th>
														@if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'holidays') || RolesPermission::userpermissions('delete',2, 'holidays')) )
									
									@if(! empty($holidays ) && count($holidays) > 0)
									<div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input select_all_ids"  type="checkbox" value="" id="flexCheckDefault"> 
                                     </div>
                                     @endif
                                     @endif
                                             </th>		
									<th>Date </th>
									<th>Occasion</th>
									@if((Auth::user()->user_role==0) || (!empty($role)&&($role->name=='HR')))
									<th>Action</th>
									@endif
								</tr>
							</thead>
							<tbody>
							  @if(empty($holidays) || count($holidays) <= 0)
                                        <tr><td class="text-center" colspan="9">No Data Found</td></tr>
                                    @else
							 @foreach($holidays as $key=>$holiday)
							<tr>
							<td>
																					@if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'holidays') || RolesPermission::userpermissions('delete',2, 'holidays')) )
							
                                                <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input userDelete"  name="single_ids" type="checkbox" value="{{$holiday->_id}}" id="flexCheckDefault">
                                                </div>
                                                @endif
                                            </td>
							<td>{{date('d M, Y',($holiday->date))}}</td>
							<td>{{$holiday->title}}</td>
																@if((Auth::user()->user_role==0) || (!empty($role)&&($role->name=='HR')))
							
							<td>
                                <div class="actionIcons">
                                    <ul>
                                        <li><a class="edit mr-2" onclick="editHoliday('{{$holiday->_id}}')" data-bs-title="Edit Policy"><i class="fa-solid fa-pen"></i></a></li>
                                        <li><button data-id="{{$holiday->_id}}" class="bin holidayDelete policyDelete ms-0"  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id=""><i class="fa-regular fa-trash-can"></i></button></li>
                                    </ul>
                                </div>
                            </td>
                            	@endif
							</tr>
							@endforeach
							@endif
							</tbody>
						</table>
						{{$holidays->links()}}
					</div>
				</div>
	            
<div class="modal fade commonModalNew" id="addHoliday" tabindex="-1" aria-labelledby="addHolidayLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="addModalLabel">Add Holiday</h1>
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
                        <div class="col-lg-12 text-end">
                            <div class="form-group mt-4">
                                   <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn commonButton modalsubmiteffect">Submit</button>

                            </div>
                        </div>
                    </div>
                </form>      </div>
    </div>
  </div>
</div>     





<div class="modal fade commonModalNew" id="updateHoliday" tabindex="-1" aria-labelledby="updateHolidayLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateModalLabel">Edit Holiday</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   <form method="post" class="px-3" enctype="multipart/form-data" id="updatedHoliday"> 
           @csrf
           <input type="hidden" name="holiday_id" id="holiday_id" value=""/>
                    <div class="row">
                    <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" id="edit_date" name="date" class="form-control" placeholder="Enter Date" min="<?=date('Y-m-d')?>"  />
                                      <span class="text-danger error" id="error_date"></span> 
                                    
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Occasion</label>
                                    <input type="text" name="title" id="edit_title" class="form-control" placeholder="Enter Occasion" />
                                                                     <span class="text-danger error" id="edit_error_title"></span> 
                                </div>
                            </div>
                        <div class="col-lg-12">
                            <div class="form-group mt-4">
                                <button class="btn commonButton modalsubmiteffect ml-auto">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>      </div>
    </div>
  </div>
</div>                
                       
            
            
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>

$('.select_all_ids').click(function(){
    $('.userDelete').prop('checked',$(this).prop('checked'));
});

$('input[type=checkbox]').click(function(){
    var check=0;
    $('input[type=checkbox]').each(function () {
        checked=$(this).is(":checked");
        console.log(checked);
        if(checked)
        {
        	check=1
        }
    });
    
    
    if(check)
    {
    	$('#deleteAll').show();
    }
    else
    {
    	$('#deleteAll').hide();
    }
});

$('#deleteAll').click(function(e){
		e.preventDefault();
		var all_ids = [];
        $('input:checkbox[name="single_ids"]:checked').each(function(){
        	all_ids.push($(this).val());
       });

   		 $.ajax({
                type: 'post',
                url: "{{ route('multipleDelete')}}",
                data: "all_ids="+all_ids+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                   location.reload(true);
                }
            });
});

function editHoliday(id)
{
$('#updateHoliday').modal('show')
  $('#holiday_id').val(id);
      $.ajax({
                type: 'post',
                url: "{{ route('editHoliday')}}",
                data: "id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#edit_title').val(data.title)
                $('#edit_date').val(data.date)
                },
            });
}





  $('#updatedHoliday').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('updateHoliday')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
      			if($.isEmptyObject(data.errors)){
      			                window.location = "/holidays";
      			      			
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#edit_error_'+key).html(value)
                	})
                }
                },
            });
        });
  $('#createHoliday').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('addHoliday')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
      			if($.isEmptyObject(data.errors)){
      			                window.location = "/holidays";
      			      			
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#error_'+key).html(value)
                	})
                }
                },
            });
        });
        
        
        $('.holidayDelete').click(function(){
        
        var id = $(this).data("id")
        
         $.ajax({
                type: 'post',
                url: "{{ route('holidayDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
        
        })
        
                   setTimeout(function() {
    	$('#danger').hide();
     }, 3000);
        
        
        
            setTimeout(function() {
    	$('#success').hide();
     }, 3000);
        

</script>
</x-admin-layout>