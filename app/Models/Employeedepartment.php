<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class Employeedepartment extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'employee_department';

    protected $tagName = 'employee department';

    protected $fillable = [
        'title',
        'created_by',
        'status',
        'type'
    ];
}
