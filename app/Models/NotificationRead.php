<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class NotificationRead extends Model
{
    use HasFactory;

    protected $table = "notification_read";

    protected $fillable = [
        'notification_id',
        'read',
        'status',
        'type',
        'created_by'
    ];

    public function getUserName()
    {
        $notificationRead = Notification::where('_id', $this->notification_id)->first();
        $user = User::where('_id', $notificationRead->created_by)->first();
        return ! empty($user) ? $user->first_name . ' ' . $user->last_name . ' ' . '(' . $user->employee_id . ')' : '';
    }

    public function getData()
    {
        $notificationRead = Notification::where('_id', $this->notification_id)->first();
        $userAttendance = UserAttendance::where('user_id', $notificationRead->created_by)->where('date', strtotime(date('Y-m-d')))->first();
            if ($notificationRead->data == 'Leave Request') {
                return $this->getUserName() . ' ' . 'Leave Request is pending';
            } elseif (($notificationRead->data == 'Late arrival')&& (! empty($userAttendance))) {
                return 'Late Arrival alert' . ' - ' . $this->getUserName() . '-' .date('H:i', $userAttendance->punch_in);
            } elseif ($notificationRead->data == 'Absent') {
                return $this->getUserName() . ' ' . 'is Absent today';
        }
    }
}
