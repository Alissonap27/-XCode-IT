@if (isset($errors) && count($errors) > 0)
 <div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Erros encontrados!</strong>
  <ul>
  @foreach($errors->all() as $error)
    <li>{{$error}}</li>
  @endforeach
 </ul>
</div>
@endif
