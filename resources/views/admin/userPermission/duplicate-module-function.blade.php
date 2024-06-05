<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Module Function</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Module</li>
				</ol>
			</nav>
		</div>

		<div class="dashboardSection__body">
			<div class="commonDataTable">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Name</th>
								<th>Action</th>

							</tr>
						</thead>
						<tbody>
							@foreach($moduleFunction as $key=>$modFunction)
							<tr>
								<td>{{++$key}}</td>
								<td>{{$modFunction->name}}</td>
								<td>
                                  <a class="edit" data-bs-toggle="modal"  onclick="editFunction('{{ $modFunction->id }}','{{ $modFunction->module_id}}','{{ $modFunction->sub_module_id}}')"  href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					{{$moduleFunction->links('pagination::bootstrap-4')}}

				</div>
			</div>
		</div>
		 
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="myModalLabel">Edit Module Function</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="addModuleFunction">
           @csrf
           <input type="hidden" name="name_id" id="name_id" value="" />
                                 <input type="hidden" name="sub_mod" id="sub_mod_id" value="" />
           
                      <input type="hidden" name="moddule_id" id="moddule_id" value="" />
           
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="name" class="form-control" name="name">
                                     <span class="text-danger error" id="error_date"></span> 
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
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
function editFunction(id,module_id,submodule_id)
{
$('#myModal').modal('show')
$('#moddule_id').val(module_id)
$('#sub_mod_id').val(submodule_id)

          $.ajax({
                type: 'post',
                url: "{{ route('assignModuleFunction')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#name').val(data.name);
                $('#name_id').val(data.id);
                
                },
            });
}
 $('#addModuleFunction').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            var mode_id = $('#moddule_id').val();
            var sub_id = $('#sub_mod_id').val()

            $.ajax({
                type: 'post',
                url: "{{ route('addModuleFunction')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
      			if($.isEmptyObject(data.errors)){
      			     window.location = "/get-module-function/"+sub_id+"/"+mode_id;
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#error_'+key).html(value)
                	})
                }
                },
            });
        });
</script>
</x-admin-layout>