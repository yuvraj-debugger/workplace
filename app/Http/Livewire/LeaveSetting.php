<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LeaveType;

class LeaveSetting extends Component
{

   public $type_id, $name, $short_form, $type, $normal, $adoptive, $miscarriage, $normal_wfh_permanent, $normal_temporary_wfh, $payroll_component, $max_week_before_expected, $max_week_after_expected, $doj_month_old,$normal_max_week_before_expected,$normal_max_week_after_expected,$normal_doj_month_old,$normal_credit_resigned,$normal_credit_probation,$normal_wfh,$normal_wfh_status,$normal_permanent_max_week_before,$normal_temporary_max_week_before,$normal_permanent_max_week_after,$normal_temporary_max_week_after,$normal_not_clubbed, $adoptive_doj_month_old,$adoptive_credit_resigned,$adoptive_credit_probation,$adoptive_wfh,$adoptive_wfh_status, $adoptive_permanent_max_week_before, $adoptive_temporary_max_week_before, $adoptive_permanent_max_week_after, $adoptive_temporary_max_week_after, $adoptive_not_clubbed, $miscarriage_doj_month_old, $miscarriage_credit_resigned, $miscarriage_credit_probation, $miscarriage_wfh, $miscarriage_wfh_status, $miscarriage_permanent_max_week_before, $miscarriage_temporary_max_week_before, $miscarriage_permanent_max_week_after, $miscarriage_temporary_max_week_after, $miscarriage_not_clubbed, $adoptive_max_week_after_expected, $miscarriage_max_week_after_expected, $approval_required, $approval_days, $notification_apply, $notification, $effect_appraisal, $increase_appraisal, $effect_experience, $reduce_experience,$leave_id;
    
        protected $rules = [
            'name' => 'required',
            'short_form' => 'required',
            'type' => 'required',
            
        ];

  

    public function render(){

        $leaveTypes = LeaveType::get();
        return view('livewire.leave-setting', compact('leaveTypes'));
    }
    public function edit($leave_id){
        $laeave=LeaveType::where('_id',$leave_id)->first();
        $this->name = $laeave->name;
        $this->leave_id = $laeave->_id;
        $this->short_form = $laeave->short_form;
        $this->type = $laeave->type;
       
    }
    public function submitLeaveType(){
        $this->validate();
        $leave=LeaveType::find($this->leave_id);
        if(!empty($leave)){
            $leave->update([
                'name' => $this->name,
                'short_form' => $this->short_form,
                'type' => $this->type,
            ]);
            $this->alertSuccess('Leave Type Updated  Successfully!');
        }else{
            LeaveType::create([
                'name' => $this->name,
                'short_form' => $this->short_form,
                'type' => $this->type,
            ]);
            $this->alertSuccess('Leave Type Created Successfully!');
        }
        $this->resetData();
    }

    public function updateSetting(){
dd($this->type_id);


    }
    public function delete($leave_id){
       
        $user = LeaveType::findOrFail($leave_id);
        $user->delete();
       
    }
    public function resetData(){
        $this->name = '';
        $this->short_form = '';
        $this->type = '';
    }




    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertSuccess($msg){
        $this->dispatchBrowserEvent('alert',
                ['type' => 'success',  'message' => $msg]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertError($msg){
        $this->dispatchBrowserEvent('alert',
        ['type' => 'error',  'message' => $msg]);
    }
       /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertInfo($msg){
        $this->dispatchBrowserEvent('alert',
                ['type' => 'info',  'message' => $msg]);
    }
   
}
