<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class Employeedesignation extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'employee_designation';

    protected $tagName = 'employee designation';

    protected $fillable = [
        'title',
        'created_by',
        'status',
        'type'
    ];
}
