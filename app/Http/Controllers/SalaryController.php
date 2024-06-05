<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\PayrollAddition;
use App\Models\PayrollDeduction;
use Illuminate\Contracts\Validation\Validator;
use App\Models\EmployeeSalary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use App\Models\PayrollItems;
use Math\Parser;
use Termwind\Components\Element;
use App\Models\EmployeeAddition;
use App\Models\Leave;

class SalaryController extends Controller
{

    //
    public function index(Request $request)
    {
        $employeeName = $request->search_name ?? "";
        $status = $request->search_status ?? "";
        
        $roles = Role::get();
        $employeeSalary = EmployeeSalary::orderBy('_id','DESC');
        $employees = User::where('user_role', '!=', '0')->get();
        
        if (($employeeName) && ($employeeName != 'all') && ($employeeName != '')) {
            $employeeSalary = $employeeSalary->where('employee_id','=', $employeeName);
        }
        if (($status) && ($status != 'all') && ($status != '')) {
            $employeeSalary = $employeeSalary->where('status','=', $status);
        }
        $employeeSalary = $employeeSalary->paginate(10)->withQueryString();
        return view('admin.salary.index', compact('employees', 'roles', 'employeeSalary','employeeName'));
    }

    public function addSalary(Request $request)
    {
        $employees = User::where('user_role', '!=', '0')->get();
        $payrollAddition = PayrollItems::where('payroll_items', '1')->where('employee_id','=','All')->whereIn('category',['1','2'])->where('status','1')->get();
        $payrollDeduction = PayrollItems::where('payroll_items', '2')->where('employee_id','=','All')->whereIn('category',['1','2'])->where('status','1')->get();
        return view('admin.salary.add', compact('employees', 'payrollAddition', 'payrollDeduction'));
    }

    public function getNetSalary(Request $request)
    {
        $add=[];
        
        $added=[];
        $parameter=[];
        $payrollAddition = PayrollItems::get();
        
        
        foreach ($payrollAddition as $addition) {
            if($addition->parameter)
            { 
                if( isset($addition->fixed_value)&&$addition->fixed_value!=1)
                {
                    $add[$addition->id] =$addition->formula;
                    $parameter[]=$addition->parameter;   
                }
                else
                {
                    $added[$addition->_id]=(int)$addition->formula;
                }
            }
        }
        
        foreach($add as $key=>$value)
        {
            if(!empty($value))
            {
                if(strpos($value,'net')!='')
                {
                    
                    $match=0;
                    foreach($parameter as $param)
                    {
                        if(strpos($value,$param)!='')
                        {
                            $match=1;
                        }
                    }
                    if($match==1)
                    {
                        $added[$key]=$this->matchVal($payrollAddition,$value,$request->inputValue,$parameter);
                    }
                    else{
                        $added[$key]=$this->evalmath(str_replace('net',$request->inputValue, $value));
                    }                    
                }
                else 
                {
                    $added[$key]=$this->matchVal($payrollAddition,$value,$request->inputValue,$parameter);
                }
            }
        }
        
        
        return $added;
    }
    function matchVal($payrollAddition,$value,$inputValue,$parameter,$i=0)
    {
        
        foreach ($payrollAddition as $addition) {
            $value=str_replace($addition->parameter, '('.$addition->formula.')', $value);            
        }
        
        
        if(strpos($value,'net')!='')
        {
            $match=0;
            foreach($parameter as $param)
            {
                if(strpos($value,$param)!='')
                {
                    $match=1;
                }
            }
            if($match==1)
            {
                return $this->matchVal($payrollAddition,str_replace('net',$inputValue, $value),$inputValue,$parameter,$i);
            }
            else 
            {
                return $this->evalmath(str_replace('net',$inputValue, $value));
            }
        }
        else
        {
            $i=1+$i;
            if($i==6)
            {
                return 0;
            }
            return $this->matchVal($payrollAddition,str_replace('net',$inputValue, $value),$inputValue,$parameter,$i);            
        }
        
    }
    function evalmath($equation)
    {
        $result = 0;
        $equation = preg_replace("/[^a-z0-9+\-.*\/()%]/","",$equation);
        $equation = preg_replace("/([a-z])+/i", "\$$0", $equation);
        $equation = preg_replace("/([+-])([0-9]{1})(%)/","*(1\$1.0\$2)",$equation);
        $equation = preg_replace("/([+-])([0-9]+)(%)/","*(1\$1.\$2)",$equation);
        $equation = preg_replace("/([0-9]{1})(%)/",".0\$1",$equation);
        $equation = preg_replace("/([0-9]+)(%)/",".\$1",$equation);
        if ( $equation != "" ){
            
            $result = @eval("return " . $equation . ";" );
            
            return $result;
        }
        return $equation;
    }

