<?php

namespace App\Repositories\Team;

use App\Team;

class TeamRepository
{
    private $eloquent;

    public function __construct(Team $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    public function find($id)
    {
        return $this->eloquent->findOrFail($id);
    }

    public function all()
    {
        return $this->eloquent->all();
    }

    public function update(array $attributes)
    {
        $user = $this->eloquent->findOrFail($attributes['id']);
        $user->name = $attributes['name'];

        $user->update();
    }

    public function save(array $attributes)
    {
        $team = $this->eloquent->newInstance();
        $team->name = $attributes['name'];
        $team->save();

    }
}
