<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class EmployeeSkills extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'employee_skills';

    protected $tagName = 'employee skills';

    protected $fillable = [
        '_id',
        'employee_skill',
        'user_id',
        'status',
        'type',
        'created_by',
        'notes'
    ];
}
