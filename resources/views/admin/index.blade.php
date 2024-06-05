<?php

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

?>
<x-admin-layout>
    <?php
    $role=Role::where('_id',Auth::user()->user_role)->first();
    ?>
   
    @if(!empty($role)&&($role->name=='Employee'))
    
        <livewire:home-employee> 
    @else  
        <livewire:coming-soon> 
    @endif

</x-admin-layout>