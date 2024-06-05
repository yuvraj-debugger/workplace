<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class Policy extends Model
{
    use HasFactory,ModelLog;

    protected $table = "policy_management";

    protected $tagName = 'policy management';

    protected $fillable = [
        '_id',
        'policy_name',
        'description',
        'department_id',
        'upload_policy',
        'status',
        'type',
        'created_by'
    ];


    public function getDepartment()
    {
        $department = Employeedepartment::where('_id', $this->department_id)->first();
        return ! empty($department) ? $department->title : '';
    }

    public static function getImage($key)
    {
        $value = self::where('upload_policy', $key)->first();
        return ! empty($value) ? $value->upload_policy : null;
    }

    public function CreatedBy()
    {
        $user = User::where('_id', $this->created_by)->first();
        return ! empty($user) ? $user->first_name . ' ' . $user->last_name : "";
    }
}
