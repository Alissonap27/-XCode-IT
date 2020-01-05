<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Team;

class Match extends Model
{
    public $primaryKey = 'id';
    protected $table = "match";

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function opposing_team()
    {
        return $this->belongsTo(Team::class);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function getOpposingTeam()
    {
        return $this->opposing_team;
    }

    public function getTeamLineup()
    {
        return json_decode($this->team_lineup);
    }

    public function getMatchDate()
    {
        return $this->match_date;
    }

    public function getMatchHour()
    {
        return $this->match_hour;
    }



}
