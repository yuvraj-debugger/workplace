<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = "notifications";

    protected $fillable = [
        'type',
        'data',
        'notifiable',
        'read_at',
        'status',
        'type',
        'created_by'
    ];

    public function getuser()
    {
        $users = User::where('_id', $this->created_by)->first();
        return ! empty($users) ? ucfirst($users->first_name) . ' ' . $users->last_name . ' ' . '(' . $users->employee_id . ')' : '';
    }

    public function getData()
    {
        $notificationRead = Notification::where('_id', $this->_id)->first();
        $userAttendance = UserAttendance::where('user_id', $notificationRead->created_by)->where('date', strtotime(date('Y-m-d')))->first();
        if ($notificationRead->data == 'Leave Request') {
            return $this->getuser() . ' ' . 'Leave Request is pending';
        } elseif (($notificationRead->data == 'Late arrival') && (! empty($userAttendance))) {
            return 'Late Arrival alert' . ' - ' . $this->getuser() . '-' . date('H:i', $userAttendance->punch_in);
        } elseif ($notificationRead->data == 'Absent') {
            return $this->getuser() . ' ' . 'is Absent today';
        }
    }
}
