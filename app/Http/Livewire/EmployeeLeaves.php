<?php

namespace App\Http\Livewire;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class EmployeeLeaves extends Component
{
    
    public  $name,$from_date, $to_date,$remaining_leaves,$leave_type,$status,$reason,$user_id;
    public $search_designation;
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    public $hideaddtitle=false;
    public $hideedittitle=false;
    public $search_status = '';
    public $search_leave_type='';
    public $fromsearch_date = '';
    public $tosearch_date='';
     public $ids = [];
    public $allids = [];

    protected $rules = [        
        'name' => 'required',
        'leave_type' => 'required',
        'from_date' => 'required',
        'to_date' => 'required',
        'remaining_leaves' => 'required',
    
        'reason' => 'required',
             
    ];
    public function edit($user_id){
       
        $this->resetValidation();
        $this->hideedittitle=true;
        $this->hideaddtitle=false;
    
        $user=Leave::where('_id',$user_id)->first();
        $this->user_id = $user->_id;
        $this->name = $user->name;
        $this->from_date = $user->from_date;
        $this->leave_type = $user->leave_type;
        $this->to_date = $user->to_date;
        $this->remaining_leaves = $user->remaining_leaves;
       
        $this->reason = $user->reason;
        
    }
    public function render(){
        $u_id = FacadesAuth::user()->_id;
        $this->name = FacadesAuth::user()->first_name;
        $employees=User::get();
        $leaves=Leave::where('name', $u_id)->orderBy('_id');
        $q=Leave::where('name', $u_id)->orderBy('_id');
        if(!empty($this->search_leave_type)){
            $leaves=$leaves->where('leave_type',$this->search_leave_type);
            $q=$q->where('leave_type',$this->search_leave_type);
        }
        if(!empty($this->search_status)){
            $leaves=$leaves->where('status',$this->search_status);
            $q=$q->where('status',$this->search_status);
        }
        if (!empty($this->fromsearch_date)) {
            $leaves = $leaves->where('from_date', '>=', $this->fromsearch_date);
            $q = $q->where('from_date', '>=', $this->fromsearch_date);
        }
        if (!empty($this->tosearch_date)) {
            $leaves = $leaves->where('to_date', '<=', $this->tosearch_date);
            $q = $q->where('to_date', '<=', $this->tosearch_date);
        }
        $this->allids = $q->pluck('_id')->toArray();
        $this->ids = $leaves->paginate(10)->toArray();

        $leaves=$leaves->paginate(10);
        return view('livewire.employee-leaves',compact('employees','leaves'));
    }

    public function submit(){
        $this->validate();
        $Leaves=Leave::find($this->user_id);
        if(!empty($Leaves)){
            $Leaves->update([
                'name' => FacadesAuth::user()->_id,
                'leave_type' => $this->leave_type,
                'from_date' => $this->from_date,
                'to_date' => $this->to_date,
                'remaining_leaves' => $this->remaining_leaves,
                // 'status'=>$this->status,                
                'reason'=>$this->reason,
            ]);           
       }else{          
            $Leaves=Leave::Create([
                'name' => FacadesAuth::user()->_id,
                'leave_type' => $this->leave_type,
                'from_date' => $this->from_date,
                'to_date' => $this->to_date,
                'remaining_leaves' => $this->remaining_leaves,
                'status'=>'1',                
                'reason'=>$this->reason,
            ]);
        }
        $this->emit('userStore','leaveModal'); 
    }
    public function resetData(){
        $this->resetValidation();
        $this->name ='';
        $this->leave_type ='';
        $this->from_date = '';
        $this->to_date = '';
        $this->remaining_leaves = '';
        $this->status = '';
        $this->reason = '';
    }
    public function addform(){
      $this->resetData();
      $this->hideedittitle=false;
      $this->hideaddtitle=true;
    }
    public function delete($user_id){ 
        $user = Leave::findOrFail($user_id);
        $user->delete();
    }
    public function deleteRecords(){
        Leave::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->alertInfo('Selected Records were deleted Successfully');
    }
    public function deleteRecord($user_id)
    {
        $user = Leave::findOrFail($user_id);
        $user->delete();
        $this->checked = array_diff($this->checked, [
            $user_id
        ]);
        $this->alertInfo('Record deleted successfully');
    }
    public function selectAll(){
        $this->selectAll = true;
        $this->checked = $this->allids;
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $ids = collect($this->ids['data'])->map(function ($item) {
                return $item['_id'];
            });
            $d = Leave::pluck('_id');
            $idsData = [];
            foreach ((array)$ids as $key => $id) {
                if (is_array($id)) {
                    foreach ($id as $i) {


                        $idata = $i;

                        $idsData[] = $i;
                    }
                }
            }
            $this->checked = $idsData;
        } else {
            $this->checked = [];
        }
    }

    public function isChecked($department_id){
        return in_array($department_id, $this->checked);
    }

    public function updatedChecked(){
        $this->selectPage = false;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertSuccess($msg)
    {
        $this->dispatchBrowserEvent('alert',
                ['type' => 'success',  'message' => $msg]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertError($msg)
    {
        $this->dispatchBrowserEvent('alert',
        ['type' => 'error',  'message' => $msg]);
    }
       /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertInfo($msg)
    {
        $this->dispatchBrowserEvent('alert',
                ['type' => 'info',  'message' => $msg]);
    }
}
