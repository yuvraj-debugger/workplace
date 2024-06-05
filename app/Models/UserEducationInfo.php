<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserEducationInfo extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_education_info';

    protected $tagName = 'user education info';
    
    protected $fillable = [
        'user_id',
        'starting_date',
        'completed_date',
        'institute',
        'degree',
        'grade',
        'document',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}