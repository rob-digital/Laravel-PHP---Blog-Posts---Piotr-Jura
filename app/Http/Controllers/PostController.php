<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;
use App\Http\Requests\StorePost;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index', ['posts' => BlogPost::all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('posts.show', ['post' => BlogPost::findOrFail($id)]);
    }


    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        $validatedData = $request->validated();

        $blogPost = BlogPost::create($validatedData);

        $request->session()->flash('status', 'Blog Post Created Successfully!' );

        // return redirect('/posts')
        return redirect()->route('posts.index');

        // if you want to redirect to address that takes some parameter
        // return redirect()->route('posts.show', ['post' => $blogPost->id]);
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        return view('posts.edit', ['post' => $post]);
    }

    public function update(StorePost $request, $anyVariableHere)
    {
        $post = BlogPost::findOrFail($anyVariableHere);
        $validatedData = $request->validated();

        $post->fill($validatedData);
        $post->save();
        $request->session()->flash('status', 'Blog Post was Updated!' );
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function destroy(Request $request, $someVariable)
    {
        $readPost = BlogPost::findOrFail($someVariable); // deleting this way you make sure that the post actually exists
        $readPost->delete();
        // alternatively you can destroy the post directly using the primary key
        //  BlogPost::destroy($id or $someVariable maybe???)

        $request->session()->flash('status', 'Blog Post Deleted!' );

        return redirect()->route('posts.index');
    }

}
