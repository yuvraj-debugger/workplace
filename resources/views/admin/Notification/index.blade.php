<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
	<div class="page-head-box">
			<h3>Notification</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">notification</li>
				</ol>
			</nav>
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
			  <h3>Details</h3>
			  <br/>
			 
				@foreach($readNotification as $readnotify)
				 <p>{{$readnotify->getData()}}</p>
			@endforeach
			{{$readNotification->links('pagination::bootstrap-4')}}
			</div>
		</div>
	</div>
</div>
</x-admin-layout>
