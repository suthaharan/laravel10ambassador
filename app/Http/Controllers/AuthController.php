<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePassword;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(RegisterRequest $request){
        $user = User::create(
            $request->only('first_name', 'last_name', 'email')
            + [
                'password' => Hash::make($request->input('password')),
                'is_admin' => $request->path() === 'api/admin/register' ? 1 : 0
            ]
        );

        return response($user, Response::HTTP_CREATED);
    }
    // Attempt to login with email and password
    public function login(Request $request){
        if(! \Auth::attempt($request->only('email', 'password' ))){
            return response([
                'error' => 'invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = \Auth::user();
        $adminLogin = ($request->path() === 'api/admin/login');
        if($adminLogin && !$user->is_admin){
            return response([
                'error' => 'Access Denied!'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $scope = $adminLogin ? 'admin' : 'ambassador';

        // Adding in a scope as admin for login
        $jwt = $user->createToken('token', [$scope])->plainTextToken;

        $cookie = cookie('jwt', $jwt, 60*24); //1 day
        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    public function user(Request $request){
        $user = $request->user();
        return new UserResource($user);
    }

    public function logout(){
        $cookie = \Cookie::forget('jwt');
        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    public function updateInfo(UpdateInfoRequest $request){
        $user = $request->user();

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePassword $request){
        $user = $request->user();

        $user->update([
            'password' => \Hash::make($request->input('password'))
        ]);

        return response($user, Response::HTTP_ACCEPTED);
    }
}
