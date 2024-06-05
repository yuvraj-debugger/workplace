<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class EmployeeDeduction extends Model
{
    use HasFactory;

    protected $table = 'employee_deduction';

    protected $fillable = [
        'id',
        'addition_id',
        'name',
        'value'
    ];
}
