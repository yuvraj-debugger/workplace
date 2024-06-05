<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\PayrollAddition;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\PayrollOvertime;
use App\Models\PayrollDeduction;
use App\Models\PayrollItems;

class PayrollController extends Controller
{
    //
    public function index()
    {
        $employees= User::where('user_role','!=','0')->get();
        $tabs=isset($_GET)?(!empty($_GET)?$_GET['activetab']:"addition"):"addition";
        $payrollOvertime = PayrollOvertime::paginate(10)->withQueryString();
        $payrollAddition = PayrollItems::where('payroll_items','1')->paginate(10)->withQueryString();
        $payrollDeduction = PayrollItems::where('payroll_items','2')->paginate(10)->withQueryString();
        return view('admin.payroll.index',compact('tabs','employees','payrollAddition','payrollOvertime','payrollDeduction'));
    }
    public function addPayrollAddition(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'parameter'=>'required',
            'formula'=>'required',
//             'employee_id' =>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if(! empty($request->employee_id)){
            $payrollAdditon = PayrollItems::Create([
                'name' => $request->name,
                'category' => $request->category,
                'additon_number'=>$request->additon_number,
                'employee_id'=> ! empty($request->employee_id) ? json_encode($request->employee_id) : 'All',
                'parameter'=>$request->parameter,
                'formula'=>$request->formula,
                'fixed_value'=>! empty($request->fixed_value) ? $request->fixed_value : '0',
                'addition_bonus'=> ! empty($request->addition_bonus) ? $request->addition_bonus : '0',
                'payroll_items'=>'1',
                'status'=>'1',
                'type'=>'2',
                'created_by'=> Auth::user()->id
            ]);
        }else{
            $payrollAdditon = PayrollItems::Create([
                'name' => $request->name,
                'category' => $request->category,
                'additon_number'=>$request->additon_number,
                'employee_id'=> 'All',
                'parameter'=>$request->parameter,
                'formula'=>$request->formula,
                'fixed_value'=>! empty($request->fixed_value) ? $request->fixed_value : '0',
                'addition_bonus'=> ! empty($request->addition_bonus) ? $request->addition_bonus : '0',
                'type'=>'1',
                'payroll_items'=>'1',
                'status'=>'1',
                'created_by'=> Auth::user()->id
            ]);
        }
    
