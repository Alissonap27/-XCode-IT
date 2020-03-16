<?php
	(session()->has('errorMessage')) ? $errorMessage = session()->get('errorMessage') : false
?>

@if(isset($errorMessage) && !empty($errorMessage))
    <div class="row">
        <div class="col-md-12">
            <div class='alert alert-danger text-center'>
                {{$errorMessage}}
            </div>
        </div>
    </div>
@endif
