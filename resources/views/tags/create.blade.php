@extends('layouts.app')
@section('content')
	
	<div class="card card-default">
		<div class="card-header">
			{{ isset($tag) ? 'Edit tag' : 'Create tag'}}
		</div>
		<div class="card-body">
			@include('partials.errors')
			<form action="{{ isset($tag) ? route('tags.update', $tag->id) : 
			route('tags.store') }}" method="POST">
				@csrf
				@if (isset ($tag))
				    @method('PATCH')
				@endif
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" id="name" class="form-control" name="name" 
					value="{{ isset($tag) ? $tag->name : '' }}">
				</div>
				<div class="form-group">
					@if (isset($tag))
						<button class="btn btn-success">Update tag</button>
					@else
						<button class="btn btn-success">Add New tag</button>
					@endif
				</div>
			</form>
		</div>
	</div>	
@endsection 