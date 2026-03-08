<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    protected $fillable = ['name', 'party', 'image', 'election_id'];

    // Add this relationship
    public function election()
    {
        return $this->belongsTo(Election::class);
    }

     public function votes()
    {
        return $this->hasMany(Vote::class);
    }

}
