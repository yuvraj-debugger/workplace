<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Activity Details</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">user-activities</li>
				</ol>
			</nav>
		</div>
		
		<?php
if (! empty($systemLogs->old_value)) {
    $olds = json_decode($systemLogs->old_value);
    
    foreach ($olds as $key => $old) {

        echo $key .' '. ' : '.' ' . $old . '<br/>';
    }
} else {
    $new_value = json_decode($systemLogs->new_value);
    if (! empty($new_value)) {
        foreach ($new_value as $key => $new) {
            
            echo $key .' '. ' : '.' ';
            print_r($new);
            echo '<br/>';
        }
    }
}
?>
	</div>
</div>
</x-admin-layout>
