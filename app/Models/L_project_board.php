<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class L_project_board extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'l_project_board';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projectBoard()
    {
        return $this->belongsTo(T_project_board::class, 'project_board_id');
    }
}
