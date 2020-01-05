<?php

namespace App\Repositories\Match;

use App\Match;

class MatchRepository
{
    private $eloquent;

    public function __construct(Match $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    public function find($id)
    {
        return $this->eloquent->findOrFail($id)->first();
    }

    public function all()
    {
        return $this->eloquent->all();
    }

    public function save(array $attributes)
    {
        $match = $this->eloquent->newInstance();
        $match->team_id = $attributes['team_id'];
        $match->team_lineup = $attributes['team_lineup'];
        $match->opposing_team_id = $attributes['opposing_team_id'];
        $match->match_date = $attributes['match_date'];
        $match->match_hour = $attributes['match_hour'];
        $match->save();
    }

}
