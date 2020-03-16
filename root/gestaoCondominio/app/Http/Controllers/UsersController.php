<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Infrastructure\Eloquent\Usuarios\UsersRepository;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $usersRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->usersRepository->all();
        return view('index', compact('users'));
    }

    public function edit($id)
    {
        $user = $this->usersRepository->find($id);
        return view('auth.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $this->usersRepository->update($request->all());
        $users = $this->usersRepository->all();
        return view('index', compact('users'));
    }
}
