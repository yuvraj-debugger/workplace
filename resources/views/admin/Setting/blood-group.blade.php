<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Blood Group</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Blood Group</li>
				</ol>
			</nav>
		</div>
		<div class="pageFilter mb-3">
		 <div class="col">
            <div class="rightFilter">
                <a class="addBtn"  data-bs-toggle="modal" href="javascript:void(0);" data-bs-target="#bloodModal" onclick="$('.error').html('')"><i class="fa-solid fa-plus"></i> Add Blood Group</a>
            </div>
          </div>
		</div>
		   @if(session('success'))
                    <div class="alert alert-success" id="success">
                        {{ session('success') }}
                    </div>
				@endif
				   @if(session('info'))
                    <div class="alert alert-danger" id="info">
                        {{ session('info') }}
                    </div>
				@endif
		 <div class="dashboardSection__body">
                    <div class="commonDataTable">
                        <div class="table-responsive">
                         <div class="deleteSelection">
                                <a href="javascript:void(0);" id="deleteAll"  style="display: none;">Delete</a>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><div class="form-check">
                                                <input class="form-check-input select_all_ids"  type="checkbox" value="" id="flexCheckDefault"> 
                                              </div></th>
                                        <th>Blood Group</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @if(empty($bloodGroup) || count($bloodGroup) <= 0)
                                        <tr><td class="text-center" colspan="9">No Data Found</td></tr>
                                    @else
                                @foreach($bloodGroup as $groupName)
                                        <tr> 
                                        <td><div class="form-check">
                                                <input class="form-check-input userDelete"  name="single_ids" type="checkbox" value="{{$groupName->_id}}" id="flexCheckDefault">
                                                </div></td>
                                       <td>{{$groupName->blood_group}}</td>
                                       <td>
                                          <div class="actionIcons">
                                            <ul>
                                              <li><a class="edit" data-bs-toggle="modal"  onclick="editBlood('{{ $groupName->id }}')"  href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li>
                                              
                                              <li"><button class="bin bloodDelete policyDelete ml-1"  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$groupName->id}}"><i class="fa-regular fa-trash-can"></i></button></li>
                                            </ul>
                                          </div>
                                         </td>
                                     
                                 </tr>
                                 @endforeach
                                 @endif
                                </tbody>
                            </table>
                            {{$bloodGroup->links('pagination::bootstrap-4')}}

                        </div>
                    </div>
                </div>
            </div>  
	</div>
<div class="modal fade commonModalNew" id="bloodModal" tabindex="-1" aria-labelledby="bloodModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="bloodModalLabel">Add Blood Group</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="addBlood">
					@csrf
					<div class="col-lg-12">
                            <div class="form-group">
                                <label>Blood Group</label>
                                <input type="text" id="blood_group" class="form-control" value="" name="blood_group">
                                     <span class="text-danger error" id="errorss_blood_group"></span> 
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
<div class="modal fade commonModalNew" id="updatebloodModal" tabindex="-1" aria-labelledby="updatebloodModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="updateModalLabel">Edit Blood Group</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form method="post" enctype="multipart/form-data" id="updateBlood">
					@csrf
          <input type="hidden" name="blood_id"  id="blood_id" value="">
					
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Blood Group</label>
                    <input type="text" id="edit_blood_group" class="form-control" value="" name="blood_group">
                          <span class="text-danger error" id="errors_blood_group"></span> 
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
                </div>
            </div>
          </form>
      </div>
     
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
                url: "{{ route('multipleDeleteBlood')}}",
                data: "all_ids="+all_ids+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                   location.reload(true);
                }
            });
});


function editBlood(id)
{
  $('#updatebloodModal').modal('show');
  $('#blood_id').val(id);
  
  
      $.ajax({
                type: 'post',
                url: "{{ route('editBlood')}}",
                data: "id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#edit_blood_group').val(data.blood_group);
                $('.error').html('')
                
                },
            });

}

$('#updateBlood').submit(function(e) {
            e.preventDefault();
                    var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('updateBlood')}}",
                data:  formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/blood-group";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#errors_'+key).html(value)
                	})
                }
                },
            });
        });
  $('#addBlood').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('addBlood')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/blood-group";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#errorss_'+key).html(value)
                	})
                }
                },
            });
        });
 $(".bloodDelete").click(function(){
        var id = $(this).data("id");
        $.ajax({
                type: 'post',
                url: "{{ route('bloodDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
        });
        setTimeout(function() {
	$('#success').hide();
 }, 3000);
 
 
    setTimeout(function() {
	$('#info').hide();
 }, 3000);
</script>
</x-admin-layout>