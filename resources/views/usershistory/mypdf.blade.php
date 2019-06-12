@extends('layouts.app')

@section('content')
	
	<div class="card card-default">
		<div class="card-header">Users</div>
		<div class="card-body">
            @if ($users->count() > 0)
            
            <div class="col-md-2" align="left">
                <a href="{{ url('usershistory.pdf') }}" class="btn btn-danger">Convert into PDF</a>
            </div>

			<table class="table">
				<thead>
					<th>Image</th>
					<th>Name</th>
					<th>Email</th>
					<th>Ip</th>
					<th>Sum(logins)</th>
					{{-- <th></th>
					<th></th> --}}
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>	
							<img width="40px" height="40px" style="border-radius: 50%" src="{{ Gravatar::src($user->email)}}" alt="">
						</td>
						<td>
							<?php echo $user->name; ?>
						</td>
						<td>
							{{$user->email}}
						</td>
						<td>
							{{$user->ip_address}}
						</td>
						<td>
							{{$user->number_of_logins}}
						</td>
						{{-- <td>

							@if (!$user->isAdmin())
								<form action="{{ route('users.make-admin', $user->id) }}" method="POST">
									@csrf
									<button type="submit" class="btn btn-success btn-sm">Make Admin</button>			
								</form>
							@endif
						</td> --}}
						
					</tr>
					@endforeach
				</tbody>
			</table>
			@else
			<h3 class="text-center">No users yet</h3>
			@endif
		</div>
	</div>
@endsection