@extends('layouts.app')
@section('content')
<table align="center"  class="table">
    <tr align="center">
        <td>Partida</td>
        <td>Data da partida</td>
        <td>Atletas Escalados time da casa</td>
    </tr>
    @foreach ($matchs as $match)
        <tr align="center">
            <td> {{ $match->getTeam()->getName() }} X {{ $match->getOpposingTeam()->getName() }}</td>
            <td>
                {{ \Carbon\Carbon::parse($match->getMatchDate())->format('d/m/Y') }} às
                {{ \Carbon\Carbon::parse($match->getMatchHour())->format('H:i') }}
            </td>
            <td>
                @foreach (($match->getTeamLineup()) as $player)
                    {{ $player->name }},
                @endforeach
            </td>
        </tr>
    @endforeach
</table>
@endsection
