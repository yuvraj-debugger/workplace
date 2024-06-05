<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
class LeaveTypeCase extends Model{
    use HasFactory;
    
    protected $table='leave_type_cases';
    
    protected $fillable = [
        'type_id', 'name'
    ];
}
