@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header">
		<h4 class="m-0">Create User</h4>
	</div>
	<div class="card-body">
		<div class="form-group">
			<button type="button" onclick="window.history.back();" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back</button>
		</div>
		<form action="" method="POST" id="form-user">
			@csrf
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="font-weight-bold" for="username">Username <sup class="text-danger">*</sup></label>
						<input type="text" name="username" id="username" class="form-control" autocomplete="off">
					</div>
					<div class="form-group">
						<label class="font-weight-bold" for="name">Full Name <sup class="text-danger">*</sup></label>
						<input type="text" name="name" id="name" class="form-control">
					</div>
					<div class="form-group">
						<label class="font-weight-bold" for="password">Password <sup class="text-danger">*</sup></label>
						<input type="password" name="password" id="password" class="form-control" autocomplete="off">
					</div>
					<div class="form-group">
						<label class="font-weight-bold" for="password_confirmation">Retype Password <sup class="text-danger">*</sup></label>
						<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="font-weight-bold" for="level">Level <sup class="text-danger">*</sup></label>
						<select name="level" id="level" class="form-control">
							<option value="">Pilih Level</option>
							<option value="Admin">Admin</option>
							<option value="Member">Member</option>
						</select>
					</div>
					<div class="form-group">
						<label class="font-weight-bold" for="address">Address</label>
						<textarea name="address" id="address" class="form-control" rows="6"></textarea>
					</div>
				</div>
				<div class="col-12 d-flex justify-content-center mt-3">
					<button type="button" class="btn btn-success" id="btn-submit">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('script')
<script>
	$(document).ready(function() {
		$('#btn-submit').on('click', function() {
			let form = $('#form-user');

			$.ajax({
				url: '{{ url('user') }}',
				type: 'POST',
				data: form.serialize(),
				cache: false,
				beforeSend: function() {
					$.blockUI({message: '<p class="d-flex align-content-center justify-content-center"><b>Please wait...</b></p>'});
				},
				complete: function() {
					$.unblockUI();
				},
				success: function(response) {
					if(response.status == 201) {
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
					});
				}
			});
		});
	});
</script>
@endsection