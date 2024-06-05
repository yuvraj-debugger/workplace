<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-head-box">
                <h3> {{Auth::user()->user_role != 0 ?ucwords(Auth::user()->get_userrole()->name):'Admin'}} Dashboard</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
            <div class="form-group">
                <h4 class="text-center">Coming Soon..</h4>
            </div>
        </div>
    </div>
</div>
