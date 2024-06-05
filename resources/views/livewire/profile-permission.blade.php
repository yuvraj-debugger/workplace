<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-head-box">
                <h3>Roles and Permissions</h3>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Roles and Permissions</li>
                    </ol>
                </nav>
            </div>
            <!-- <div class="add_module ">
                <a class="module_button"  wire:click="addform()" data-bs-toggle="modal" data-bs-target="#personalInfo"   href="javascript:void(0);"><i class="fa-solid fa-plus"></i> Manage Roles</a>
            </div> -->

            <div class="pageFilter mb-3">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="row">
                            <!-- <label for="floatingSelect">Month</label> -->
                            <div class="col-lg-4">
                                <div class="form-group mt-0">
                                    <select class="form-control">
                                        <option>Select Month</option>
                                        <option>January</option>
                                        <option>February</option>
                                        <option>March</option>
                                        <option>April</option>
                                        <option>May</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mt-0">
                                    <!-- <label>Year</label> -->
                                    <select class="form-control">
                                        <option>Select Year</option>
                                        <option>2018</option>
                                        <option>2019</option>
                                        <option>2020</option>
                                        <option>2021</option>
                                        <option>2022</option>
                                        <option>2023</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="leftFilters rolesFilter">
                                    <button class="btn btn-mark">
                                        <span><img src="http://127.0.0.1:8000/images/checkMarkIcon.svg" /></span> Mark
                                        Default Holidays
                                    </button>
                                    <button class="btn btn-search"><img src="{{ asset('images/iconSearch.svg') }}" />
                                        Search here</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="rightFilter">
                            <a class="module_button addBtn" wire:click="addform()" data-bs-toggle="modal"
                                data-bs-target="#personalInfo" href="javascript:void(0);"><i
                                    class="fa-solid fa-plus"></i> Manage Roles</a>
                        </div>
                    </div>
                </div>
            </div>
        
                <div class="accordion rolesAccordian" id="accordionExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true"
                                aria-controls="collapseOne">
                                <span><img
                                        src="{{ asset('images/greenTick.svg') }}" /></span>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse "
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form>
                                    @foreach ($modules as $k => $module)
                                        @php
                                            $selected = $this->moduleSelected($k, 1, 1,$this->emp_id);
                                        @endphp
                                        <div class="form-group mt-0 mb-4">
                                            <label class="formHead">
                                                <div class="form-check">
                                                    {{-- <input class="form-check-input" type="checkbox"
                                                    {{ $selected ? 'checked' : '' }}
                                                    wire:click="modulepermissions('{{ $k }}',$event.target.value,'{{ $role->_id }}')"> --}}
                                                {{ ucwords(str_replace('_', ' ', $module)) }}
                                                </div>
                                            </label>
                                            @foreach ($this->getsubmodules($k) as $subk => $submodule)
                                            @php
                                            $selected = $this->moduleSelected($subk,2,1,$this->emp_id);
                                            @endphp
                                                <div class="checkboxOuter mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                        {{ $selected ? 'checked' : '' }}
                                                        wire:click="submodulepermissions('{{ $submodule->_id }}',$event.target.value,'{{ $this->emp_id}}')" value="" 
                                                        id="createBankInfo">
                                                    <label class="subHead">{{ ucwords(str_replace('_', ' ', $submodule->name)) }}</label>
                                                    </div>
                                                    @foreach($this->functionData($submodule->id) as $func => $function)
                                                    @php
                                                    $selected = $this->moduleSelected($func,3,1,$this->emp_id);
                                                    @endphp
                                                    <div class="form-check">
                                                        <input class="form-check-input" {{ $selected ? 'checked' : '' }}
                                                        wire:click="functionspermissions('{{$func}}',$event.target.value,'{{$this->emp_id}}')"  type="checkbox" value="" id="createBankInfWo">
                                                        <label class="form-check-label" for="createBankInfo">
                                                            {{ucfirst(str_replace('_', ' ', $function)) }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                    @endforeach


                                </form>
                            </div>
                        </div>
                    </div>
                   
                </div>
         
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            document.addEventListener('livewire:load', function(event) {
                @this.on('userStore', (id) => {
                    console.log(id);
                    $('#' + id).modal('hide');
                });
            });
        </script>
    @endpush
