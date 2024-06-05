<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class BloodGroup extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'blood_group';

    protected $tagName = 'blood group';

    protected $fillable = [
        '_id',
        'blood_group',
        'status',
        'type',
        'created_by'
    ];
}