        Session::flash('success', 'Addition added successfully');
        
    }
    public function editPayrollAddition(Request $request)
    {
        $payrollAddition = PayrollItems::where('_id',$request->id)->where('payroll_items','1')->first();
        if(! empty($payrollAddition)){
            $name = $payrollAddition->name;
            $category = $payrollAddition->category;
            $employee_id = json_decode($payrollAddition->employee_id);
            $type = $payrollAddition->type;
            $parameter = $payrollAddition->parameter;
            $formula = $payrollAddition->formula;
            $fixed_value = $payrollAddition->fixed_value;
            $addition_number = $payrollAddition->additon_number;
            $addition_bonus = $payrollAddition->addition_bonus;
        }
        $data=[
            'name'=>$name,
            'category'=>$category,
            'employee_id'=>$employee_id,
            'type'=>$type,
            'parameter'=>$parameter,
            'formula'=>$formula,
            'fixed_value'=>$fixed_value,
            'addition_number'=>$addition_number,
            'addition_bonus'=>$addition_bonus
        ];
        return json_encode($data);
    }
    public function updatePayrollAddition(Request $request)
    {
        $updateAddition = PayrollItems::where('_id',$request->addition_id)->where('payroll_items','1')->first();
        if(! empty($request->employee_id)){
            $updateAddition->name =  ! empty($request->name) ? $request->name :'';
            $updateAddition->category =  ! empty($request->category) ? $request->category :'';
            $updateAddition->parameter = ! empty($request->parameter) ? $request->parameter :'';
            $updateAddition->formula = ! empty($request->formula) ? $request->formula :'';
            $updateAddition->fixed_value = ! empty($request->fixed_value) ? $request->fixed_value :'0';
            $updateAddition->employee_id = ! empty($request->employee_id) ? json_encode($request->employee_id) : 'All';
            $updateAddition->additon_number =  ! empty($request->additon_number) ? $request->additon_number:'';
            $updateAddition->addition_bonus =  ! empty($request->addition_bonus) ? $request->addition_bonus:'0';
            $updateAddition->type='2';
            $updateAddition->update();
        }else{
            $updateAddition->name =  ! empty($request->name) ? $request->name :'';
            $updateAddition->category =  ! empty($request->category) ? $request->category :'';
            $updateAddition->parameter = ! empty($request->parameter) ? $request->parameter :'';
            $updateAddition->formula = ! empty($request->formula) ? $request->formula :'0';
            $updateAddition->fixed_value = ! empty($request->fixed_value) ? $request->fixed_value :'';
            $updateAddition->additon_number =  ! empty($request->additon_number) ? $request->additon_number :'';
            $updateAddition->addition_bonus =  ! empty($request->addition_bonus) ? $request->addition_bonus:'0';
            $updateAddition->employee_id =  'All';
            $updateAddition->type='1';
            $updateAddition->update();
        }
   
        Session::flash('success', 'Addition updated successfully');
    }
    public function additionDelete(Request $request)
    {
        $additionDelete = PayrollItems::where('_id', $request->id)->where('payroll_items','1')->first();
        $additionDelete->status='2';
        $additionDelete->update();
        Session::flash('info', 'Addition deleted successfully');
    }
    public function addPayrollOvertime(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'rate_type' => 'required',
            'rate'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $payrollAdditon = PayrollOvertime::Create([
            'name' => $request->name,
            'rate_type' => $request->rate_type,
            'rate' => $request->rate,
            'status'=>'1',
            'created_by'=> Auth::user()->id
        ]);
        Session::flash('success', 'Overtime added successfully');
    }
    public function editPayrollOvertime(Request $request)
    {
        $payrollOvertime = PayrollOvertime::where('_id',$request->id)->first();
        if(! empty($payrollOvertime)){
            $name = $payrollOvertime->name;
            $rate_type = $payrollOvertime->rate_type;
            $rate = $payrollOvertime->rate;
        }
        $data=[
            'name'=>$name,
            'rate_type'=>$rate_type,
            'rate'=>$rate,
        ];
        return json_encode($data);
    }
    public function updatePayrollOvertime(Request $request)
    {
        $updateOvertime = PayrollOvertime::where('_id',$request->overtime_id)->first();
        $updateOvertime->name = $request->name;
        $updateOvertime->rate_type = $request->rate_type;
        $updateOvertime->rate = $request->rate;
        $updateOvertime->update();
        Session::flash('success', 'Overtime Updated successfully');
        
    }
    public function overtimeDelete(Request $request)
    {
        $additionDelete = PayrollOvertime::where('_id', $request->id)->first();
        $additionDelete->status='2';
        $additionDelete->update();
        Session::flash('info', 'Overtime deleted successfully');
    }
    public function addPayrollDeductions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if(! empty($request->employee_id)){
            $payrollAdditon = PayrollItems::Create([
                'name' => $request->name,
                'category' => $request->category,
                'deduction_number'=> $request->deduction_number,
                'unit_amount' => $request->unit_amount,
                'employee_id'=> ! empty($request->employee_id) ? json_encode($request->employee_id) : 'All',
                'unit_calculation'=>$request->unit_calculation,
                'parameter'=>$request->parameter,
                'formula'=>$request->formula,
                'fixed_value'=>! empty($request->fixed_value) ? $request->fixed_value : '0',
                'payroll_items'=>'2',
                'status'=>'1',
                'type'=>'2',
                'created_by'=> Auth::user()->id
            ]);
        }else{
            $payrollAdditon = PayrollItems::Create([
                'name' => $request->name,
                'category' => $request->category,
                'deduction_number'=> $request->deduction_number,
                'unit_amount' => $request->unit_amount,
                'employee_id'=> 'All',
                'unit_calculation'=>$request->unit_calculation,
                'parameter'=>$request->parameter,
                'fixed_value'=>! empty($request->fixed_value) ? $request->fixed_value : '0',
                'formula'=>$request->formula,
                'payroll_items'=>'2',
                'type'=>'1',
                'status'=>'1',
                'created_by'=> Auth::user()->id
            ]);
        }
        
        Session::flash('success', 'Deduction added successfully');
    }
    public function editPayrollDeduction(Request $request)
    {
        $payrollDeduction = PayrollItems::where('_id',$request->id)->where('payroll_items','2')->first();
        if(! empty($payrollDeduction)){
            $name = $payrollDeduction->name;
            $category = $payrollDeduction->category;
            $employee_id = json_decode($payrollDeduction->employee_id);
            $type = $payrollDeduction->type;
            $parameter = $payrollDeduction->parameter;
            $formula = $payrollDeduction->formula;
            $fixed_value = $payrollDeduction->fixed_value;
            $addition_number = $payrollDeduction->deduction_number;
        }
        $data=[
            'name'=>$name,
            'category'=>$category,
            'employee_id'=>$employee_id,
            'type'=>$type,
            'parameter'=>$parameter,
            'formula'=>$formula,
            'fixed_value'=>$fixed_value,
            'deduction_number'=>$addition_number
        ];
        return json_encode($data);
        
    }
    public function updatePayrollDeduction(Request $request)
    {
        $updateAddition = PayrollItems::where('_id',$request->deduction_id)->where('payroll_items','2')->first();
        if(! empty($request->employee_id)){
            $updateAddition->name =  ! empty($request->name) ? $request->name :'';
            $updateAddition->category =  ! empty($request->category) ? $request->category :'';
            $updateAddition->parameter = ! empty($request->parameter) ? $request->parameter : '';
            $updateAddition->formula = ! empty($request->formula) ? $request->formula : '';
            $updateAddition->fixed_value = ! empty($request->fixed_value) ? $request->fixed_value : '0';
            $updateAddition->employee_id = ! empty($request->employee_id) ? json_encode($request->employee_id) : 'All';
            $updateAddition->deduction_number = ! empty($request->deduction_number) ? $request->deduction_number : '';
            $updateAddition->type='2';
            $updateAddition->update();
        }else{
            $updateAddition->name =  ! empty($request->name) ? $request->name :'';
            $updateAddition->category =  ! empty($request->category) ? $request->category :'';
            $updateAddition->parameter = ! empty($request->parameter) ? $request->parameter : '';
            $updateAddition->formula = ! empty($request->formula) ? $request->formula : '';
            $updateAddition->fixed_value = ! empty($request->fixed_value) ? $request->fixed_value : '0';
            $updateAddition->deduction_number = ! empty($request->deduction_number) ? $request->deduction_number : '';
            $updateAddition->employee_id =  'All';
            $updateAddition->type='1';
            $updateAddition->update();
        }
        Session::flash('success', 'Deduction updated successfully');
        
    }
    public function deductionDelete(Request $request)
    {
        $additionDelete = PayrollItems::where('_id', $request->id)->where('payroll_items','2')->first();
        $additionDelete->status='2';
        $additionDelete->update();
        Session::flash('info', 'Deduction deleted successfully');
    }
}
