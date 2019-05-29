<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\Users\UpdateProfileRequest;



class UsersController extends Controller
{
    public function index()
    {
    	// dd(User::All());
    	return view('users.index')->with('users', User::All());
    }

    public function makeAdmin(User $user)
    {
    	//dd(User::All());
    	$user->role = 'admin';
    	$user->save();
    	session()->flash('success', 'User given admin rights successfully');
    	return redirect(route('users.index'));
    }

    public function edit()
    {
    	return view('users.edit')->with('user', auth()->user());
    }

    public function update(UpdateProfileRequest $request)
    {
    	$user = auth()->user();
    	$user->update([
    		'name' => $request->name,
    		'about' => $request->about
    	]);
    	session()->flash('success', 'User updated successfully');
    	return redirect()->back();
    }
}
