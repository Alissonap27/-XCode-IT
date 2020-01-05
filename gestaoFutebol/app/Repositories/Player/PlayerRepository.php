<?php

namespace App\Repositories\Player;

use App\Player;

class PlayerRepository
{
    private $eloquent;

    public function __construct(Player $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    public function find($team_id)
    {
        $query = $this->eloquent->newQuery();
        return $query->where('team_id', $team_id)->get();
    }

    public function all()
    {
        return $this->eloquent->all();
    }

    public function save(array $attributes)
    {
        $player = $this->eloquent->newInstance();
        $player->name = $attributes['name'];
        $player->number = $attributes['number'];
        $player->position = $attributes['position'];
        $player->team_id = $attributes['team_id'];
        $player->save();

    }


    public function incrementPlayed($player)
    {
        $player = $this->eloquent->findOrFail($player->id);
        $player->increment('played');
    }

}
