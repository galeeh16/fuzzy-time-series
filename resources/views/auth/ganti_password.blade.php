@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header">
		<h6 class="text-dark font-weight-bold m-0">Ganti Password</h6>
	</div>
	<div class="card-body">
		<div class="form-group">
			<button type="button" class="btn btn-sm btn-dark" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Back</button>
		</div>
		<form method="post" id="form-ganti-password">
			@csrf 
			@method('PUT')
			<input type="hidden" name="id" value="{{ $user->id }}">
			<div class="form-group">
				<label for="" class="small font-weight-bold">Old Password</label>
				<input type="password" name="old_password" id="old_password" class="form-control form-control-sm" autocomplete="off">
			</div>
			<div class="form-group">
				<label for="" class="small font-weight-bold">New Password</label>
				<input type="password" name="new_password" id="new_password" class="form-control form-control-sm" autocomplete="off">
			</div>
			<div class="form-group">
				<label for="" class="small font-weight-bold">New Password</label>
				<input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control form-control-sm" autocomplete="off">
			</div>
			<div class="form-group">
				<button type="button" id="btn-submit" class="btn btn-sm btn-primary"><i class="fa fa-paper-plane"></i> Change Password</button>
			</div>
		</form>
	</div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
	$('#btn-submit').on('click', function() {
		let data = $('#form-ganti-password').serialize();
		let id = $('[name="id"]').val();

		$.ajax({
			url: '{{ url('ganti-password') }}' + '/' + id,
			data: data,
			type: 'PUT',
			cache: false,
			beforeSend: function() {
				$.blockUI({ message: '<div style="padding: 4px;"><img src="{{ asset('spinner/spinner.gif') }}" width="30px" /> Sedang memproses...</div>' });
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
						if(val) {
							window.location.href = '{{ url('home') }}';
						}
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
			$('#new_password_confirmation').val('');
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