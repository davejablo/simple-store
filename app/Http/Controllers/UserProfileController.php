<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfile\UpdateUserProfileRequest;
use App\Http\Resources\UserProfileResource;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * @param UpdateUserProfileRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateUserProfileRequest $request, $id)
    {
        $profileFromDb = UserProfile::findOrFail($id);
        $this->authorize('update', $profileFromDb, UserProfile::class);

        $profileFromDb->update($request->validated());
        $updatedProfile = new UserProfileResource(UserProfile::findOrFail($id));

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Task updated',
            'data' => [
                'item' => $updatedProfile,
            ]
        ], 200);
    }

//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//    }

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//    }

//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\UserProfile  $userProfile
//     * @return \Illuminate\Http\Response
//     */
//    public function show(UserProfile $userProfile)
//    {
//    }

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\UserProfile  $userProfile
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(UserProfile $userProfile)
//    {
//    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\UserProfile  $userProfile
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(UserProfile $userProfile)
//    {
//    }
}
