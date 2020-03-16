@extends(
	'layouts.templates.lists.crud-list', [
	'modelRoute' => 'users',
	'collection' => $users,
	'tableId' => 'table_users'
])



@section('table-header')
	<tr>
        <th class="text-center" style="width:50%">ID</th>
        <th class="text-center" style="width:20%">Nome</th>
		<th class="text-center" style="width:20%">Data de Cadastro</th>
		<th class="text-center" style="width:10%">Ações</th>
	</tr>
@stop

@section('table-content')
	@foreach($users as $user)
		<tr>
            <td>{{ $user->getId() }}</td>
            <td>{{ $user->getName() }}</td>
			<td>{{ $user->getCreatedAt() }}</td>

			<td class="text-center">
				<div class="col-md-6 text-left">
					<a href="{{ route('users.edit', $user->getId()) }}" title="Editar">
	                	<i class="fa fa-pencil"></i>
	                </a>
				</div>
			</td>
		</tr>
	@endforeach
@stop

@push('final-scripts')
	<script >
		new Vue({
			el: "#table_users"
		})
	</script>
@endpush