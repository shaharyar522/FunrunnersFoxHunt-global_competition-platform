<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contestant_id',
        'question',
        'answer',
        'is_answered',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }
}
