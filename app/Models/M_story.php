<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_story extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'm_story';

    public function sow()
    {
      return $this->hasMany(D_story_sow::class, 'story_id');
    }
    public function att()
    {
      return $this->hasMany(D_story_att::class, 'story_id');
    }
}
