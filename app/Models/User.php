<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use App\Traits\ModelLog;

class User extends Authenticatable
{

    protected $connection = 'mongodb';

    use HasApiTokens,ModelLog;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $tagName = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'name',
        'email',
        'personal_email',
        'password',
        'first_name',
        'last_name',
        'photo',
        'date_of_birth',
        'joining_date',
        'contact',
        'department',
        'designation',
        'reporting_manager',
        'app_login',
        'email_notification',
        'workplace',
        'type',
        'status',
        'employee_id',
        'user_role',
        'created_by',
        'gender',
        'whatsapp',
        'nationality',
        'religion',
        'blood_group',
        'marital_status',
        'spouse_employment',
        'children',
        'passport_number',
        'passport_expiry_date',
        'notes',
        'probation_period',
        'shift_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url'
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->getAttribute('password');
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->getAttribute('email');
    }

    public function getRememberToken()
    {
        return $this->getAttribute('remember_token');
    }

    public function getdesignation()
    {
        return Employeedesignation::where('_id', $this->designation)->first();
    }

    public function designationname()
    {
        return Employeedesignation::where('_id', $this->designation)->value('title');
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class);
    }

    public function joiningDetail()
    {
        return $this->hasOne(UserJoiningDetail::class);
    }

    public function additionalInfo()
    {
        return $this->hasOne(UserAdditionalInfo::class);
    }

    public function officialContact()
    {
        return $this->hasOne(UserOfficialContact::class);
    }

    public function families()
    {
        return $this->hasMany(UserFamilyInfo::class);
    }

    public function educationDetails()
    {
        return $this->hasMany(UserEducationInfo::class);
    }

    public function experienceDetails()
    {
        return $this->hasMany(UserExperienceInfo::class);
    }

    public function emergencyContacts()
    {
        return $this->hasMany(UserEmergencyContact::class);
    }

    public function documents()
    {
        return $this->hasMany(UserDocument::class);
    }

    public function bankDetail()
    {
        return $this->hasOne(UserBankInfo::class);
    }

    public function statutoryInfo()
    {
        return $this->hasOne(UserStatutoryInfo::class);
    }

    public function getdepartment()
    {
        return Employeedepartment::where('_id', $this->department)->first();
    }

    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        $query->where(function ($query) use ($term) {
            $query->where('designation', 'like', $term)
                ->orwhere('first_name', 'like', $term);
        });
    }

    public function getReportingmanager()
    {
        $user = User::where('_id', $this->reporting_manager)->first();
        return ! empty($user) ? $user->first_name . ' ' . $user->last_name : '';
    }

    public function getstatus()
    {
        $user = User::where('_id', $this->status)->first();
        return ! empty($user) ? $user->status : '';
    }

    public function getReportingimage()
    {
        $user = User::where('_id', $this->reporting_manager)->first();
        return ! empty($user) ? $user->photo : '';
    }

    public function getleaveemployee_name()
    {
        return Leave::where('_id', $this->first_name)->first();
    }

    public function get_userrole()
    {
        return Role::where('_id', $this->user_role)->first();
    }

    public function userrolename()
    {
        return Role::where('_id', $this->user_role)->value('name');
    }

    public function getuserLateTime()
    {
        return UserAttendance::where('user_id', $this->_id)->where('punch_in', '>=', strtotime(date('Y-m-d 09:30:00')))
            ->where('date', strtotime(date('Y-m-d')))
            ->first();
    }

    public function getuserOnTime()
    {
        return UserAttendance::where('user_id', $this->_id)->where('punch_in', '<=', strtotime(date('Y-m-d 09:30:00')))
            ->where('date', strtotime(date('Y-m-d')))
            ->first();
    }

    public static function getImage($key)
    {
        $value = self::where('photo', $key)->first();
        return ! empty($value) ? $value->photo : null;
    }

    public function departMentAll()
    {
        $depart = Employeedepartment::where('_id', $this->department)->first();
        return ! empty($depart) ? $depart->title : '';
    }

    public function checkschedule($date)
    {

        $schedule = Schedule::where('employee_id', $this->_id)->where('date',strtotime($date))->first();
        return ! empty($schedule) ? $schedule :'';
    }

    public function defaultShift()
    {
        $defaultShift = EmployeeShift::where('_id', $this->shift_id)->first();
        return $defaultShift;
    }

    public function getCurrentState()
    {
        return UserAddress::where('user_id', $this->_id)->value('current_state_id');
    }

    public function getPermanetCity()
    {
        return UserAddress::where('user_id', $this->_id)->value('permanent_city_id');
    }

    public function getPermanetState()
    {
        return UserAddress::where('user_id', $this->_id)->value('permanent_state_id');
    }

    public function getCurrentCity()
    {
        return UserAddress::where('user_id', $this->_id)->value('current_city_id');
    }

    public function getCurrentCountry()
    {
        $userAddress_id = UserAddress::where('user_id', $this->_id)->first();
        if (! empty($userAddress_id)) {
            $country_id = Country::where('_id', $userAddress_id->current_country_id)->first();
            return $country_id ? $country_id->name : '';
        }
    }

    public function getCurrentZipcode()
    {
        return UserAddress::where('user_id', $this->_id)->value('current_zipcode');
    }

    public function getCurrentAddress()
    {
        return UserAddress::where('user_id', $this->_id)->value('current_address');
    }

    public function getPermanentCountry()
    {
        $userAddress_id = UserAddress::where('user_id', $this->_id)->first();
        if (! empty($userAddress_id)) {
            $country_id = Country::where('_id', $userAddress_id->permanent_country_id)->first();
            return $country_id ? $country_id->name : '';
        }
    }

    public function getPermanetAddress()
    {
        return UserAddress::where('user_id', $this->_id)->value('permanent_address');
    }

    public function getZipAddress()
    {
        return UserAddress::where('user_id', $this->_id)->value('permanent_zipcode');
    }

    public function getPermanentState()
    {
        return UserAddress::where('user_id', $this->_id)->value('permanent_state_id');
    }

    public function getPermanentCity()
    {
        return UserAddress::where('user_id', $this->_id)->value('permanent_city_id');
    }

    public function getNotes()
    {
        return UserAddress::where('user_id', $this->_id)->value('notes');
    }

    public function getLeaves($date)
    {
        $leaves = Leave::where('name', $this->_id)->where('type', '1')->where('status','2')
            ->where('from_date', '<=', Carbon::createFromTimestamp($date, '+0100'))
            ->where('to_date', '>=', Carbon::createFromTimestamp($date, '+0100'))
            ->first();
        if (! empty($leaves->leave_type)) {
            if ($leaves->leave_type == '1') {
                if(($leaves->from_sessions== '1') && ($leaves->to_sessions =='1')){
                    return 'CL:P';
                }elseif (($leaves->from_sessions== '2') && ($leaves->to_sessions =='2')){
                    return 'P:CL';
                }
                return 'CL';
            } elseif ($leaves->leave_type == '2') {
                if(($leaves->from_sessions == '1') && ($leaves->to_sessions =='1')){
                    return 'SL:P';
                }elseif (($leaves->from_sessions== '2') && ($leaves->to_sessions =='2')){
                    return 'P:SL';
                }
                return 'SL';
            } elseif ($leaves->leave_type == '3') {
                if(($leaves->from_sessions== '1') && ($leaves->to_sessions =='1')){
                    return 'EL:P';
                }elseif (($leaves->from_sessions== '2') && ($leaves->to_sessions =='2')){
                    return 'P:EL';
                }
                return 'EL';
            } elseif ($leaves->leave_type == '4') {
                if(($leaves->from_sessions== '1') && ($leaves->to_sessions =='1')){
                    return 'LOP:P';
                }elseif (($leaves->from_sessions== '2') && ($leaves->to_sessions =='2')){
                    return 'P:LOP';
                }
                return 'LOP';
            } elseif ($leaves->leave_type == '5') {
                if(($leaves->from_sessions== '1') && ($leaves->to_sessions =='1')){
                    return 'CO:P';
                }elseif (($leaves->from_sessions== '2') && ($leaves->to_sessions =='2')){
                    return 'P:CO';
                }
                return 'CO';
            } elseif ($leaves->leave_type == '6') {
                if(($leaves->from_sessions== '1') && ($leaves->to_sessions =='1')){
                    return 'BE:P';
                }elseif (($leaves->from_sessions== '2') && ($leaves->to_sessions =='2')){
                    return 'P:BE';
                }
                return 'BE';
            } elseif ($leaves->leave_type == '7') {
                if($leaves->from_sessions== '1' && $leaves->to_sessions =='1'){
                    return 'ML:P';
                }elseif ($leaves->from_sessions== '2' && $leaves->to_sessions =='2'){
                    return 'P:ML';
                }
                return 'ML';
            } elseif ($leaves->leave_type == '8') {
                if($leaves->from_sessions== '1' && $leaves->to_sessions =='1'){
                    return 'PL:P';
                }elseif ($leaves->from_sessions== '2' && $leaves->to_sessions =='2'){
                    return 'P:PL';
                }
                return 'PL';
            }elseif ($leaves->leave_type == '9') {
                if(($leaves->from_sessions== '1') && ($leaves->to_sessions =='1')){
                    return 'EI:P';
                }elseif (($leaves->from_sessions== '2') && ($leaves->to_sessions =='2')){
                    return 'P:EI';
                }
                return 'EI';
            }
        }
    }
}
