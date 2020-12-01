<?php

namespace App\Http\Controllers;

use App\User;
use App\Friend;
use Illuminate\Http\Request;
use App\Http\Requests\FriendRequest;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\ValidationErrorException;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Friend as ResourcesFriend;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FriendRequestController extends Controller
{
    public function store()
    {

        try {
            $data = request()->validate([
                'friend_id' => 'required'
            ]);
        } catch (ValidationException $e) {
            throw new ValidationErrorException(json_encode($e->errors()));
        }

        try {
            User::findOrFail($data['friend_id'])
                ->friends()->attach(auth()->user());
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }

        return new ResourcesFriend(
            Friend::where('user_id', auth()->user()->id)
                ->where('friend_id', $data['friend_id'])
                ->first()
        );
    }
}