    public function getAdditionEmployee(Request $request)
    {
        
        $Extraaddition=PayrollItems::where('status', '1')->where('payroll_items', '1')->whereIn('category',['1','2'])->where('employee_id','like', '%'.$request->id.'%')->get();
      
        
        $salaryslip=EmployeeSalary::where('employee_id', $request->id)->get()->pluck('_id')->toArray();
       
        
        $employeeAddition=[];
        foreach($Extraaddition as $extra)
        {
           
            $checkSum=EmployeeAddition::where('addition_id',$extra->_id)->whereIn('salary_slip_id',$salaryslip)->count();
            if(!($checkSum>=$extra->additon_number)||($extra->category==2))
            {
                $employeeAddition[]=$extra;
            }
        }
       
        return view('admin.salary.addition_component', compact( 'employeeAddition'));
    }

    public function getEmployeeDeduction(Request $request)
    {
      
        $Extraaddition=PayrollItems::where('status', '1')->where('payroll_items', '2')->whereIn('category',['1','2'])->where('employee_id','like', '%'.$request->id.'%')->get();
        
        
        $salaryslip=EmployeeSalary::where('employee_id', $request->id)->get()->pluck('_id')->toArray();
        
        
        $employeeAddition=[];
        foreach($Extraaddition as $extra)
        {
            
            $checkSum=EmployeeAddition::where('addition_id',$extra->_id)->whereIn('salary_slip_id',$salaryslip)->count();
            if(!($checkSum>=$extra->deduction_number)||($extra->category==2))
            {
                $employeeAddition[]=$extra;
            }
        }
        
        
        return view('admin.salary.addition_component', compact( 'employeeAddition'));
    }

    public function salaryCreate(Request $request)
    {
        $additiondata = [];
        $deductiondata = [];
        foreach ($request->input() as $key => $value) {
            $addition = PayrollItems::where('_id', $key)->where('payroll_items', '1')->where('status','1')->first();
            if (! empty($addition)) {
                $additiondata[] = array(
                    '_id' => $key,
                    'value' => $value,
                    'name' => $addition->name,
                    'addition_bonus'=> $addition->addition_bonus
                );
              
            } else {
                $deduction = PayrollItems::where('_id', $key)->where('payroll_items', '2')->where('status','1')->first();
                if (! empty($deduction)) {
                    $deductiondata[] = array(
                        '_id' => $key,
                        'value' => $value,
                        'name' => $deduction->name
                    );
                }
            }
        }
   
       
        $payrollAdditon = EmployeeSalary::Create([
            'employee_id' => $request->employee_id,
            'net_salary' => $request->net_salary,
            'earning' => json_encode($additiondata),
            'deduction' => json_encode($deductiondata),
            'overtime'=>! empty($request->overtime) ? $request->overtime : '0',
            'employee_deduction'=>! empty($request->employee_deduction) ? $request->employee_deduction: '0',
            'type' => '1',
            'status' => '1',
            'created_by' => Auth::user()->_id
        ]);
            foreach ($additiondata as $additionData){
                EmployeeAddition::Create([
                    'salary_slip_id'=>$payrollAdditon->_id,
                    'employee_id' => $request->employee_id,
                    'addition_id'=>$additionData['_id'],
                    'value'=>$additionData['value'],
                    'name'=>$additionData['name']
                ]);
                
            }
            foreach ($deductiondata as $deductionData){
                EmployeeAddition::Create([
                    'salary_slip_id'=>$payrollAdditon->_id,
                    'employee_id' => $request->employee_id,
                    'addition_id'=>$deductionData['_id'],
                    'value'=>$deductionData['value'],
                    'name'=>$deductionData['name']
                ]);
                
            }
       
     
        Session::flash('success', 'Salary added successfully');
    }

