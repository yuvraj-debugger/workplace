<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserDocument extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_documents';

    protected $tagName = 'user documents';
    
    protected $fillable = [
        'user_id',
        'name',
        'folder_name',
        'type',
        'document',
        'notes',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}