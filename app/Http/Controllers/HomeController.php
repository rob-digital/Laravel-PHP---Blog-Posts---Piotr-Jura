<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function contact()
    {
        return view('contact');
    }

    public function blog($id, $welcome = 1)
    {
        $pages = [
            1 => [
                'title' => 'page 1'
            ],
            2 => [
                'title' => 'different page 2'
            ],
            ];
            $welcomes = [1 => '<h2>Hello from</h2>', 2 => '<h3></h3>Welcome to</h3>'];

            return view('blog', [
                'data' => $pages[$id],
                'say_hello' => $welcomes[$welcome]
            ]);
    }
}
