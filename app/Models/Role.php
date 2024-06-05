<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class Role extends Model
{
    use HasFactory,ModelLog;

    protected $table = "roles";

    protected $tagName = 'roles';
    
    protected $fillable = [

        'name',
        'status',
        'type',
        'created_by'
    ];
}
