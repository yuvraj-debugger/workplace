<x-admin-layout>
<style>
.ck-editor__editable {
	min-height: 500px;
}
</style>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Update Policy </h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Update Policy</li>
				</ol>
			</nav>
		</div>
		<form method="post" class="px-3" enctype="multipart/form-data"
			id="updatePolicy">
			@csrf
						<input type="hidden" name="policy_id" id="policy_id" value="{{$policyUpdated->_id}}">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Policy Name</label> <span class="text-danger">*</span><input
							type="text" id="policy_name" name="policy_name" value="{{$policyUpdated->policy_name}}"
							class="form-control" /> <span class="text-danger error"
							id="error_policy_name"></span>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
						<label>Description</label> <span class="text-danger">*</span>
						<textarea id="edit_description" name="description"
										class="form-control" rows="5" cols="80"
										placeholder="Description"  >{{$policyUpdated->description}}</textarea> <span class="text-danger error"
							id="error_description"></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
				<input id="img" type="file" class="form-control" name="upload_policy"
					style="display: none;" > <span id="profile_file_name"></span>
				<a id="blah" target="_blank" href="{{! empty($policyUpdated->upload_policy) ? $policyUpdated->getImage($policyUpdated->upload_policy) : ''}}"><i class="fa fa-file" aria-hidden="true"></i>
				</a><br /> 
					
					<label for="img" class="btn btn-default"><i
					class="fa-solid fa-upload"></i> Upload Document</label><br />
				<br />
				
			</div>
				</div>
				<div class="form-group text-center">
					<button type="button" class="btn btn-secondary me-1 modalcanceleffect"
						data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script>
	

	img.onchange = evt => {
      	const [file] = img.files
      	if (file) {
      	$('#profile_file_name').text(file.name);
        blah.src = URL.createObjectURL(file)
      	}
      	
  	}
  	
  		 ClassicEditor
    .create( document.querySelector( '#edit_description' ),{
        ckfinder: {
         uploadUrl:"{{route('updateckeditorUpload',['_token'=>csrf_token()])}}",
        
        }
    })
    .catch( error => {
        console.error(error);
    });
  	
    
    
    
    $('#updatePolicy').on('submit', function (event) {
    		event.preventDefault();
    		    		var formData = new FormData(this);
    		
  			$.ajax({
                type: 'post',
                url: "{{ route('updatePolicy')}}",
                data: formData,
                contentType:false,
                processData:false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                console.log(data);
                $('.error').html('');
                if($.isEmptyObject(data.errors)){
                window.location = "/policy-index";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#error_'+key).html(value)
                	})
                }
            	} 
                
            });

		});
    </script>
</x-admin-layout>
