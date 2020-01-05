<?php
namespace App\Services;

use App\Repositories\Player\PlayerRepository;

class PlayerService
{
    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function incrementPlayed($attributes)
    {
        foreach(json_decode($attributes['team_lineup']) as $player){
            $this->playerRepository->incrementPlayed($player);
        }
    }
}
