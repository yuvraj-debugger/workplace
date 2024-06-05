<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class ScheduleLogs extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'schedule_logs';

    protected $tagName = 'schedule logs';

    protected $fillable = [
        '_id',
        'content',
        'date',
        'status',
        'type',
        'created_by'
    ];
}
