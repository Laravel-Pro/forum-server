<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request)
    {
        $channel_slug = $request->input('channel');

        $query = Thread::query();

        if ($channel_slug) {
            $channel = Channel::query()->where('slug', '=', $channel_slug)->firstOrFail();
            $query->where('channel_id', '=', $channel->id);
        }

        $threads = $query
            ->select([
                'id', 'author_id', 'channel_id',
                'title', 'replies_count',
                'activity_at', 'created_at', 'updated_at'
            ])
            ->with([
                'author:id,name,username,avatar',
                'channel:id,name,slug',
            ])
            ->orderBy('activity_at', 'DESC')
            ->simplePaginate();

        return JsonResource::collection($threads);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO
    }

    /**
     * Display the specified resource.
     *
     * @param Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        // TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        // TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        // TODO
    }
}
