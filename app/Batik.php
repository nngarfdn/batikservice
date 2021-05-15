<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batik extends Model
{
    protected $fillable = [
        'nama', 'asal', 'makna', 'foto'
    ];
}
