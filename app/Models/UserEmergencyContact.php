<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserEmergencyContact extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_emergency_contact';

    protected $tagName = 'user emergency contact';
    
    protected $fillable = [
        'user_id',
        'name',
        'relationship',
        'phone',
        'phone_two',
        'email',
        'type',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}