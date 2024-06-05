<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Module</h3>
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
							@foreach($allModule as $key=>$module)
							<tr>
								<td>{{++$key}}</td>
								<td>{{$module->name}}</td>
								<td>
								<a class="bin eyeButtons edit ms-0" href="{{url('get-submodule')}}/{{$module->_id}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					{{$allModule->links('pagination::bootstrap-4')}}

				</div>
			</div>
		</div>
	</div>
</div>
</x-admin-layout>