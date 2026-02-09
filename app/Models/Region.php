<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contestant;
class Region extends Model
{
    protected $fillable = [
        'name',
    ];

    public function contestants()
    {
        return $this->hasMany(Contestant::class);
    }
}
