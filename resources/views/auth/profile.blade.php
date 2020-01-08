@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header">
		<h6 class="m-0 font-weight-bold text-dark">Profile</h6>
	</div>
	<div class="card-body">
		<a href="/ganti-password/{{$user->id}}" class="btn btn-info btn-sm">Change Password</a>
	</div>
</div>
@endsection