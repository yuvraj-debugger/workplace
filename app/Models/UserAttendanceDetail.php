<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserAttendanceDetail extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_attendance_detail';

    protected $tagName = 'user attendance detail';
    
    protected $fillable = [
        'attendance_id',
        'punch_in',
        'punch_out'
    ];

    public function attendance()
    {
        return $this->belongsTo(UserAttendance::class);
    }
}