
@if(isset($infoMessage) && !empty($infoMessage))
    <div class="row">
        <div class="col-md-12">
            <div class='alert alert-info text-center'>
                {{$infoMessage}}
            </div>
        </div>
    </div>
@endif
