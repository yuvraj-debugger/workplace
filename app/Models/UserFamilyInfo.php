<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserFamilyInfo extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_family_info';

    protected $tagName = 'user family info';

    protected $fillable = [
        'user_id',
        'name',
        'relationship',
        'phone',
        'address',
        'date_of_birth',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}