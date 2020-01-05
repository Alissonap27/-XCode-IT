<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $primaryKey = 'id';
    protected $table = "player";

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getPlayed()
    {
        return $this->played;
    }
}
