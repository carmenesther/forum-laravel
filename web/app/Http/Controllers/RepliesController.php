<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $channelId
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store($channelId, Thread $thread){

        $this->validate(request(), ['body' => 'required']);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        return back()->with('flash', 'Your reply has been left');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        return back();
    }
}
