<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserStatutoryInfo extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_statutory_info';

    protected $tagName = 'user statutory info';

    protected $fillable = [
        'user_id',
        'esi',
        'esi_number',
        'branch_office',
        'dispensary',
        'previous_employment',
        'nominee_detail',
        'family_particular',
        'residing',
        'pf',
        'uan',
        'pf_scheme',
        'pension_scheme',
        'pf_number',
        'pf_joinDate',
        'previousInsNo',
        'employerCode',
        'nameAddress',
        'employerEmail',
        'nomineeName',
        'nomineeRelationship',
        'nomineeAddress',
        'particularName',
        'particularDateofbirth',
        'particularRelationship',
        'residancePlace'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}