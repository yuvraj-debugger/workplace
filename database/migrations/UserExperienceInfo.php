<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class UserExperienceInfo extends Model
{
    use HasFactory;

    protected $table='user_experience_info';
    protected $fillable = [
        'user_id','company_name','designation','employee_type','relevant_experience','skills','employee_id','net_pay','company_location','company_website','manager_name', 'manager_designation', 'manager_contact', 'manager_email', 'verification_status', 'leaving_reason', 'documents', 'period_from', 'period_to'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}