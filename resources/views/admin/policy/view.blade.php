<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>View Policy</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">View
						Policy</li>
				</ol>
			</nav>
		</div>
		<div>
	<table class="table table-borderd">
		<tr>
			<th>Policy Name</th>
			<td>{{$policyView->policy_name}}</td>
		</tr>
		<tr>
			<th>Created By</th>
			<td>{{$policyView->CreatedBy()}}</td>
		</tr>
		<tr>
			<th>Document</th>
			<td><a href="{{! empty($policyView->upload_policy) ? $policyView->getImage($policyView->upload_policy) : ''}}" target="_blank">{{$policyView->getImage($policyView->upload_policy)}}</a></td>
		</tr>
	</table>
</div>
		
	</div>
</div>

</x-admin-layout>
