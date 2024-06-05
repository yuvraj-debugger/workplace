<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class MailQueue extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'mail_queue';

    protected $tagName = 'mail queue';

    protected $fillable = [
        '_id',
        'subject',
        'content',
        'email',
        'data',
        'view',
        'status',
        'type',
        'created_by'
    ];
}
