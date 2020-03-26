<?php


namespace App\Http\Repositories;
use App\Http\Resources\UserResource;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function getAuthenticatedUser(){
        return $user = auth()->user();
    }

    public function createAndReturnUser($request){
        $newUser = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        if ($newUser->save()){
            return $newUser;
        }
    }

    public  function getUsers(){
        return $users = User::paginate(5);
    }

    public function getUser($user){
        return $userToReturn = User::findOrFail($user->id);
    }

    public function getUserProfile(User $user){
        return $userProfile = $user->profile()->firstOrFail();
    }

    public function getAuthenticatedProfile(){
        return $userProfile = $this->getAuthenticatedUser()->profile()->firstOrFail();
    }
}