<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\FriendRequestNotification;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get  (
     *     path="/api/users",
     *     summary="Get users list",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *     @OA\Response(response="200", description="Users list"),
     * )
     */

    public function get()
    {
        return $this->userService->get();
    }

    /**
     * @OA\Put (
     *     path="/api/user/edit",
     *     summary="Edit user profile",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="User's name",
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="surname",
     *         in="query",
     *         description="User's surname",
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\Parameter(
     *         name="age",
     *         in="query",
     *         description="User's age",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="User's city",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User updated successfully"),
     * )
     */

    public function edit(Request $request)
    {
        return $this->userService->edit($request);
    }

    /**
     * @OA\Get (
     *     path="/api/users/by/age",
     *     summary="Filter users by age",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *    @OA\Parameter(
     *         name="to",
     *         in="query",
     *         description="From",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="from",
     *         in="query",
     *         description="To",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="User filtered successfully"),
     * )
     */

    public function getByAge(Request $request)
    {
        return $this->userService->getByAge($request);
    }

    /**
     * @OA\Get (
     *     path="/api/users/by/city",
     *     summary="Filter users by city",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *    @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="User's city",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User filtered successfully"),
     * )
     */

    public function getByCity(Request $request)
    {
        return $this->userService->getByCity($request);
    }

    /**
     * @OA\Get (
     *     path="/api/users/search",
     *     summary="Search users",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="User's name",
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="surname",
     *         in="query",
     *         description="User's surname",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Users searched successfully"),
     * )
     */

    public function search(Request $request)
    {
        return $this->userService->search($request);
    }

    /**
     * @OA\Post  (
     *     path="/api/add/friend",
     *     summary="Add friend",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *     @OA\Parameter(
     *         name="to_id",
     *         in="query",
     *         description="User's to id",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Friend request sent successfully"),
     * )
     */

    public function addFriend(Request $request)
    {
        $user = User::find($request->to_id);
        $user->notify(new FriendRequestNotification($request->user_id));

        return $this->userService->addFriend($request);
    }

    /**
     * @OA\Get (
     *     path="/api/friend/request/bids",
     *     summary="Friend requests",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *     @OA\Response(response="200", description="Friend request bids"),
     * )
     */

    public function friendRequestBids()
    {
        return $this->userService->friendRequestBids();
    }

    /**
     * @OA\Put  (
     *     path="/api/friend/request/accept",
     *     summary="Friend request accept",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *     @OA\Parameter(
     *         name="friend_id",
     *         in="query",
     *         description="User's friend_id",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Friend request accepted"),
     * )
     */

    public function acceptFriendRequest(Request $request)
    {
        return $this->userService->acceptFriendRequest($request);
    }

    /**
     * @OA\Put  (
     *     path="/api/friend/request/decline",
     *     summary="Friend request decline",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *     @OA\Parameter(
     *         name="friend_id",
     *         in="query",
     *         description="User's friend_id",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Friend request declined"),
     * )
     */

    public function declineFriendRequest(Request $request)
    {
        return $this->userService->declineFriendRequest($request);
    }

}