    public function salaryEdit(Request $request, $id)
    {
        $editSalary = EmployeeSalary::where('_id', $id)->first();
        $employees = User::where('user_role', '!=', '0')->get();
        return view('admin.salary.update', compact('editSalary', 'employees'));
    }

    public function salaryUpdate(Request $request)
    {
        $additiondata = [];
        $deductiondata = [];
        foreach ($request->input() as $key => $value) {
            $addition = PayrollItems::where('_id', $key)->where('payroll_items', '1')->first();

            if (! empty($addition)) {
                $additiondata[] = array(
                    '_id' => $key,
                    'value' => $value,
                    'name' => $addition->name,
                    'addition_bonus'=> $addition->addition_bonus
                );
            } else {
                $deduction = PayrollItems::where('_id', $key)->where('payroll_items', '2')->first();
                if (! empty($deduction)) {
                    $deductiondata[] = array(
                        '_id' => $key,
                        'value' => $value,
                        'name' => $deduction->name
                    );
                }
            }
        }
        $updatedSalary = EmployeeSalary::where('_id', $request->salary_id)->update([
            'net_salary' => $request->net_salary,
            'earning' => json_encode($additiondata),
            'deduction' => json_encode($deductiondata),
            'overtime'=>! empty($request->overtime) ? $request->overtime : '0',
            'employee_deduction'=>! empty($request->employee_deduction) ? $request->employee_deduction: '0',
            'type' => '1',
            'status' => '1',
            'created_by' => Auth::user()->_id
        ]);
        
        Session::flash('success', 'Salary updated successfully');
    }
    public function salaryDelete(Request $request)
    {
        $deleteSalary = EmployeeSalary::where('_id', $request->id)->first();
        $deleteSalary->status = '2';
        $deleteSalary->update();
        Session::flash('info', 'Salary deleted successfully');
    }
    public function generateSlip($salary_id)
    {
        $employeeSalary = EmployeeSalary::where('_id',$salary_id)->first();
        foreach (json_decode($employeeSalary->deduction) as $deductions){
            $totalDeduction =[];
            $deductionValue[] = $deductions->value;
            $totalDeduction = array_sum($deductionValue);
        }
        return view('admin.salary.slip',compact('employeeSalary','totalDeduction'));
    }
    public function generatePdf($id)
    {
        $employeeSalary= EmployeeSalary::where('_id', $id)->first();
        $addition = PayrollItems::where('payroll_items','1')->get()->pluck('_id')->toArray();
        $deduction = PayrollItems::where('payroll_items','2')->get()->pluck('_id')->toArray();
        
        $payrollAddition=EmployeeAddition::where('salary_slip_id',$id)->whereIn('addition_id',$addition)->get();
        $payrollDeduction=EmployeeAddition::where('salary_slip_id',$id)->whereIn('addition_id',$deduction)->get();
        
        $mpdf = new \Mpdf\Mpdf();
        $html =$mpdf->WriteHTML(View('admin.salary.pdf',compact( 'employeeSalary','payrollAddition','payrollDeduction')));
        $mpdf->Output();
        
    }
    public function approveStatus($salary_id)
    {
        $approveStatus = EmployeeSalary::where('_id',$salary_id)->update([
            'status'=>'3'
        ]);
        Session::flash('success', 'Salary approved successfully');
        return redirect()->to('/employee-salary-index');
    }
//     public function deletePayRoll()
//     {
//         EmployeeSalary::truncate();
//     }
}
