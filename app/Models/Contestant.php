<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contestant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'region_id',
        'image',
        'payment_status',
        'profile_status',
        'status',
    ];

    /**
     * The votings that this contestant belongs to.
     */
    public function votings()
    {
        return $this->belongsToMany(Voting::class, 'voting_contestants', 'contestant_id', 'voting_id')
                    ->withPivot('status', 'payments')
                    ->withTimestamps();
    }

    /**
     * The voting contestant records for this contestant.
     */

    public function votingContestants()
    {
       
        return $this->hasMany(VotingContestant::class, 'contestant_id');

    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
