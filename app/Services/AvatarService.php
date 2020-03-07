<?php


namespace App\Services;


use Illuminate\Support\Facades\Storage;

class AvatarService
{
    public function getUserAvatar(string $email)
    {
        $md5 = md5(strtolower(trim($email)));

        $imageUrl = "http://www.gravatar.com/avatar/{$md5}?default=retro&r=g&s=200";

        $avatarPath = substr($md5, 0, 2).'/'.$md5.'.png';
        $image = file_get_contents($imageUrl);

        $path = Storage::disk('avatar')->put($avatarPath, $image);

        return $path ? $avatarPath : 'default-avatar.png';
    }
}
