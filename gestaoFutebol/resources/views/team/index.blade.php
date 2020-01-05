@extends('layouts.app')
@section('content')
<div class="container">
    <table align="center"  class="table">
        <tr>
            <td>Nome</td>
        </tr>
        @foreach ($teams as $team)
            <tr>
                <td> {{ $team->getName() }} </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
