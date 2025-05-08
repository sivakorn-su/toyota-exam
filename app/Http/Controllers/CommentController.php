<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
            'is_anonymous' => 'boolean',
        ]);

        Comment::create([
            'topic_id' => $topic->id,
            'content' => $validated['comment'],
            'is_anonymous' => $validated['is_anonymous'] ?? false,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('topics.show', $topic->id)->with('success', 'Comment posted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
