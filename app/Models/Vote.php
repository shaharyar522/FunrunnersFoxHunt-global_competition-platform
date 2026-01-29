<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'user_id',
        'contestant_id',
        'voting_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }

    public function voting()
    {
        return $this->belongsTo(Voting::class, 'voting_id', 'voting_id');
    }
}
