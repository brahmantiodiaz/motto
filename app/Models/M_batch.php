<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_batch extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'm_batch';

    public function technology()
    {
        return $this->belongsTo(M_technology::class, 'technology_id');
    }

    public function trainer()
    {
        return $this->belongsTo(M_trainer::class, 'trainer_id');
    }

    public function assignment()
    {
      return $this->hasMany(T_board_assignment::class, 'batch_id');
    }
}
