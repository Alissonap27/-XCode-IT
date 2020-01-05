
@extends('layouts.app')
@section('content')

{!! Form::open(['route' => 'team.store', 'method' => 'POST']) !!}
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div id="form_player" class="container" v-cloak>
        @include('errors',['errors'=>$errors])
        <fieldset>
            <legend class="legend-section">Dados do Time</legend>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('name', 'Nome do Time') !!}
                        {!! Form::text('name') !!}
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-plus" aria-hidden="true"></i>  Cadastrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </fieldset>
    </div>
{{ Form::close() }}
@endsection
