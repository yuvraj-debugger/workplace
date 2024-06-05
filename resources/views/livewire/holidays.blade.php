<?php
use App\Models\Permission;
use App\Models\RolesPermission;
?>
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-head-box">
                <h3>Holidays</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Holidays</li>
                    </ol>
                </nav>
            </div>
            <div class="pageFilter mb-3">
                <div class="row">
                     <div class="col-xl-7 col-lg-6 col-md-6 col-sm-6">
                        @if(((Auth::user()->user_role==0)||(Permission::userpermissions('filters',2, 'holidays')|| RolesPermission::userpermissions('filters',2, 'holidays')) )||((Auth::user()->user_role==0)||(Permission::userpermissions('mark_default',2, 'holidays')|| RolesPermission::userpermissions('mark_default',2, 'holidays')) ))
                        <div class="leftFilters">
                            @if((Auth::user()->user_role==0)||(Permission::userpermissions('filters',2, 'holidays')|| RolesPermission::userpermissions('filters',2, 'holidays')) )
                                <div class="form-group mt-0" wire:ignore >
                                    <label for="floatingSelect">Month</label>
                                    <select class="form-select month" id="floatingSelect" wire:model="month" aria-label="Floating label select example">
                                    <option value=''>Select all</option>
                                      @php $selected_month = date('m'); @endphp
                                        @for ($i_month = 01; $i_month <= 12; $i_month++)
                                        <option value="{{sprintf('%02d',$i_month)}}">{{date('F', mktime(0,0,0,$i_month))}}</option>
                                        @endfor
                                    </select>
                                    
                                </div>
            
                               <div class="form-group mt-0" wire:ignore>
                                    <label for="floatingSelect">Year</label>
                                    <select class="form-select year" id="floatingSelectyear" wire:model="year" aria-label="Floating label select example">
                                                                        <option value=''>Select all</option>
                                    
                                      @php $selected_year = date('Y'); @endphp

                                     @for ($i_year = $selected_year-5; $i_year <= $selected_year+1; $i_year++)
                                        <option value="{{$i_year}}" {{ $selected_year == $i_year ?'selected':''}}>{{$i_year}}</option>
                                        @endfor
                                    </select>
                                    
                                </div>
                            @endif
