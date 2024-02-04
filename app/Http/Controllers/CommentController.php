<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('product', 'user')->paginate(10);;

        return view('comments.index', compact('comments'));
    }
}
