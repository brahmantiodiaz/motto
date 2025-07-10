<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_project_board extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 't_project_board';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function batch()
    {
        return $this->belongsTo(M_batch::class, 'batch_id');
    }
    
    public function story()
    {
        return $this->belongsTo(M_story::class, 'story_id');
    }
}