<!--                             @if((Auth::user()->user_role==0)||(Permission::userpermissions('filters',2, 'holidays')|| RolesPermission::userpermissions('filters',2, 'holidays')) ) -->
<!--                                 <button class="btn btn-mark" data-bs-toggle="modal" data-bs-target="#defaultHolidayModal"><span><img src="{{ asset('/images/checkMarkIcon.svg')}}" /></span> Mark Default Holidays</button> -->
<!--                             @endif -->
                        </div>
                        @endif
                      
                    </div> 
                    @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2, 'holidays') || RolesPermission::userpermissions('create',2, 'holidays')) )
                    <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6">
                        <div class="rightFilter holidays">     
                            <a class="addBtn holidays mt-2"  data-bs-toggle="modal" data-bs-target="#leaveModal" href="javascript:void(0);" wire:click="$set('holidayId','')"><i class="fa-solid fa-plus"></i> Add Holidays</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($defaultModal)
                <div class="fixed inset-0 overflow-y-auto ease-out duration-400 markHolidayPopup">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <!-- This element is to trick the browser into centering the modal contents. -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modalContent" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                            <div class=" container modaldata mt-3">
                                Are you sure you want to mark selected days as holiday?
                            </div>

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <span class="mt-3   flex w-full rounded-md sm:mt-0 sm:w-auto">
                                    <button type="button"  wire:click="cancel()" class="btn btn-cancel">Cancel</button>
                                    <button wire:click="markDefault()" type="button" class="btn btn-save">
                                    Yes
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        
            <div class="dashboardSection">
                <div>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                @if ($checked)
                    <div class="btn-group">
                         <button type="button" class="btn btn-secondary modalcanceleffect" style="background-color:red;" onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()"
                         wire:click="deleteRecords()">
                            Delete ({{ count($checked) }})
                        </button>
                    </div>
                @endif
                @if ($selectPage)
                <div class="col-md-10 mb-2">
                    @if ($selectAll)
                    <div>
                        You have selected all <strong>{{ $holidays->total() }}</strong> items.
                    </div>
                    @else
                    <div>
                        You have selected <strong>{{ count($checked) }}</strong> items, Do
                        you want to Select All <strong>{{ $holidays->total() }}</strong>? <button type="button" class="btn btn-secondary ml-2" wire:click="selectAll">Select All</button>
                    </div>
                    @endif
                </div>
                @endif
                <div class="dashboardSection__body">
                    <div class="commonDataTable">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                         @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'holidays')&&RolesPermission::userpermissions('delete',2, 'holidays')) )
                                        <th>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" wire:model="selectPage" type="checkbox" value="" id="flexCheckDefault"> 
                                            </div>
                                        </th> 
                                        @endif
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Occasion</th>
                                        <th>Day</th>
                                        @if(((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'holidays')|| RolesPermission::userpermissions('update',2, 'holidays')) ) ||((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'holidays')|| RolesPermission::userpermissions('delete',2, 'holidays')) ))

                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($holidays) == 0)
                                        <tr><td class="text-center" colspan="6"> No Records to Display</td></tr> 
                                    @else
                                        @foreach($holidays as $k=>$holiday )
                                            <tr>
                                                 @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'holidays')&&RolesPermission::userpermissions('delete',2, 'holidays')) )
                                                <td>
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="checkbox" value="{{$holiday->_id}}" wire:model="checked" id="flexCheckDefault">

                                                    </div>
                                                </td>  
                                                @endif
                                                <td>{{ $holidays->firstItem() + $k  }}</td>
                                                
                                                <td>{{date('d M Y', $holiday->date)}}</td>
                                                <td>{{ucfirst($holiday->title)}}</td>
                                                <td><span class="badge badge-blue">{{date('l', $holiday->date)}}</span></td>
                                                 @if(((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'holidays')|| RolesPermission::userpermissions('update',2, 'holidays')) ) || ((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'holidays') || RolesPermission::userpermissions('delete',2, 'holidays')) ))

                                                <td>
                                                    <div class="actionIcons">
                                                        <ul>
                                                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'holidays') || RolesPermission::userpermissions('update',2, 'holidays')) )

                                                            <li><a class="edit" data-bs-toggle="modal"  data-bs-target="#leaveModal" wire:click="edit('{{ $holiday->id }}')"><i class="fa-solid fa-pen"></i></a></li>
                                                        @endif
                                                        @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'holidays')|| RolesPermission::userpermissions('delete',2, 'holidays')) )

                                                            <li><button onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" wire:click="delete('{{$holiday->id}}')" class="bin policyDelete ms-0" type="button"><i class="fa-regular fa-trash-can"></i></button></li>
                                                        @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- common pagination starts -->
                  <div class="commonPagination">
                     {{$holidays->links('pagination::bootstrap-4')}}
                    </div>
                    <!-- common pagination ends -->
                </div>
            </div>
        </div>
    </div>  
    <!-- holiday modal starts -->
    <div wire:ignore.self class="modal fade personalInfo" id="leaveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">
                        {{@$holidayId != ''?'Edit':'Add';}} Holiday
                    </h3>
                    <form wire:submit.prevent="submit" enctype="multipart/form-data" class="px-3">
                        <div class="row">
                        @for($i=0; $i< count($inputs) ; $i++)
                            

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" wire:model="inputs.{{$i}}.date" class="form-control" placeholder="Enter Date" />
                                    @error("inputs.{$i}.date") <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Occasion</label>
                                    <input type="text" wire:model="inputs.{{$i}}.title" class="form-control" placeholder="Enter Occasion" />
                                    @error("inputs.{$i}.title") <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @if(count($inputs) >1)
                                <a class="deleteRowBtn" wire:click='remove({{$i}})' href="javascript:void(0);">
                                    <p><span><img src="{{ asset('/images/binIcon.svg')}}" /></span> Delete row</p>
                                </a>
                            @endif
                            @endfor
                            <div class="col-lg-12">
                                <div class="form-group">
                                    @if(@$holidayId == '')
                                <a class="addBtn mt-0 mb-3 d-block" wire:click="addNew()" href="javascript:void(0);">Add New <img src="{{ asset('/images/addIcon.svg')}}"></a>
                                @endif

                                    <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- holidy modal ends -->  
<!-- default holiday modal starts -->
    <div wire:ignore.self class="modal fade personalInfo" id="defaultHolidayModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Mark Holiday</h3>
                    <form wire:submit.prevent="submitDefaultHolidays" enctype="multipart/form-data" class="px-3">

                        <div class="holiDays">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="sunday" wire:model="default" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault"> Sunday </label>
                            </div>  
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="monday" wire:model="default"  id="flexCheckDefault2">
                                <label class="form-check-label" for="flexCheckDefault2">Monday
                                </label>
                            </div>  
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="tuesday" wire:model="default"  id="flexCheckDefault3">
                                <label class="form-check-label" for="flexCheckDefault3">Tuesday</label>
                            </div>  
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="wednesday" wire:model="default"  id="flexCheckDefault4">
                                <label class="form-check-label" for="flexCheckDefault4">Wednesday
                                </label>
                            </div>  
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="thursday" wire:model="default"  id="flexCheckDefault5">
                                <label class="form-check-label" for="flexCheckDefault5">Thursday
                                </label>
                            </div> 
                             <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="friday" wire:model="default"  id="flexCheckDefault6">
                                <label class="form-check-label" for="flexCheckDefault6">Friday</label>
                            </div>   
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="saturday" wire:model="default"  id="flexCheckDefault7">
                                <label class="form-check-label" for="flexCheckDefault7">Saturday</label>
                            </div>
                        </div>
                        @error('default') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class="form-group mt-4">
                            <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- default holidy modal ends --> 

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
@livewireScripts

<script type="text/javascript">
    document.addEventListener('livewire:load', function (event) {

 @this.on('submitted', (id) => { 
        console.log('kk');
        $('#'+id).modal('hide');
    });
    });

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('.month').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('month', $(this).val());
            // livewire.emit('render', e.target.value)

        }); 
        $('.year').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('year', $(this).val());
            // livewire.emit('render', e.target.value)

        });
    });
</script>