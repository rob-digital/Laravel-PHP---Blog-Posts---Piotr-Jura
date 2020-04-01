<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;
use App\Http\Requests\StorePost;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')   // this will protect every route from this PostController class
            ->only(['store', 'edit', 'update', 'create', 'destroy'])
        ;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::connection()->enableQueryLog();

        // $posts = BlogPost::with('comments')->get();
        // foreach($posts as $post)
        // {
        //     foreach($post->comments  as $comment){
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());


        // it will create 'comments_count' property
        return view('posts.index',
         [
             'posts' => BlogPost::localQueryScopeLatestOnTop()->withCount('comments')->get(),
            'variable_most_commented' => BlogPost::mostCommented()->take(5)->get(),
        ]
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('posts.show',
        [
             'post' => BlogPost::with('comments')->findOrFail($id),  // simple fetch

            // 'post' => BlogPost::with(['comments' => function($query){
            //     return $query->localQueryScopeLatestOnTop();
            // }])->findOrFail($id),                                        // fetching and sorting using method from
                                                                            // using localQueryScopeLatestOnTop from BlogPost/scopeLocalQueryScopeLatestOnTop
        ]);
    }


    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $blogPost = BlogPost::create($validatedData);

        $request->session()->flash('status', 'Blog Post Created Successfully!' );

        // return redirect('/posts')
        return redirect()->route('posts.show', ['post' => $blogPost->id]);

        // if you want to redirect to address that takes some parameter
        // return redirect()->route('posts.show', ['post' => $blogPost->id]);
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize('update', $post);
        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this post");
        // }

        return view('posts.edit', ['post' => $post]);
    }

    public function update(StorePost $request, $anyVariableHere)
    {
        $post = BlogPost::findOrFail($anyVariableHere);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this post");
        // }
        $this->authorize('update', $post);

        $validatedData = $request->validated();

        $post->fill($validatedData);
        $post->save();
        $request->session()->flash('status', 'Blog Post was Updated!' );
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function destroy(Request $request, $someVariable)
    {
        $readPost = BlogPost::findOrFail($someVariable); // deleting this way you make sure that the post actually exists

        // if (Gate::denies('delete-post', $readPost)) {
        //     abort(403, "You can't delete this post");
        // }

        // this works with ---  Gate::define('posts.update', 'App\Policies\BlogPostPolicy@delete');
        $this->authorize('delete', $readPost);

        $readPost->delete();
        // alternatively you can destroy the post directly using the primary key
        //  BlogPost::destroy($id or $someVariable maybe???)

        $request->session()->flash('status', 'Blog Post Deleted!' );

        return redirect()->route('posts.index');
    }

}
