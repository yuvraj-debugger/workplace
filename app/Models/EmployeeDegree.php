<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class EmployeeDegree extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'employee_degree';

    protected $tagName = 'employee degree';

    protected $fillable = [
        'degree_name',
        'created_by',
        'status',
        'type'
    ];
}
