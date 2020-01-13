@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<a href="user/create" class="btn btn-success"><i class="fa fa-plus"></i> Add User</a>
		</div>

		<table class="table table-bordered table-hover" id="table-user">
			<thead>
				<tr class="text-center">
					<th width="5%">No</th>
					<th>Username</th>
					<th>Name</th>
					<th>Address</th>
					<th>Phone</th>
					<th>Level</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
				<tr>
					<td class="text-center">{{ $loop->iteration }}</td>
					<td>{{ $user->username }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->address }}</td>
					<td>{{ $user->phone }}</td>
					<td>{{ $user->level }}</td>
					<td width="16%">
						<div class="d-flex justify-content-center">
							<a href="user/{{$user->id}}/edit" class="btn btn-sm btn-dark mr-3"><i class="fa fa-edit"></i> Edit</a>
							<button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i> Delete</button>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('script')
<script>
	$(document).ready(function() {
		$('#table-user').DataTable();
	});
</script>
@endsection