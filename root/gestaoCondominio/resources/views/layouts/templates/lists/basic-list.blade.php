@extends('layouts.default')

<?php
	if(!isset($tableClass)) $tableClass = "table-bordered table-hover table-canoastec";
	if(!isset($collection)) throw new \Exception("You should pass a variable called 'collection' to this Template");
?>

@section('content')

	@include('layouts.templates.messages.success')
    @include('layouts.templates.messages.error')
    @include('layouts.templates.messages.errors', ['errors' => $errors])

	@section('before-table') @show

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            @if($collection->count() > 0)
                <div class="table-responsive">
                    <table @if(isset($tableId)) id="{{ $tableId }}" @endif class="table {{ $tableClass }}">
                        <thead>
                            @yield('table-header')
                        </thead>
                        <tbody>
                            @yield('table-content')
                        </tbody>
                    </table>
                </div>

                @include('layouts.templates.paginators.default', ['collection' => $collection])
            @else
                <div id="no_results_found" class="alert alert-info text-center">A busca não retornou resultado. </div>
            @endif
        </div>
    </div>

@stop
