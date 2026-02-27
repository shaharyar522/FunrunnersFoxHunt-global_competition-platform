<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VotingContestant extends Model
{
    use HasFactory;


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
