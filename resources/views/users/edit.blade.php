@extends('layouts.app')

@section('content')
 <div class="card">
    <div class="card-header">My Profile</div>
        <div class="card-body">
            @include('partials.errors')
           <form action="{{ route('users.update-profile') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{$user->name}}">
            </div>

            <div class="form-group">
                <label for="about">About</label>
                <textarea name="about" class="form-control" id="about" cols="5" rows="5">{{$user->about}}</textarea>
            </div>
               
               <button type="submit" class="btn btn-success">Update Profile</button>
           </form>
        </div>
    </div>
@endsection
