<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplyController extends Controller
{
    public function index(Thread $thread)
    {
        $replies = $thread->replies()
            ->with([
                'owner:id,name,username,avatar',
            ])
            ->paginate();

        return JsonResource::collection($replies);
    }

    public function store(Thread $thread, Request $request)
    {
        $input = $this->validate($request, [
            'body' => ['required'],
        ]);

        $reply = $thread->replies()->create([
            'body' => $input['body'],
            'user_id' => auth()->id(),
        ]);

        return JsonResource::make($reply);
    }

    public function update(Request $request, Reply $reply)
    {
        //
    }

    public function destroy(Reply $reply)
    {
        //
    }
}
