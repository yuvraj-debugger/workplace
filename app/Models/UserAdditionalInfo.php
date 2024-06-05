<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserAdditionalInfo extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_additional_info';

    protected $tagName = 'user additional info';

    protected $fillable = [
        'user_id',
        'allergies',
        'smoke',
        'drink',
        'diet',
        'hobbies',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}