<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    protected $primaryKey = 'voting_id';

    protected $fillable = [
        'title',
        'creationdate',
        'status'
    ];


    public function votingContestants()
    {
        return $this->hasMany(VotingContestant::class, 'voting_id', 'voting_id');
    }

    public function contestants()
    {

        return $this->belongsToMany(Contestant::class, 'voting_contestants', 'voting_id', 'contestant_id')
            ->withPivot('status', 'payments')
            ->withTimestamps();
    }
}
