<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserJoiningDetail extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_joining_detail';
    
    protected $tagName = 'user joining detail';
    

    protected $fillable = [
        'user_id',
        'confirmation_date',
        'notice_period',
        'probation_period',
        'other_terms',
        'notes',
        'confirmation_check',
        'hr_confirmation_date',
        'rm_confirmation_date',
        'rm_rejection_date',
        'hr_rejection_date',
        'status',
        'updated_rm',
        'updated_hr',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getUserDetails()
    {
        $users = User::where('_id',$this->user_id)->where('status','1')->first();
        return ! empty($users) ? $users :'';
    }
    public function getRm()
    {
        $user = User::where('_id',$this->updated_rm)->first();
        return ! empty($user) ? $user->first_name. ' ' .$user->last_name : '';
    }
    public function getManager()
    {
        $user = User::where('_id',$this->user_id)->first();
        $manager = User::where('_id',$user->reporting_manager)->first();
        if(! empty($manager)){
           return $manager->first_name .' '. $manager->last_name;
            
        }
    }
}