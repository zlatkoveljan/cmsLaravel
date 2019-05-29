<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostsRequest; 
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Storage;

use App\Category;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        //upload the image
        $image = $request->image->store('posts');
        //create the post
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'published_at' => $request->published_at,
            'category_id' => $request->category
        ]);

        //dd($request->tags);
        if ($request->tags)
        {
            $post->tags()->attach($request->tags);
        }
        //flash message
        session()->flash('success', 'Your post has been successfully added');
        //redirect user   
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //$post = Post::withTrashed()->where('id', $id)->firstOrFail();
        $data = $request->all();

        //$data = $request->only(['title', 'description', 'published_at', 'content', 'category_id']);
        //check if new image
        if ($request->hasFile('image'))   //ne vleg ako nema i dr smeneto so slikata...
        {           
            //upload new image
            $image = $request->image->store('posts');
             //delete old one Post function
            $post->deleteImage();
            $data['image'] = $image;
        }
        if ($request->tags)
        {
            $post->tags()->sync($request->tags);
        }
        // go smenuvam klucot... inaku bea razlicni od req i od post, i ne mi praese update...
        $data['category_id'] = $data['category'];
        unset($data['category']);                   
        // dd($data);
        //updating attr
        $post->update($data);
        //flash message
        session()->flash('success', 'Post successfully updated');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $post = Post::withTrashed()->where('id', $id)->firstOrFail();
         if ($post->trashed()){
            //delete old one Post function
            $post->deleteImage();
            $post->forceDelete();
         }else {
            $post->delete();
         }
         session()->flash('success', 'Post deleted successfully');
         return redirect(route('posts.index'));
    }

    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();
        return view('posts.index')->with('posts', $trashed);
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        $post->restore();
        session()->flash('success', 'Post restored successfully');
        return redirect()->back();
    }
}
