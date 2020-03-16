<div class="row">
	<div class="col-md-12">
		@if(method_exists($collection, 'appends'))
		    <div class="pull-left paginator-default">
		        {!! $collection->appends(Request::except('page'))->render() !!}
		    </div>
        @endif
	    <div id="total_results" class="pull-right">
	        A busca retornou 
	        <strong id="count_results">
        		@if(method_exists($collection,'total'))
	        		{!! $collection->total() !!}
        		@else
        			{!! $collection->count() !!}
        		@endif
        	</strong> 
	        registro(s)
        </div><br><br>
        @yield('after-table')
    </div>
</div>