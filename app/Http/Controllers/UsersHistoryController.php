<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersHistoryController extends Controller
{
    public function index()
    {
        return view('usershistory.index')->with('users', User::All());
    }
}
