<x-admin-layout>
<style>
.ck-editor__editable {
	min-height: 500px;
}
</style>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Add Policy</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Add Policy</li>
				</ol>
			</nav>
		</div>
		<form class="policyForm" method="post" class="px-3" enctype="multipart/form-data"
			id="addPolicy">
			@csrf
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Policy Name</label> <span class="text-danger">*</span><input
							type="text" id="policy_name" placeholder="Policy name"name="policy_name"
							class="form-control" /> <span class="text-danger error"
							id="error_policy_name"></span>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
						<label>Description</label> <span class="text-danger">*</span>
						<textarea id="description" name="description"
										class="form-control" rows="5" cols="80"
										placeholder="Description"  ></textarea> <span class="text-danger error"
							id="error_description"></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Upload Policy </label><span class="text-danger">*</span><input
							type="file" class="form-control" name="upload_policy" id="upload_policy">
							 <span class="text-danger error"
							id="error_upload_policy"></span>
					</div>
				</div>
				<div class="form-group text-end">
					<button type="button" class="btn btn-secondary modalcanceleffect"
						data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	
	<script>
	 ClassicEditor
    .create( document.querySelector( '#description' ),{
        ckfinder: {
         uploadUrl:"{{route('ckeditorUpload',['_token'=>csrf_token()])}}",
        
        }
    })
    .catch( error => {
        console.error(error);
    });
	
	
			$('#addPolicy').on('submit', function (event) {
    		event.preventDefault();
    		var formData = new FormData(this);
  			$.ajax({
                type: 'post',
                url: "{{ route('createPolicy')}}",
                data: formData,
                contentType:false,
                processData:false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
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
