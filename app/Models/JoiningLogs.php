<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class JoiningLogs extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_joining_details_log';

    protected $tagName = 'user joining details log';

    protected $fillable = [
        'user_id',
        'joining_details_id',
        'reason',
        'type',
        'status',
        'created_by',
        'updated_by'
    ];
}
