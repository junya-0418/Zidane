<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'date',
        'match_type',
        'home_team_id',
        'away_team_id',
        'score',
        'stadium_id'
    ];

    public function hometeam()
    {
        return $this->belongsTo('App\Team', 'home_team_id');
    }

    public function awayteam()
    {
        return $this->belongsTo('App\Team', 'away_team_id');
    }

    public function stadium() {
        return $this->belongsTo('App\Stadium', 'stadium_id');
    }
}
