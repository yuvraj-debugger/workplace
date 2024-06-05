<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class MasterDocument extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'master_document';

    protected $tagName = 'master document';

    protected $fillable = [
        '_id',
        'document',
        'status',
        'type',
        'created_by'
    ];
}
