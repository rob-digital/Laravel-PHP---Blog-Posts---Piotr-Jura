<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;
use App\Http\Requests\StorePost;
use App\Image;
use App\User;
use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

// [
//     'show' => 'view',
//     'create' => 'create',
//     'store' => 'create',
//     'edit' => 'update',
//     'update' => 'update',
//     'destroy' => 'delete',
// ]
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
        // $mostCommented = Cache::remember('mostCommentedPosts_uniqueVariable', 60, function() {
        //     return BlogPost::mostCommented()->take(5)->get();
        // });

        // $mostActive = Cache::remember('mostActiveUsers_uniqueVariable', 60, function() {
        //     return User::withMostBlogPosts()->take(5)->get();
        // });

        // $mostActiveLastMonth = Cache::remember('mostActiveUsersLastMonth_uniqueVariable', 60, function() {
        //     return User::withMostBlogPostsLastMonth()->take(5)->get();
        // });


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
            'posts' => BlogPost::latestWithRelations()->get(),
            // 'variable_most_commented' => $mostCommented,
            // 'variable_most_active_users' => $mostActive,
            // 'variable_most_active_last_month' => $mostActiveLastMonth,

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

        $blogPostToBeStored = Cache::remember("blog-post-{$id}", 60, function() use($id){
            return BlogPost::with('comments')
                            ->with('tags')
                            ->with('user')
                            ->with('comments.user')
                            ->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $userKey = "blog-post-{$id}-users";

        $users = Cache::get($userKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach($users as $session => $lastVisit) {
            if($now->diffInMinutes($lastVisit) >= 1) {
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(
            !array_key_exists($sessionId, $users) ||
            $now->diffInMinutes($users[$sessionId]) >= 1
            ) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::forever($userKey, $usersUpdate);

        if(!Cache::has($counterKey)) {
            Cache::forever($counterKey, 1);
        } else {
            Cache::increment($counterKey, $difference);
        }

        $counter = Cache::get($counterKey);



        return view('posts.show',
        [
             'post' => $blogPostToBeStored,  // simple fetch
             'counter' => $counter,

            // 'post' => BlogPost::with(['comments' => function($query){
            //     return $query->localQueryScopeLatestOnTop();
            // }])->findOrFail($id),                                        // fetching and sorting using method from
                                                                            // using localQueryScopeLatestOnTop from BlogPost/scopeLocalQueryScopeLatestOnTop
        ]);
    }

// -------------- create -------------------------------------------------

    public function create()
    {
        return view('posts.create');
    }

// ------------------ store ---------------------------------------------

    public function store(StorePost $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $blogPost = BlogPost::create($validatedData);


        if($request->hasFile('thumbnail')){

            $path = $request->file('thumbnail')->store('thumbnails');
            $blogPost->image()->save(Image::make(['path' => $path]));

            // $file = $request->file('thumbnail');
            // dump($file);
            // dump($file->getClientMimeType());
            // dump($file->getClientOriginalExtension());

            // $file->store('thumbnail');

            // store file using chosen file
            //dump($file->storeAs('thumbnail', $blogPost->id . '.' . $file->guessExtension() ));
        }


        $request->session()->flash('status', 'Blog Post Created Successfully!' );

        // return redirect('/posts')
        return redirect()->route('posts.show', ['post' => $blogPost->id]);

        // if you want to redirect to address that takes some parameter
        // return redirect()->route('posts.show', ['post' => $blogPost->id]);
    }

    //---------------------------edit ---------------------------------------------

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize('update', $post);
        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this post");
        // }

        return view('posts.edit', ['post' => $post]);
    }

    /// --------------------------- update -------------------------------------------

    public function update(StorePost $request, $anyVariableHere)
    {
        $post = BlogPost::findOrFail($anyVariableHere);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this post");
        // }
        $this->authorize('update', $post);

        $validatedData = $request->validated();

        $post->fill($validatedData);

        if($request->hasFile('thumbnail')){

            $path = $request->file('thumbnail')->store('thumbnails');

            if($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(Image::make(['path' => $path]));
            }

        }

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
