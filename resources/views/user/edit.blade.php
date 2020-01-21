@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header">
		<h4 class="m-0 card-title">Edit User</h4>
	</div>
	<div class="card-body">
		<div class="form-group">
			<button type="button" onclick="window.history.back();" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back</button>
		</div>
		<form action="" method="POST" id="form-user">
			@csrf
			@method('PUT')
			<div class="row">
				<div class="col-12">
					<input type="text" name="username2" id="username2" value="{{ $user->username }}">
					<div class="form-group">
						<label class="font-weight-bold" for="username">Username <sup class="text-danger">*</sup></label>
						<input type="text" name="username" id="username" class="form-control" autocomplete="off" value="{{ $user->username }}">
					</div>
					<div class="form-group">
						<label class="font-weight-bold" for="name">Full Name <sup class="text-danger">*</sup></label>
						<input type="text" name="name" id="name" class="form-control" autocomplete="off" value="{{ $user->name }}">
					</div>
					<div class="form-group">
						<label class="font-weight-bold" for="level">Level <sup class="text-danger">*</sup></label>
						<select name="level" id="level" class="form-control">
							<option value="Admin" @if($user->level == 'Admin') selected @endif>Admin</option>
							<option value="Member" @if($user->level == 'Member') selected @endif>Member</option>
						</select>
					</div>
					<div class="form-group">
						<label class="font-weight-bold" for="address">Address</label>
						<textarea name="address" id="address" class="form-control" rows="6">{{ $user->address }}</textarea>
					</div>
				</div>

				<div class="col-12 d-flex justify-content-center mt-3">
					<button type="submit" class="btn btn-success" id="btn-submit">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('script')
<script>
	$(document).ready(function() {
		$('#btn-submit').on('click', function(e) {
			e.preventDefault();
			let form = $('#form-user');

			$.ajax({
				url: '{{ route('user.update', $user->id) }}',
				type: 'PUT',
				data: form.serialize(),
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
						  	'success'
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
				$('span.text-danger').remove();
				$('.form-control').removeClass('is-invalid');
				if(err.status == 400) {
					$.each(err.responseJSON, (key, val) => {
						let el = $('[id="' + key + '"]');
						let newVal = '<span class="text-danger invalid-feedback">'+val+'</span>'; 
						el.addClass(val.length > 0 ? 'is-invalid' : '');
						el.after(newVal);
						el.focus();
					});
				}
			});
		});
	});
</script>
@endsection