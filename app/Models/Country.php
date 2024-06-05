<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class Country extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'countries';

    protected $tagName = 'countries';

    protected $fillable = [
        'id',
        'name',
        'short_code'
    ];
}