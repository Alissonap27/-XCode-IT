@extends('layouts.templates.lists.filter-list')

<?php
	if( !isset($modelRoute) && !isset($createRoute, $indexRoute) ){
		throw new \Exception('You should pass a variable called "modelRoute" containing the route prefix alias or two variables ("createRoute", "indexRoute") for each route');
	}

	if(isset($modelRoute)){
		$createRoute = $modelRoute . '.create';
		$indexRoute = $modelRoute . '.index';
	}
?>

@section('breadcrumb')
  
@stop

@section('before-filter')
	@if(Route::has($createRoute))
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <a class="btn-create" href="{{ route($createRoute) }}">Cadastrar</a>
            </div>
        </div>
    @endif
@stop

@if(Route::has($indexRoute))
	@section('filter-action-url'){{ route($indexRoute) }}@stop
@endif
