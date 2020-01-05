<?php

namespace App\Http\Controllers;

use App\Repositories\Team\TeamRepository;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function index()
    {
        $teams = $this->teamRepository->all();
        return view('team.index', compact('teams'));
    }

    public function find($id)
    {
        return $this->teamRepository->find($id);
    }

    public function created()
    {
        return view('team.created');
    }

    public function store(Request $request)
    {

        try {
            $this->teamRepository->save($request->all());
            $teams = $this->teamRepository->all();
            return view('team.index', compact('teams'));
        } catch (\Exception $ex) {
            return redirect()->back()->withInput()->with('error', $ex->getMessage());
        }
    }

    public function all()
    {
        return $this->teamRepository->all();
    }
}
