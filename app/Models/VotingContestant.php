<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class VotingContestant extends Model
{

    protected $fillable = ['voting_id', 'contestant_id', 'payments', 'status'];


    public function contestant()
    {

        return $this->belongsTo(Contestant::class, 'contestant_id');

    }

    public function voting()
    {

        return $this->belongsTo(Voting::class, 'voting_id');

    }

    


}
