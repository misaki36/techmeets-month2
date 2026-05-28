<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::latest()->get();
        return view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'body' => 'required|max:1000',
        ]);

        $validated['user_id'] = Auth::id();

        Thread::create($validated);

        return redirect()->route('threads.index')->with('success', '投稿しました！');
    }

    public function destroy(Thread $thread)
    {
        if (Auth::id() !== $thread->user_id) {
            abort(403);
        }

        $thread->delete();

        return redirect()->route('threads.index')->with('success', '削除しました！');
    }

    public function show(Thread $thread) {}
    public function edit(Thread $thread) {}
    public function update(Request $request, Thread $thread) {}
} 