<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class PayrollOvertime extends Model
{
    use HasFactory;

    protected $table = "payroll_overtime";

    protected $fillable = [
        '_id',
        'name',
        'rate_type',
        'rate',
        'status',
        'type',
        'created_by'
    ];
}
