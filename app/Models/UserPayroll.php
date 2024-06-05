<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserPayroll extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_payroll';

    protected $tagName = 'user payroll';

    protected $fillable = [
        'user_id',
        'annual_ctc',
        'basic_salary',
        'allowances',
        'deductions'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}