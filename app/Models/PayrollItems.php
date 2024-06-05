<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class PayrollItems extends Model
{
    use HasFactory;

    protected $table = "payroll_items";

    protected $fillable = [
        '_id',
        'name',
        'category',
        'additon_number',
        'unit_amount',
        'unit_calculation',
        'employee_id',
        'deduction_number',
        'payroll_items',
        'parameter',
        'formula',
        'fixed_value',
        'addition_bonus',
        'status',
        'type',
        'created_by'
    ];
    public function getEmployeeName()
    {
        if(! empty(json_decode($this->employee_id))){
            $employees = User::whereIn('_id',json_decode($this->employee_id))->get();
            foreach ($employees as $employee){
                $employeeName[] = $employee->first_name.' '.$employee->last_name;
            }
            return implode(' , ', $employeeName);
        }else{
            return $this->employee_id;
        }
        
    }
}
