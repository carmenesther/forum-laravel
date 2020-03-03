<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Thread;
use App\User;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread){
        return $thread->replies()->paginate(20);
    }

    /**
     * Persist a new reply
     * @param $channelId
     * @param Thread $thread
     * @param CreatePostRequest $form
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\Response
     */

    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        // Inspect the body of their reply for username mentions
        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);

        // And for each one mentioned used, notify them
        foreach ($matches[1] as $name){
            $user = User::whereName($name)->first();

            if($user){
                $user->notify(new YouWereMentioned($reply));
            }
        }

        return $reply->load('owner');

    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            $this->validate(request(), ['body' => 'required|spamfree']);

            $reply->update(request(['body']));
        } catch(\Exception $e){
            return response(
                'Sorry, your reply could not be saved at this time', 422);
        }

    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if(request()->expectsJson()){
            return response(['status' => 'Reply deleted!']);
        }

        return back();
    }

}
