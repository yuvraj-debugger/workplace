<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class Holiday extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'holidays';

    protected $tagName = 'holidays';

    protected $fillable = [
        'title',
        'date'
    ];
}
