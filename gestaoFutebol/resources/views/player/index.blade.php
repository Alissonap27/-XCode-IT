@extends('layouts.app')
@section('content')
<table align="center"  class="table">
    <tr align="center">
        <td>Nome</td>
        <td>Numero</td>
        <td>Posição</td>
        <td>Time</td>
        <td>Partidas Escaladas</td>
    </tr>
    @foreach ($players as $player)
        <tr align="center">
            <td> {{ $player->getName() }} </td>
            <td> {{ $player->getNumber() }} </td>
            <td> {{ $player->getPosition() }} </td>
            <td> {{ $player->getTeam()->getName() }} </td>
            <td> {{ $player->getPlayed() }} </td>
        </tr>
    @endforeach
</table>
@endsection
