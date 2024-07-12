<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //

    public function addComment(Request $request, $user_id)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $comment = new Comments();
        $comment->user_id = $user_id;
        $comment->comment = $request->comment;
        $comment->save();

        if ($comment) {
            return response()->json(['message' => 'Comment sent successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed to add comment'], 500);
        }
    }
}
