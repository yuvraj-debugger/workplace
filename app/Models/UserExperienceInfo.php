<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserExperienceInfo extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_experience_info';

    protected $tagName = 'user experience info';

    protected $fillable = [
        'user_id',
        'company_name',
        'designation',
        'employee_type',
        'relevant_experience',
        'skills',
        'employee_id',
        'net_pay',
        'company_city',
        'company_state',
        'company_country',
        'company_pincode',
        'company_website',
        'manager_name',
        'manager_designation',
        'manager_contact',
        'manager_email',
        'verification_status',
        'leaving_reason',
        'documents',
        'period_from',
        'period_to',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCountryAttribute()
    {
        // return $this->company_country;
        return Country::where('_id', $this->company_country)->value('name');
    }

    public function getImage($file_name)
    {
        $value = self::where('documents', $file_name)->first();
        return ! empty($value) ? $value->documents : null;
    }
}