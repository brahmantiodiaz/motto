<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class D_story_sow extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'd_story_sow';

    public function M_sow()
    {
        return $this->belongsTo(M_sow::class, 'sow_id');
    }

    public function story()
    {
        return $this->belongsTo(M_story::class, 'story_id');
    }
}
