@extends('layouts.app')
@section('content')
@include('errors',['errors'=>$errors])

<div id="form_player" v-cloak>
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    {!! Form::open(['route' => 'match.store', 'method' => 'POST']) !!}
        <fieldset>
            <legend class="legend-section">Dados da Partida</legend>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('match_date', 'Data da partida') !!}
                        {!! Form::date('match_date', date('d/m/Y'), ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('match_hour', 'Hora da partida') !!}
                        {!! Form::datetime('match_hour', date('H:i'), ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('team_id', 'Time de Casa') !!}
                        <select class="form-control"  name="team_id" id="team_id" v-model="teamId">
                            <option v-if="opposingTeamId != team.id"  v-for="team in teams" :value="team.id"> @{{ team.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('opposing_team_id', 'Time de Fora') !!}
                        <select class="form-control"  name="opposing_team_id" id="opposing_team_id" v-model="opposingTeamId">
                            <option v-if="teamId != team.id" v-for="team in teams" :value="team.id"> @{{ team.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('team_lineup', 'Selecione os Jogadores do Time da casa') !!}
                        <select class="form-control"  @blur="gettineUp($event.target.selectedIndex)">
                            <option  v-for="(player) in ListTeamPlayers"  :value="player"> @{{ player.name }}</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="team_lineup" :value="JSON.stringify(teamLineup)">
            </div>
            <div class="col-md-12 form-group">
                <table align="center"  class="table table-bordered">
                    <tr align="center">
                        <td colspan="3">Escalação</td>
                    </tr>
                    <tr align="center">
                        <td>Nome do Jogador</td>
                        <td>Numero do Jogador</td>
                        <td>Posição do Jogador</td>
                    </tr>
                    <tr align="center" v-for="player in teamLineup">
                        <td>  @{{ teamLineup ? player.name : '' }} </td>
                        <td>  @{{ teamLineup ? player.number : '' }} </td>
                        <td>  @{{ teamLineup ? player.position : ''}}</td>
                    </tr>
                </table>
            </div>
        </fieldset>
        <button type="submit" class="btn btn-primary pull-right" :disabled=" teamLineup == '' ">
            <i class="fa fa-plus" aria-hidden="true"></i>  Cadastrar
        </button>
    {{ Form::close() }}
</div>
<script >
    new Vue({
        el: "#form_player",
        data:{
            teamLineup: [],
            ListTeamPlayers: [],
            teams: JSON.parse('{!! ($teams) !!}'),
            teamId:'',
            opposingTeamId:'',
        },
        methods: {
            teamPlayers(teamId) {
                axios.get('../api/jogadores-time/'+teamId).then(response=>{this.ListTeamPlayers=response.data;});
            },
            gettineUp:function(index){
                this.teamLineup.push(this.ListTeamPlayers[index]);
                this.ListTeamPlayers.splice(index, 1)
            },
        },
        watch: {
            "teamId": function(){ this.teamPlayers(this.teamId); this.teamLineup = [] },
        }
    })
</script>
@endsection
