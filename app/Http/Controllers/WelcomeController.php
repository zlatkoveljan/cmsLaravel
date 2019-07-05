<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
    	$search = request()->query('search');
    	if ( $search )
    	{
    		$posts = Post::where('title', 'LIKE', "%{$search}%")->simplePaginate(3);    		
    	}
    	else
    	{
    		$posts = Post::simplePaginate(3);
		}
		$user = Auth::user();
		//dd($user);
    	return view('welcome')
    	->with('categories', Category::all())	
    	->with('tags', Tag::all())
		->with('posts', $posts)
		->with('user', $user);
    }
    	
}
