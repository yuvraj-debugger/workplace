<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserAddress extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_address';

    protected $tagName = 'user address';

    protected $fillable = [
        'user_id',
        'current_country_id',
        'current_state_id',
        'current_city_id',
        'current_zipcode',
        'current_address',
        'permanent_country_id',
        'permanent_state_id',
        'permanent_city_id',
        'permanent_zipcode',
        'permanent_address',
        'present',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}