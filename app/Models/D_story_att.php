<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class D_story_att extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'd_story_att';

    public function story()
    {
        return $this->belongsTo(M_story::class, 'story_id');
    }
}
