<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Http\Requests\FriendRequest;
use App\Http\Resources\Friend as ResourcesFriend;
use App\User;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function store(FriendRequest $request)
    {
        User::find($request->friend_id)
            ->friends()->attach(auth()->user());

        return new ResourcesFriend(
            Friend::where('user_id', auth()->user()->id)
                ->where('friend_id', $request->friend_id)
                ->first()
        );
    }
}
