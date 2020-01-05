<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $primaryKey = 'id';
    protected $table = "team";

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

}
