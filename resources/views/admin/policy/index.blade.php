<?php 

use Illuminate\Support\Facades\Auth;
use App\Models\Role;

?>
<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Policy</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Policy</li>
				</ol>
			</nav>
		</div>
		<div class="pageFilter mb-3">
			<div class="row">
				<div class="col-xl-12">
					<div class="rightFilter attendance">
					    <?php 
                            $role=Role::where('_id',Auth::user()->user_role)->first();
                            if((Auth::user()->user_role==0) || (! empty($role) &&  $role->name=="HR" )){
                         ?>
					   <a href="{{route('addPolicy')}}" class="addBtn" role="button">Add Policy</a>
<?php }?>					   
					</div>
				</div>
			</div>
		</div>
		<div class="dashboardSection">
			<div class="dashboardSection__body">
			@if(session('success'))
			<div class="alert alert-success alert-block" id="success">{{
				session('success') }}</div>
			@endif
			@if(session('info'))
				<div class="alert alert-danger" id="info">
					{{ session('info') }}
				</div>
			@endif
				<div class="commonDataTable">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Policy Name</th>
									<th>Created By</th>
									<th>Document</th>
										    <?php 
                            $role=Role::where('_id',Auth::user()->user_role)->first();
                            if((Auth::user()->user_role==0) || (! empty($role) &&  $role->name=="HR" ) || (! empty($role) &&  $role->name=="Employee" ) || (! empty($role) &&  $role->name=="Management")){
                         ?>
									<th>Action</th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
							 @foreach($policies as $key=>$policy)
							<tr>
							<td>{{++$key}}</td>
							<td>{{$policy->policy_name}}</td>
							<td>{{$policy->CreatedBy()}}</td>
					       <td><a class="downloadBtn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Policy" target="_blank"href="{{$policy->upload_policy}}"><i class="fa-solid fa-file-arrow-down"></i></a></td>
							
							<td>
							 <div class="actionIcons">
                                             <ul>
                                               @if((Auth::user()->user_role==0) || (! empty($role) &&  $role->name=="HR"))
                                                 <li><a class="edit"  href="/policy/update/{{$policy->_id}}"  data-bs-title="Edit Policy"><i class="fa-solid fa-pen"></i></a></li>
                                                 @endif
                                                 @if((Auth::user()->user_role==0) || (! empty($role) &&  $role->name=="HR" ) || (! empty($role) &&  $role->name!="Employee" ))
                                                 <li><a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Policy" class="bin policyDelete ml-1"  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$policy->id}}"><i class="fa-regular fa-trash-can"></i></a></li>
                                                 @endif
                                             </ul>
                                         </div>
                          		</td>
							</tr>
							@endforeach
							</tbody>
						</table>
						{{$policies->links()}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>

  $(".policyDelete").click(function(){
        var id = $(this).data("id");
        $.ajax({
                type: 'post',
                url: "{{ route('policyDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
        });


</script>
</x-admin-layout>
