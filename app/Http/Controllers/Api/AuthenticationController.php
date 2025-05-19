<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        if ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $user->addRole('user');

            $user->token_name = 'register_token';
            return ApiResponse::sendResponse(201, 'register success', new UserResource($user));
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Email or password is not correct', $validator->errors()->all());
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // $roles = $user->roles()->pluck('name')->toArray();
            $user->token_name = 'login_token';
            return ApiResponse::sendResponse(200, 'Login success', new UserResource($user));
            // dd($user);
        } else {
            return ApiResponse::sendResponse(401, 'Unauthorized ,Email or password is not correct ', []);
        }
    }
     public function profile(Request $request)
    {
        $user = $request->user();
        return ApiResponse::sendResponse(
            200,
            'User data fetched successfully',
            $user
        );
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return ApiResponse::sendResponse(401, 'Unauthorized', []);
        }
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200, 'Logout successful', []);
    }
}
