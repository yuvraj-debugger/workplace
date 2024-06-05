
<?php 

use App\Models\Submodule;
?>
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-head-box">
                <h3>Roles and Permissions</h3>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Roles and Permissions</li>
                    </ol>
                </nav>
            </div>
            
            
            <div class="pageFilter mb-3">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="rightFilter">
                            <a class="module_button addBtn" data-bs-toggle="modal" onclick="modalShow()" data-bs-target="#personalInfo" href="javascript:void(0);"><i class="fa-solid fa-plus"></i> Manage Roles</a>
                        </div>
                    </div>
                </div>
            </div>
             @if(session('success'))
                    <div class="alert alert-success alert-block" id="success">
                        {{ session('success') }}
                    </div>
				@endif
            @if(Session::has('message'))
            	<p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif

                
 <!-- My Work Starts -->
<div class="rolesAccordian">
    <div class="accordion" id="accordionExample">
    @foreach($roles as $role)
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_{{$role->_id}}" aria-expanded="true" aria-controls="collapseOne_{{$role->_id}}" onclick="getRole('{{$role->_id}}')">
              {{$role->name}}
            </button>
            
          </h2>
                                    <div class="loader" id="loader_{{$role->_id}}" style="display:none;"><img src="{{asset('images/loading2.gif')}}"></div>
          
          <div id="collapseOne_{{$role->_id}}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="employeeSection" id="body_data_{{ $role->_id }}">
                    <div class="row">
                    </div>
                </div> 
            </div>
          </div>
        </div>
        @endforeach
        
        
        </div>
    </div>
</div>       
 <!-- My Work Ends -->
        </div>
    <!-- </div> -->
    <div class="modal fade personalInfo" id="personalInfo" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 ml-auto" id="staticBackdropLabel">Roles </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne"></h2>
                            <div class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="dashboardSection">
                                        <div class="dashboardSection__body pt-0 px-0">
                                            <div class="commonDataTable">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th> Roles Name</th>
                                                                <th> Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($roles as $user)
                                                                <tr>
                                                                    <td>
                                                                        <span id="user_name_{{$user->_id}}">{{ $user->name }}</span>
                                                                        <span id="user_id_{{$user->_id}}"
                                                                        class="module_data" style="display: none;">
                                                                            <input type="text" name="name"
                                                                                id="role_name_{{$user->_id }}"
                                                                                class="form-control" value="{{ $user->name }}">
                                                                                
                                                                        </span>
                                                                        
                                                                    </td>
                                                                    <span class="text-danger error" id="edit_error_name"></span> 

                                                                    <td>
                                                                        <div class="actionIcons">
                                                                        <span onclick="edit('{{ $user->_id }}')"
                                                                            id="user_edit_{{ $user->_id }}"
                                                                            class="user_edit edit"
                                                                            data-username="{{ $user->name}}">
                                                                            <i
                                                                                                    class="fa-solid fa-pen"></i>
                                                                        </span> 
                                                                        <span onclick="save('{{ $user->_id }}')"
                                                                            id="save_user_{{ $user->_id }}"
                                                                            class="save_user"
                                                                            >
                                                                            <i class="fa fa-check"></i>
                                                                        </span>
                                                                            <button class="bin delete_role policyDelete"  data-id="{{ $user->_id }}"  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" ype="button"><i class="fa-regular fa-trash-can"></i></button>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" enctype="multipart/form-data" id="addRole">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label for="name">Role Name<sup>*</sup></label>
                                    <input type="text" name="name" class="form-control" id="role_name" required/>
                                    <span class="text-danger error" id="error_name"></span> 
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>Import from Role</label>
                                    <select class="form-control import_role" required>
                                        <option value="" selected>Select </option>
                                        @foreach ($roles as $user)
                                            <option value="{{ $user->id }}"> {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mt-4 addoffmodalfoot">
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                <button class="btn commonButton ml-1 modalsubmiteffect">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
 $(document).ready(function() {
 
 $(document).ready(function() {
  $("#personalInfo").on("hidden.bs.modal", function() {
  	 $(this).find('form').trigger('reset');
  	  $('.error').html('');
  });
});
 
 
  $('#addRole').submit(function(e) {
            e.preventDefault(); 
            var name = $('#role_name').val();
            $.ajax({
                type: 'post',
                url: "{{ route('addRole')}}",
                data: "name="+name+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                
      				if($.isEmptyObject(response.errors)){
      			        window.location = "/roles-permissions";
      			      			
                }else{
                	$.each( response.errors, function( key, value ) {
                		$('#error_'+key).html(value)
                	})
                }
      				
                },
            });
        });
});
        
        $(".delete_role").click(function(){
        var id = $(this).data("id");
        $.ajax({
                type: 'post',
                url: "{{ route('deleteRole')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
        });
        function modalShow()
        {
           $('.save_user').hide()
        }
        function edit(id)
        {
        	$('#user_name_'+id).hide()
        	$('#user_id_'+id).show()
        	$('#save_user_'+id).show()
        	$('.user_edit').hide();
        	$('.delete_role').hide();
        }
        
        function save(id)
        {
        	var name=$('#role_name_'+id).val()
            $.ajax({
                type: 'post',
                url: "{{ route('updateRole')}}",
                data: "id="+id+"&name="+name,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                if($.isEmptyObject(response.errors)){
      			        window.location.href="{{url('/roles-permissions')}}?show=1"
      			      			
                }else{
                	$.each( response.errors, function( key, value ) {
                		$('#edit_error_'+key).html(value)
                	})
                }
                
                	
                 
                },
            });
        }
        
 function subModuleClick(subModule,roleId,permissionType) {
 		 $.ajax({
            type: 'post',
            url: "{{route('permisisonUpdate')}}",
            data:"subModule="+subModule+"&roleId="+roleId+"&permissionType="+permissionType+"",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function () {
              
            }
          });
      };
      function funModuleClick(funModule,roleId,permissionType) {
 		 $.ajax({
            type: 'post',
            url: "{{route('funPermissionUpdate')}}",
            data:"funModule="+funModule+"&roleId="+roleId+"&permissionType="+permissionType+"",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function () {
              
            }
          });
      };
     
     function getRole(role_id)
     {
        var spinner = $('#loader_'+role_id);
         spinner.show();
          $.ajax({
                type: 'get',
                url: "/rules/"+role_id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function (data) {
                 spinner.hide();
                  $('#body_data_'+role_id).html(data);
                }
          });
     }
      function closeButton()
     {
     	$('.user_name').show();
    	$('.user_id').hide();
    	$('.user_edit').show();
    	$('.delete_role').show();
     } 
                 setTimeout(function() {
    	$('#success').hide();
     }, 3000);
        
     
 
 </script>  
 
    