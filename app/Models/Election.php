<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = ['title','start_date','end_date','active'];

 public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function voters()
{
    return $this->belongsToMany(User::class, 'votes', 'election_id', 'voter_id');
}
}
