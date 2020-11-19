<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\User;
use App\Friend;
use Illuminate\Http\Request;
use App\Http\Requests\FriendRequest;
use App\Http\Resources\Friend as ResourcesFriend;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FriendRequestController extends Controller
{
    public function store(FriendRequest $request)
    {
        try {
            User::findOrFail($request['friend_id'])
                ->friends()->attach(auth()->user());
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }

        return new ResourcesFriend(
            Friend::where('user_id', auth()->user()->id)
                ->where('friend_id', $request['friend_id'])
                ->first()
        );
    }
}
