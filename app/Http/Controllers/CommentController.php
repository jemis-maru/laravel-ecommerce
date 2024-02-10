<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $comments = Comment::where('comment', 'LIKE', "%$query%")
                    ->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }
}
