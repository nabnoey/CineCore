<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Store comment
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'movie_id' => 'required|exists:movies,id',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'movie_id' => $request->movie_id,
            'body' => $request->body,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    // Edit comment (เฉพาะเจ้าของ comment)
    public function edit(Comment $comment)
    {
        // ถ้าเป็น admin ก็สามารถ edit ได้เหมือนกัน (ตัวอย่างนี้ admin อาจไม่ต้อง edit)
        if (Auth::user()->role === 'user' && $comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('comments.edit', compact('comment'));
    }

    // Update comment (เฉพาะเจ้าของ comment)
    public function update(Request $request, Comment $comment)
    {
        if (Auth::user()->role === 'user' && $comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'body' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $comment->update($request->only('body', 'rating'));

        return redirect()->route('movies.show', $comment->movie_id);
    }

    // Delete comment (เฉพาะ admin)
    public function destroy(Comment $comment)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can delete comments.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }

    // Like comment (user กดไลค์คนอื่น)
    public function like(Comment $comment)
    {
        if (Auth::id() === $comment->user_id) {
            return back()->with('error', 'You cannot like your own comment.');
        }

        // ตัวอย่างง่ายๆ สมมติมี likes table หรือ column likes_count
        $comment->increment('likes_count');

        return back()->with('success', 'You liked this comment.');
    }
}
