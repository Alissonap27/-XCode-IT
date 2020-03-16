<?php

namespace App\Infrastructure\Eloquent\Usuarios;

use App\Infrastructure\Eloquent\Usuarios\Users;

class UsersRepository
{
    private $eloquent;

    public function __construct(Users $eloquent)
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
}
