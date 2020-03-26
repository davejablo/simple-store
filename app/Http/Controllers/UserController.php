<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserProfile\UpdateUserProfileRequest;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        return UserResource::collection($this->userRepository->getUsers());
    }

    /**
     * @param User $user
     * @return UserResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user, User::class);
        return new UserResource($this->userRepository->getUser($user)->load('roles'));
    }

    public function getUserProfile(User $user){
        $this->authorize('view', $user, User::class);
        return new UserProfileResource($this->userRepository->getUserProfile($user));
    }

    public function getAuthenticatedProfile(){
        return new UserProfileResource($this->userRepository->getAuthenticatedProfile());
    }
}