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
            <!-- <div wire:ignore>
            @foreach ($roles as $role)
                <div class="accordion rolesAccordian" id="accordionExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne_{{ $role->_id }}" aria-expanded="true"
                                aria-controls="collapseOne">
                                <span><img src="{{ asset('images/greenTick.svg') }}" />{{ ucfirst($role->name) }}</span>
                            </button>
                        </h2>
                        <div id="collapseOne_{{ $role->_id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form>
                                    @foreach ($role->module as $module)
                                        <h6>
                                            <label class="subHead">{{ ucwords(str_replace('_', ' ', $module->name)) }}</label>
                                        </h6>
                                        <div class="form-group mt-0 mb-4">
                                            @foreach ($module->submodule as $submodule)
                                            @php
                                            $selected = $this->moduleSelected($submodule->_id,2,1,$role->_id);
                                            @endphp
                                                <div class="checkboxOuter mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                        {{ $selected ? 'checked' : '' }}
                                                        wire:click="submodulepermissions('{{ $submodule->_id }}',$event.target.value,'{{ $role->_id }}')" value="" 
                                                        id="createBankInfo">  
                                                    <label class="subHead">{{ ucwords(str_replace('_', ' ', $submodule->name)) }}</label>
                                                    </div>
                                                    @foreach ($submodule->functions as $function)
                                                    @php
                                                    $selected = $this->moduleSelected($function->_id,3,1,$role->_id);
                                                    @endphp
                                                    <div >
                                                    <div class="form-check">
                                                        <input class="form-check-input" {{ $selected ? 'checked' : '' }}
                                                        wire:click="functionspermissions('{{ $function->_id }}',$event.target.value,'{{ $role->_id }}')"  type="checkbox" value="" id="createBankInfo">
                                                        <label class="form-check-label" for="createBankInfo">
                                                            {{ucfirst(str_replace('_', ' ', $function->name)) }}
                                                        </label>
                                                    </div>
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

                    <div class="modal fade personalInfo" wire:ignore.self id="personalInfo" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Roles </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne"></h2>
                                            <div class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="dashboardSection">
                                                        <div class="dashboardSection__body pt-0 px-0">
                                                            <div class="commonDataTable">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th> Roles Name</th>
                                                                                <th> Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($roles as $user)
                                                                                <tr>
                                                                                    <td>{{ $user->name }}</td>

                                                                                    <td>
                                                                                        <div class="actionIcons">
                                                                                            <ul>
                                                                                                <li><a class="module_data"
                                                                                                        wire:click="edit('{{ $user->id }}')"><i
                                                                                                            class="fa-solid fa-pen"></i></a>
                                                                                                </li>
                                                                                                <li><button
                                                                                                        class="bin"
                                                                                                        onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()"
                                                                                                        wire:click="delete('{{ $user->id }}')"
                                                                                                        type="button"><i
                                                                                                            class="fa-regular fa-trash-can"></i></button>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form wire:submit.prevent="sumbit" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <label for="name">Role Name<sup>*</sup></label>
                                                    <input type="text" wire:model="name" class="form-control" />
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label>Import from Role</label>
                                                    <select class="form-control">
                                                        <option value="" selected>Select </option>
                                                        @foreach ($roles as $user)
                                                            <option value="{{ $user->id }}"> {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('app_login')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mt-4">
                                                <button class="btn commonButton modalsubmiteffect">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach



            
            </div> -->
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
