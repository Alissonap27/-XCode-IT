<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Repositories\Player\PlayerRepository;
use App\Repositories\Team\TeamRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlayerController extends Controller
{
    private $playerRepository;
    private $teamRepository;

    public function __construct(PlayerRepository $playerRepository, TeamRepository $teamRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->teamRepository = $teamRepository;
    }

    public function index()
    {
        $players = $this->playerRepository->all();
        return view('player.index', compact('players'));
    }

    public function findPlayersByTeam($team_id)
    {
        return $this->playerRepository->find($team_id);
    }

    public function created()
    {
        $team = $this->teamRepository->all()->pluck('name', 'id');
        return view('player.created', compact('team'));
    }

    public function store(PlayerRequest $request)
    {
        try {
            $this->playerRepository->save($request->all());
            $players = $this->playerRepository->all();
            return view('player.index', compact('players'));
        } catch (\Exception $ex) {
            return redirect()->back()->withInput()->with('error', $ex->getMessage());
        }

    }

    public function all()
    {
        return $this->playerRepository->all();
    }
}
