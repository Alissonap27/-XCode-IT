@extends('layouts.app')
@section('content')
@include('errors',['errors'=>$errors])

{!! Form::open(['route' => 'player.store', 'method' => 'POST']) !!}
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div id="form_player" v-cloak>
        <fieldset>
            <legend>Dados do Jogador</legend>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('name', 'Nome do Jogador') !!}
                        {!! Form::text('name') !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('number', 'Número do Jogador') !!}
                        {{ Form::number('number', 'number') }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('position', 'Posição do Jogador') !!}
                        {!! Form::text('position') !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('team_id', 'Time') !!}
                        {!! Form::select('team_id', $team, null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary pull-left">
                <i class="fa fa-plus" aria-hidden="true"></i>  Cadastrar
            </button>
        </fieldset>
    </div>
{{ Form::close() }}
@endsection
