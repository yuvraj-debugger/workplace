<?php
namespace App\Http\Livewire;

use App\Models\Leave;
use App\Models\User;
use App\Models\UserAttendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Role;
use Livewire\WithPagination;

class AdminLeaves extends Component
{
    use WithPagination;

    public $name, $from_date, $to_date, $remaining_leaves, $leave_type, $status, $reason, $user_id;

    public $month, $year, $days;

    public $search_designation;
    
    public $checked = [];
    
    public $inputs = [];
    
    public $selectAll = false;
    
    public $selectPage = false;
    
    public $ids = [];
    
    public $allids = [];

    public $hideaddtitle = false;

    public $hideedittitle = false;


    public $search_status = '';

    public $search_leave_type = '';

    public $fromsearch_date = '';

    public $tosearch_date = '';

 

    public $created_id ;
    
    protected $rules = [
        'name' => 'required',
        'leave_type' => 'required',
        'from_date' => 'required',
        'to_date' => 'required',
        'remaining_leaves' => 'required',
        'status' => 'required',
        'reason' => 'required|regex:/^[a-zA-Z0-9 ]*$/'
    ];

    public function edit($user_id)
    {
        $this->resetValidation();
        $this->hideedittitle = true;
        $this->hideaddtitle = false;

        $user = Leave::where('_id', $user_id)->first();
        $this->user_id = $user->_id;
        $this->name = $user->name;
        $this->from_date = $user->from_date;
        $this->leave_type = $user->leave_type;
        $this->to_date = $user->to_date;
        $this->remaining_leaves = $user->remaining_leaves;
        $this->status = $user->status;
        $this->reason = $user->reason;
    }

    public function render()
    {
        $employeecounting = User::count();
        $role = Role::where('_id', Auth::user()->user_role)->first();
        
        $pending = Leave::where('status', '1');
        if ($this->user_id) {
            $pending = $pending->where('name', $this->user_id);
        }
        if(! empty($role) && ($role->name == 'Management')){
            $userManager = User::where('reporting_manager', Auth::user()->_id)->get()
            ->pluck('_id')
            ->toArray();
            $pending = Leave::whereIn('name', $userManager)->where('status', '1');
        }
        $pending = $pending->count();

        $planned_leaves = Leave::where('leave_type', '1');
        
        
        if(! empty($role) && ($role->name == 'Management')){
            $userManager = User::where('reporting_manager', Auth::user()->_id)->get()
            ->pluck('_id')
            ->toArray();
            $planned_leaves = Leave::whereIn('name', $userManager)->where('leave_type', '1');
        }
        if ($this->user_id) {
            $planned_leaves = $planned_leaves->where('name', $this->user_id);
        }
        $planned_leaves = $planned_leaves->count();

        $unplanned_leaves = Leave::where('leave_type', '2');
        if ($this->user_id) {
            $unplanned_leaves = $unplanned_leaves->where('name', $this->user_id);
        }
        
        
        if(! empty($role) && ($role->name == 'Management')){
            $userManager = User::where('reporting_manager', Auth::user()->_id)->get()
            ->pluck('_id')
            ->toArray();
            $unplanned_leaves = Leave::whereIn('name', $userManager)->where('leave_type', '2');
        }
        
        $unplanned_leaves = $unplanned_leaves->count();
        $loss_pay = Leave::where('leave_type', '4');
        if ($this->user_id) {
            $loss_pay = $loss_pay->where('name', $this->user_id);
        }
        if(! empty($role) && ($role->name == 'Management')){
            $userManager = User::where('reporting_manager', Auth::user()->_id)->get()
            ->pluck('_id')
            ->toArray();
            $loss_pay = Leave::whereIn('name', $userManager)->where('leave_type', '4');
        }
        
        $loss_pay = $loss_pay->count();

        $count = UserAttendance::where('date', strtotime(date('Y-m-d', strtotime('now'))))->count();

        if (Auth::user()->user_role == 0) {
            
            $leaves = Leave::orderBy('_id');
            $q = Leave::orderBy('_id');
            if ($this->user_id != 'all' && $this->user_id != '') {
                $leaves = $leaves->where('name', $this->user_id);
                $q = $q->where('name', $this->user_id);
            }
        } else {
            $allUser= User::whereNotIn('_id',[Auth::user()->_id])->get()->pluck('_id')->toArray();
            $leaves = Leave::whereIn('name',$allUser)->orderBy('_id');
            $q = Leave::where('name', Auth::user()->_id)->orderBy('_id');
            
        }
       

        if (! empty($role) && ($role->name == 'Management')) {
            $userManager = User::where('reporting_manager', Auth::user()->_id)->get()
                ->pluck('_id')
                ->toArray();
            $leaves = Leave::whereIn('name', $userManager)->orderBy('_id');
        }
        
        if(! empty($this->created_id)){
            $leaves = Leave::where('name', $this->created_id)->orderBy('_id');
            $q = Leave::where('name', $this->created_id)->orderBy('_id');
        }
        if (! empty($role) && ($role->name == 'employee')) {
            $leaves = Leave::where('name', Auth::user()->_id)->orderBy('_id');
            $q = Leave::where('name', Auth::user()->_id)->orderBy('_id');
        }

        if (! empty($this->search_leave_type)) {
            $leaves = $leaves->where('leave_type', $this->search_leave_type);
            $q->where('leave_type', $this->search_leave_type);
            
        }
        if (! empty($this->search_status)) {

            $leaves = $leaves->where('status', $this->search_status);
        }
        if (! empty($this->fromsearch_date)) {
            $leaves = $leaves->where('from_date', '>=', $this->fromsearch_date);
        }
        if (! empty($this->tosearch_date)) {
            $leaves = $leaves->where('to_date', '<=', $this->tosearch_date);
        }
        $this->allids = $q->pluck('_id')->toArray();
        
        
        $this->ids = $leaves->orderBy('_id','DESC')->paginate(10)->toArray();
        
        $leaves = $leaves->orderBy('_id','DESC')->paginate(10);
        $employees = User::where('user_role', '!=', '0')->get();
        $userManager = User::where('reporting_manager', Auth::user()->_id)->first();

        return view('livewire.admin-leaves', compact('employees', 'leaves', 'pending', 'planned_leaves', 'unplanned_leaves', 'employeecounting', 'count', 'loss_pay', 'userManager'));
    }

