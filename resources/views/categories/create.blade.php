@extends('layouts.app')
@section('content')
	
	<div class="card card-default">
		<div class="card-header">
			{{ isset($category) ? 'Edit category' : 'Create category'}}
		</div>
		<div class="card-body">
			@include('partials.errors')
			<form action="{{ isset($category) ? route('categories.update', $category->id) : 
			route('categories.store') }}" method="POST">
				@csrf
				@if (isset ($category))
				    @method('PATCH')
				@endif
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" id="name" class="form-control" name="name" 
					value="{{ isset($category) ? $category->name : '' }}">
				</div>
				<div class="form-group">
					@if (isset($category))
						<button class="btn btn-success">Update Category</button>
					@else
						<button class="btn btn-success">Add New Category</button>
					@endif
				</div>
			</form>
		</div>
	</div>	
@endsection 