<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index()
    {
        $channels = Thread::query()
            ->with([
                'author:id,name,username',
                'channel:id,name,slug',
            ])
            ->orderBy('activity_at', 'DESC')
            ->simplePaginate();

        return JsonResource::collection($channels);
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
