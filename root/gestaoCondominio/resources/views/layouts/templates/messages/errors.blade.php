
@if($errors->any())
    <div class="row">
        <div class="col-md-12">
            <div class='alert alert-danger'>
                Ocorreu um erro, preencha corretamente os campos:
                <ul class='error-message' style="margin-top:10px">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
