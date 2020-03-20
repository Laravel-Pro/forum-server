<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = [
        'author_id', 'channel_id',
        'title', 'body', 'rendered',
        'activity_at',
    ];

    protected $hidden = ['rendered'];

    protected $casts = [
        'activity_at' => 'datetime',
    ];

    protected $perPage = 50;

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
