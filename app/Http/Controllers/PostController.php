<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $posts = Post::when(request('keyword'), function($q){
            $keyword = request('keyword');
            $q  ->orWhere('title','like',"%$keyword%")
                ->orWhere('description','like',"%$keyword%");
        })
            ->when(Auth::user()->isAuthor(), function($q){                                  //isAuthor() is from User model
                $q->where('user_id',Auth::id());
            })
            ->latest('id')->paginate(10)->withQueryString();
        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description,50,' ...');
        $post->user_id = Auth::id();
        $post->category_id = $request->category;

        if ($request->hasFile('featuredImage')) {
            $newName = uniqid().'featuredImage.'.$request->file('featuredImage')->extension();
            $request->file('featuredImage')->storeAs('public', $newName);
            $post->featured_image = $newName;
        }

        $post->save();
        return redirect()->route('post.index')->with('status',$post->title.' is successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        Gate::authorize('view',$post);
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        Gate::authorize('update',$post);
        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //Using AuthServiceProvider -> Gate | Gate works before going to Route | cannot update if you are not owner of the post
        // Gate::authorize('update',$post);
        if(Gate::denies('update-post',$post)){
            return abort(403, 'You are not allowed');
        }
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description,50,' ...');
        $post->user_id = Auth::id();
        $post->category_id = $request->category;

        if ($request->hasFile('featuredImage')) {
            //delete old image -->
            Storage::delete('public/'.$post->featured_image);

            //update new image
            $newName = uniqid().'featuredImage.'.$request->file('featuredImage')->extension();
            $request->file('featuredImage')->storeAs('public', $newName);
            $post->featured_image = $newName;
        }
        $post->update();
        return redirect()->route('post.index')->with('status',$post->title.' is successfully updates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(Gate::denies('delete-post',$post)){
            return abort(403,'You are not allowed to view this site');
        }
        if(isset($post->featured_image)){
            Storage::delete('public',$post->featured_image);
        }
        $post->delete();
        return redirect()->route('post.index')->with('status', $post->title.' is successfully deleted');
    }
}