    public function submit()
    {
        $role = Role::where('_id', Auth::user()->user_role)->first();
        if ((! empty($role) && $role->name == 'Management') || (! empty($role) && $role->name == 'HR') || Auth::user()->user_role == 0) {
            $validatedData = $this->validate([
                'name' => 'required',
                'leave_type' => 'required',
                'from_date' => 'required|date|before_or_equal:to_date',
                'to_date' => 'required|date|after_or_equal:from_date',
//                 'reason' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
//                 'status' => 'required'
            ]);

            $leaves = Leave::where('_id', $this->user_id)->first();
            if (! empty($leaves)) {
                $leaves->update([
                    '_id' => $this->user_id,
                    'name' => $this->name,
                    'leave_type' => $this->leave_type,
                    'from_date' => $this->from_date,
                    'to_date' => $this->to_date,
                    'reason' => $this->reason,
                    'status' => $this->status
                ]);
                if(Auth::user()->user_role == 0 || (! empty($role) && $role->name == 'HR') || (! empty($role) && $role->name == 'Management') && (empty($this->created_id)) ){
                    return redirect()->to('/leaves');
                }else{
                    return redirect()->to('/myleaves');
                }
            } else {
                
                $leaves = Leave::Create([
                    'name' => $this->name,
                    'leave_type' => $this->leave_type,
                    'from_date' => $this->from_date,
                    'to_date' => $this->to_date,
                    'reason' => $this->reason,
                    'status' => "1"
                ]);
                if(Auth::user()->user_role == 0){
                    return redirect()->to('/leaves');
                }else{
                    return redirect()->to('/myleaves');
                }
            }
        } else {
            $validateduserData = $this->validate([
                'leave_type' => 'required',
                'from_date' => 'required|before:to_date',
                'to_date' => 'required|after:from_date',
                'reason' => 'required',
            ]);
            $validateduserData['name'] = Auth::user()->_id;
            $leaves = Leave::where('_id', $this->user_id)->first();
            if (! empty($leaves)) {
                $leaves->update([
                    '_id' => $this->user_id,
                    'name' => $validateduserData['name'],
                    'leave_type' => $this->leave_type,
                    'from_date' => $this->from_date,
                    'to_date' => $this->to_date,
                    'reason' => $this->reason
                ]);
                if(Auth::user()->user_role == 0){
                    return redirect()->to('/leaves');
                }else{
                    return redirect()->to('/myleaves');
                }
            } else {
                $leaves = Leave::Create([
                    'name' => $validateduserData['name'],
                    'leave_type' => $this->leave_type,
                    'from_date' => $this->from_date,
                    'to_date' => $this->to_date,
                    'reason' => $this->reason,
                    'status' => "1"
                ]);
                if(Auth::user()->user_role == 0){
                    return redirect()->to('/leaves');
                }else{
                    return redirect()->to('/myleaves');
                }
            }
        }

        $this->emit('userStore', 'leaveModal');
    }

    public function resetData()
    {
        $this->resetValidation();
        $this->name = '';
        $this->leave_type = '';
        $this->from_date = '';
        $this->to_date = '';
        $this->remaining_leaves = '';
        $this->status = '';
        $this->reason = '';
    }

    public function addform()
    {
        $this->resetData();
        $this->name = $this->created_id;
        $this->hideedittitle = false;
        $this->hideaddtitle = true;
    }
    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->allids;
    }
    
    public function delete($user_id)
    {
        $holiday = Leave::findOrFail($user_id);
        $holiday->delete();
    }
    
    public function deleteRecords()
    {
        Leave::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
    }
    
    public function updatedSelectPage($value)
    {
        if ($value) {
            $ids = collect($this->ids['data'])->map(function ($item) {
                return $item['_id'];
            });
                $d = Leave::pluck('_id');
                $idsData = [];
                foreach ((array) $ids as $key => $id) {
                    if (is_array($id)) {
                        foreach ($id as $i) {
                            
                            $idata = $i;
                            
                            $idsData[] = $i;
                        }
                    }
                }
                // dd($idsData);
                $this->checked = $idsData;
                // dd($this->checked);
        } else {
            $this->checked = [];
        }
    }

    public function isChecked($department_id)
    {
        return in_array($department_id, $this->checked);
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
    }
    
    
    
}
