<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_board_assignment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 't_board_assignment';

    public function story()
    {
        return $this->belongsTo(M_story::class, 'story_id');
    }
}
