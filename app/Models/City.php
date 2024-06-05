<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class City extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'cities';
    protected $tagName = 'cities';
    
    protected $fillable = [
        'state_id',
        'name',
        'county',
        'latitude',
        'longitude'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}