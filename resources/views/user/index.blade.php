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
							<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $user->id }}"><i class="fa fa-trash-alt"></i> Delete</button>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

{{-- Modal delete --}}
<div class="modal fade" id="modalDelete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h4 class="m-0 text-center">Apakah anda yakin akan menghapus data user?</h4>
				<div class="mt-4 d-flex justify-content-end">
					<form action="" method="POST" id="form-hapus">
						@csrf
						@method('DELETE')
						<input type="text" name="id_hapus" id="id_hapus">
					</form>
					<button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary" id="btn-confirm-delete">Hapus</button>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
<script>
	$(document).ready(function() {
		$('#table-user').DataTable();

		$('.btn-delete').on('click', function(e) {
			let id = $(this).data('id');
			$('#id_hapus').val(id);
			$('#modalDelete').modal('show');
		});

		$('#btn-confirm-delete').on('click', function() {
			let id = $('#id_hapus').val();
			let data = $('#form-hapus').serialize();

			$.ajax({
				url: '{{ url('user') }}' + '/' + id,
				type: 'DELETE',
				data: data,
				cache: false,
				beforeSend: function() {
					$.blockUI({message: '<p class="d-flex align-content-center justify-content-center"><b>Please wait...</b></p>'});
				},
				complete: function() {
					$.unblockUI();
				},
				success: function(response) {
					if(response.status == 200) {
						Swal.fire(
						  	'',
						  	response.msg,
						  	response.type
						)
						.then(val => {
							if(val) window.location.href = '{{ url('user') }}';
						});
					}
				},
				error: function(xhr, stat, err) {
					console.log(err);
				}
			})
			.fail(err => {
				console.log(err);
			});
		});

	});
</script>
@endsection