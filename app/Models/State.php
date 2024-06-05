<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class State extends Model
{
    use HasFactory,ModelLog;

    protected $table = "states";

    protected $tagName = 'states';

    protected $fillable = [
        'country_id',
        'code',
        'name'
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}