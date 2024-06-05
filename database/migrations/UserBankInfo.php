<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class UserBankInfo extends Model
{
    use HasFactory;

    protected $table='user_bank_info';
    protected $fillable = [
        'user_id','username','bank_name','account','ifsc','pan'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}