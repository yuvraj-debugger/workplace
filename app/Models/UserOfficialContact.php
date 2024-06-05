<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class UserOfficialContact extends Model
{
    use HasFactory;

    protected $table = 'user_official_contact';

    protected $fillable = [
        'user_id',
        'redmine_username',
        'discord_username',
        'skype_id',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}