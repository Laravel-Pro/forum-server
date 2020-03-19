<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'update', 'destroy']);
    }

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
            ->paginate();

        return JsonResource::collection($threads);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function store(Request $request)
    {
        $input = $this->validate($request, [
            'channel_id' => ['required', 'exists:channels,id'],
            'title' => ['required'],
            'body' => ['required'],
        ]);

        $input['rendered'] = '';
        $input['author_id'] = auth()->id();
        $input['activity_at'] = now();

        $thread = Thread::query()->create($input);

        return JsonResource::make($thread);
    }

    /**
     * Display the specified resource.
     *
     * @param Thread $thread
     * @return JsonResource
     */
    public function show(Thread $thread)
    {
        $thread->load([
            'author:id,name,username,avatar',
            'channel:id,name,slug',
        ]);

        return JsonResource::make($thread);
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
