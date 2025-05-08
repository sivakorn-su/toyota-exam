<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $topics = Topic::latest()->with('user')->get();

        return Inertia::render('topic/Index', [
            'topics' => $topics,
            'authUser' => $request->user(),
            'flash' => session('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('topic/Create', [
            'authUser' => $request->user(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_anonymous' => 'boolean',
        ]);

        $topic = Topic::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_anonymous' => $validated['is_anonymous'],
            'user_id' => auth()->id(),
        ]);

        ActivityLogger::log("Created topic", ['topic_id' => $topic->id]);

        return redirect()->route('topics.index')->with('success', 'topic created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Topic $topic)
    {
        $topic->load('user', 'comments.user');

        return Inertia::render('topic/Show', [
            'topic' => $topic,
            'authUser' => $request->user(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        if ($topic->user_id !== auth()->id()) {
            return redirect()->route('topics.index')->with('error', 'You are not authorized to edit this topic.');
        }

        return Inertia::render('topic/Edit', [
            'topic' => $topic,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        if ($topic->user_id !== auth()->id()) {
            return redirect()->route('topics.index')->with('error', 'Unauthorized update.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_anonymous' => 'boolean',
        ]);

        $topic->update($validated);

        ActivityLogger::log("Updated topic", ['topic_id' => $topic->id]);

        return redirect()->route('topics.show', $topic->id)->with('success', 'Topic updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        if ($topic->user_id !== auth()->id()) {
            return redirect()->route('topics.index')->with('error', 'Unauthorized deletion.');
        }

        ActivityLogger::log("Deleted topic", ['topic_id' => $topic->id]);

        $topic->delete();

        return redirect()->route('topics.index')->with('flash', 'Topic deleted successfully.');
    }
}
