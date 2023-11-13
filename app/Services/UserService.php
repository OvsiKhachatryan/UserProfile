<?php

namespace App\Services;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function get()
    {
        $users = User::all();

        return $users;
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'string|email|max:255|unique:users,email,'. $request->user()->id,
            'password' => 'string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $request['password'] = Hash::make($request['password']);

        User::where('id', '=', Auth::user()->id)->update($request->all());

        return response()->json('User profile updated');
    }

    public function getByAge(Request $request)
    {
        $users = User::whereBetween('age', [$request->to, $request->from])->get();

        return $users;
    }

    public function getByCity(Request $request)
    {
        $users = User::where('city', '=', $request->city)->get();

        return $users;
    }

    public function search(Request $request)
    {
        $users = User::where('name', 'like', "%{$request->name}%")
            ->where('surname', 'like', "%{$request->surname}%")
            ->get();

        return $users;
    }

    public function addFriend(Request $request)
    {
        $friend = new Friend;
        $friend->from_id = Auth::user()->id;

        if ($request->to_id != Auth::user()->id) {
            $friend->to_id = $request->to_id;
        } else {
            return response()->json('Oops!, you cant sent friend request to yourself');
        }

        $friend->save();

        return $friend;
    }

    public function friendRequestBids()
    {
        $bids = Friend::where('to_id', '=', Auth::user()->id)->get();

        return $bids;
    }

    public function acceptFriendRequest(Request $request)
    {
        Friend::where('from_id', '=', $request->friend_id)
            ->where('to_id', '=', Auth::user()->id)
            ->update(['status' => 1]);

        return response()->json('You have accepted a friend request');

    }

    public function declineFriendRequest(Request $request)
    {
        Friend::where('from_id', '=', $request->friend_id)
            ->where('to_id', '=', Auth::user()->id)
            ->update(['status' => 2]);

        return response()->json('You have declined a friend request');

    }

}
