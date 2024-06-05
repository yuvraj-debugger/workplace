<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class Leave extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'leaves';

    protected $tagName = 'leaves';

    protected $dates = [
        'from_date',
        'to_date'
    ];

    protected $fillable = [
        'name',
        'leave_type',
        'from_date',
        'to_date',
        'remaining_leaves',
        'reason',
        'from_sessions',
        'to_sessions',
        'str_to_date',
        'str_from_date',
        'type',
        'status',
        'created_by',
        'updated_by'
    ];

    public function getleaveemployee_name()
    {
        return User::where('_id', $this->name)->first();
    }

    public function createdBy()
    {
        $userName = User::where('_id', $this->created_by)->first();
        return ! empty($userName) ? $userName->first_name . ' ' . $userName->last_name : '';
    }

    public function updatedBy()
    {
       $user = User::where('_id',$this->name)->first();
       return $user;
    }
    public function getLeavesDay()
    {
        $userleaves =Leave::where('_id',$this->id)->first();
        if(($userleaves->from_sessions == 2) && ($userleaves->to_sessions == 2)){
            return (date('d',strtotime($userleaves->to_date) - strtotime($userleaves->from_date)) - 0.5);
        }elseif (($userleaves->from_sessions == 2) && ($userleaves->to_sessions == 1)){
            return (date('d',strtotime($userleaves->to_date) - strtotime($userleaves->from_date)) - 1);
        }elseif (($userleaves->from_sessions == 1) && ($userleaves->to_sessions == 1)){
            return (date('d',strtotime($userleaves->to_date) - strtotime($userleaves->from_date)) - 0.5);
        }
        else{
            return date('d',strtotime($userleaves->to_date) - strtotime($userleaves->from_date));    
        }
    }
}
