<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserBankInfo extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_bank_info';

    protected $tagName = 'user bank info';
    
    protected $fillable = [
        'user_id',
        'username',
        'bank_name',
        'account',
        'ifsc',
        'pan',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}