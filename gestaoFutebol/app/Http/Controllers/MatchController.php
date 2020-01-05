<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchRequest;
use App\Match;
use App\Repositories\Match\MatchRepository;
use App\Repositories\Team\TeamRepository;
use App\Services\PlayerService;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    private $matchRepository;
    private $teamRepository;
    private $playerService;

    public function __construct(MatchRepository $matchRepository, TeamRepository $teamRepository, PlayerService $playerService)
    {
        $this->matchRepository = $matchRepository;
        $this->teamRepository = $teamRepository;
        $this->playerService = $playerService;

    }

    public function index()
    {
        $matchs = $this->matchRepository->all();
        return view('match.index', compact('matchs'));
    }

    public function find($id)
    {
        return $this->matchRepository->find($id);
    }

    public function created()
    {
        $teams = $this->teamRepository->all();
        return view('match.created', compact('teams'));
    }

    public function store(MatchRequest $request)
    {
        try {
            $this->playerService->incrementPlayed($request->all());
            $this->matchRepository->save($request->all());
            $matchs = $this->matchRepository->all();
            return view('match.index', compact('matchs'));
        } catch (\Exception $ex) {
            return redirect()->back()->withInput()->with('error', $ex->getMessage());        }
    }

    public function all()
    {
        return $this->matchRepository->all();
    }
}
