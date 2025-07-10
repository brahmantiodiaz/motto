<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class D_batch_student extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'd_batch_student';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function batch()
    {
        return $this->belongsTo(M_batch::class, 'batch_id');
    }


}
